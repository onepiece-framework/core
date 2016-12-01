<?php
/**
 * Functions.php
 *
 * @creation  2016-11-16
 * @version   1.0
 * @package   core7
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/**
 * Return meta root path array.
 *
 * @return array
 */
function _GetRootsPath()
{
	global $_OP;
	$root['app:/'] = $_OP['APP_ROOT'];
	$root['op:/']  = $_OP['OP_ROOT'];
	$root['doc:/'] = $_SERVER['DOCUMENT_ROOT'];
	return $root;
}

/**
 * Compress to meta path from local file path.
 *
 * <pre>
 * print CompressPath(__FILE__); // -> App:/index.php
 * </pre>
 *
 * @param  string $file_path
 * @return string
 */
function CompressPath($path)
{
	foreach( _GetRootsPath() as $key => $var ){
		if( strpos($path, $var) === 0 ){
			$path = substr($path, strlen($var));
			return $key.$path;
		}
	}
	return $path;
}

/**
 * Convert to local file path from meta path.
 *
 * <pre>
 * print ConvertPath('app:/index.php'); // -> /www/localhost/index.php
 * </pre>
 *
 * @param  string $meta_path
 * @return string
 */
function ConvertPath($path)
{
	foreach( _GetRootsPath() as $key => $var ){
		if( strpos($path, $key) === 0 ){
			$path = substr($path, strlen($key));
			return $var.$path;
		}
	}
	return $path;
}

/**
 * Convert url from meta path to document root path.
 *
 * <pre>
 * print ConvertURL('app:/index.php'); // -> /index.php
 * </pre>
 *
 * @param  string $meta_url
 * @return string
 */
function ConvertURL($url)
{
	$rewrite_base = dirname($_SERVER['SCRIPT_NAME']);
	return $rewrite_base.substr($url,4);
}

/**
 * Dump value for developers only.
 *
 * @param boolean|integer|string|array|object $value
 */
function D($value=null)
{
	//	If not admin will skip.
	if(!Env::isAdmin()){
		return;
	}

	//	null is explicit.
	if( is_null($value) ){
		$value = func_num_args() ? null: '';
	}

	//	Get trace.
	if( version_compare('5.4.0', PHP_VERSION) >= 1 ){
		$trace = debug_backtrace( DEBUG_BACKTRACE_PROVIDE_OBJECT || DEBUG_BACKTRACE_IGNORE_ARGS );
	}else{
		$trace = debug_backtrace( DEBUG_BACKTRACE_PROVIDE_OBJECT || DEBUG_BACKTRACE_IGNORE_ARGS, 1);
	}

	//	Dump.
	Developer::Mark($value, $trace[0]);
}

/**
 * Escape mixid value;
 *
 * @param  boolean|integer|string|array|object $var
 * @return boolean|integer|string|array|object
 */
function Escape($var)
{
	switch( $type = gettype($var) ){
		case 'string':
			return _EscapeString($var);

		case 'array':
			$var = _EscapeArray($var);
			break;

		case 'object':
			Notice::Set("Objects are not yet supported.");
			break;

		default:
	}
	return $var;
}

/**
 * Escape array.
 *
 * @param  array $arr
 * @return array
 */
function _EscapeArray($arr)
{
	$new = [];
	foreach( $arr as $key => $var ){
		$new[_EscapeString($key)] = Escape($var);
	}
	return $new;
}

/**
 * Escape string.
 *
 * @param  string $var
 * @return string
 */
function _EscapeString($var)
{
	return htmlentities($var, ENT_QUOTES, 'utf-8', false);
}

/**
 * ifset
 *
 * @see    http://qiita.com/devneko/items/ee83854eb422c352abc8
 * @param  mixed $check
 * @param  mixed $alternate
 * @return mixed
 */
function ifset(&$check, $alternate = NULL)
{
	return (isset($check)) ? $check : $alternate;
}
