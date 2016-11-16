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
