<?php
/** ConvertPath.php
 *
 * @created   2020-05-10
 * @version   1.0
 * @package   op-core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 */
namespace OP;

/** Convert to local file path from meta path.
 *
 * <pre>
 * print ConvertPath('app:/index.php'); // -> /www/localhost/index.php
 * </pre>
 *
 * @param  string $meta_path
 * @return string
 */
function ConvertPath(string $path, bool $check_file_exists=true):string
{
	//	Parent path.
	if( strpos($path, '..') !== false ){
		throw new \Exception("Passed parent path. ($path)");
	}

	//	Check meta label
	if( $pos = strpos($path, ':/') ){
		//	Get meta label.
		$meta = substr($path, 0, $pos);

		//	Check exists meta label.
		if(!$root = RootPath($meta) ){
			throw new \Exception("This meta label is not exists. ($path)");
		};

		//	...
		$path = $root . substr($path, $pos+2);

		//	Check if directory
		if( is_dir($path) ){
			//	Added slash to tail.
			$path = rtrim($path, '/') . '/';
		}

	}else{
		//	Add current directory.
		$path = getcwd() . '/' . $path;
	};

	// Check if file exists.
	if( $check_file_exists and !file_exists($path) ){
		throw new \Exception("File is not exists. ($path)");
	}

	//	Return calculated value.
	return $path;
}
