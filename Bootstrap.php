<?php
/**
 * Bootstrap.php
 *
 * @creation  2015-12-10
 * @rebirth   2016-06-09
 * @version   1.0
 * @package   core7
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

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
	global $_OP;

	// Do compress path.
	$root['App:/'] = $_OP['APP_ROOT'];
	$root['OP:/']  = $_OP['OP_ROOT'];
	$root['Doc:/'] = $_SERVER['DOCUMENT_ROOT'];
	foreach( $root as $key => $var ){
		if( strpos($path, $var) === 0 ){
			$path = substr($path, strlen($var));
			return $key.$path;
		}
	}

	return $path;
}

/**
 * Expand to local file path from meta path.
 *
 * <pre>
 * print ExpandPath('App:/index.php'); // -> /www/localhost/index.php
 * </pre>
 *
 * @param  string $meta_path
 * @return string
 */
function ExpandPath($path)
{
	global $_OP;

	// Do compress path.
	$root['App:/'] = $_OP['APP_ROOT'];
	$root['OP:/']  = $_OP['OP_ROOT'];
	$root['Doc:/'] = $_SERVER['DOCUMENT_ROOT'];
	foreach( $root as $key => $var ){
		if( strpos($path, $key) === 0 ){
			$path = substr($path, strlen($key));
			return $var.$path;
		}
	}

	return $path;
}

/**
 * Security: PHP_SELF has XSS risk.
 */
$_SERVER['PHP_SELF_XSS'] = htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES);
$_SERVER['PHP_SELF'] = $_SERVER['SCRIPT_NAME'];

/**
 * OP_ROOT, APP_ROOT
 */
$_OP['OP_ROOT']  = __DIR__.'/';
$_OP['APP_ROOT'] = dirname($_SERVER['SCRIPT_FILENAME']).'/';

/**
 * Register autoloader.
 */
include(__DIR__.'/Autoloader.class.php');
if(!spl_autoload_register('Autoloader::Autoload',true,true)){
	function __autoload($class){
		Autoloader::Autoload($class);
	}
}

/**
 * Check mbstring installed.
 */
if(!function_exists('mb_language') ){
	include(__DIR__.'/Template/Introduction/Php/Mbstring.phtml');
	exit();
}
