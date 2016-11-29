<?php
/**
 * Autoloader.class.php
 *
 * @creation  2014-11-29
 * @rebirth   2016-06-09
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/**
 * Autoloader
 *
 * @creation  2014-11-29
 * @rebirth   2016-06-09
 * @version   1.0
 * @package   core7
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Autoloader
{
	/**
	 * @var array
	 */
	static $_include_path;

	/**
	 * Autoload.
	 *
	 * @param string $class_name
	 */
	static function Autoload($class_name)
	{
		global $_OP;

		//	Correspond namespace.
		$class_name = str_replace('OP\\', '', $class_name);

		//	Generate file name;
		$file_name = "{$class_name}.class.php";

		//	Initialization is only the first.
		if(!self::$_include_path ){

			//	Current directory.
			self::$_include_path[] = '.';

			//	Add op-core's root.
			self::$_include_path[] = $_OP['OP_ROOT'];
		}

		//	Challenge to include.
		foreach( self::$_include_path as $path ){
			$file_path = rtrim($path, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.$file_name;
			if( $io = file_exists($file_path) ){
				$io = include_once($file_path);
			}
		}
	}
}
