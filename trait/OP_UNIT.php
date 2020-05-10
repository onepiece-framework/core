<?php
/**
 * OP_UNIT.php
 *
 * @created   2019-02-21
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @created   2019-02-21
 */
namespace OP;

/** OP_UNIT
 *
 * @created   2019-02-21
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
trait OP_UNIT
{
	/** Config
	 *
	 * @created   2019-12-13   Moved from Env::Get().
	 */
	static function Config($config=null)
	{
		//	...
		static $_config;

		//	Get class name.
		$class_name = self::_ClassName();

		//	Force lower case.
		$class_name = strtolower($class_name);

		//	Check by class name whether config is initialized.
		if( empty($_config[$class_name]) ){
			//	Since config is empty, load the file if it exists.
			if( file_exists($path = ConvertPath("asset:/config/{$class_name}.php")) ){
				//	Since the file exists, it is loaded only once.
				$_config[$class_name] = require_once($path);
			}
		}

		/** About array merge.
		 *
		 *  array_replace_recursive() is all replace.
		 *  array_merge_recursive() is number index is renumbering.
		 *
		 * @copied    2019-12-13   Moved from Env::Set().
		 */
		//	self::$_env[$key] = array_merge_recursive(self::$_env[$key], $var);
		if( $config ){
			$_config[$class_name] = array_replace_recursive($_config[$class_name], $config);
		}

		//	...
		return $_config[$class_name];
	}

	/** Unit
	 *
	 *  Always return instantiated instance.
	 *  That so-called "Singleton" or "Factory method".
	 *
	 * @created
	 * @param     string       $name
	 * @return    object       IF_UNIT
	 */
	static function Unit($name)
	{
		//	...
		return Unit($name);

		/*
		//	...
		Notice::Set('This method will obsolete. Please usage following method.'.PHP_EOL."Unit::Singleton({$name})");

		//	...
		return Unit::Singleton($name);
		*/
	}

	/** Testcase
	 *
	 * @created   2019-12-13
	 * @param     array        $args
	 */
	/*
	static function Testcase($args)
	{
		//	Get class name.
		$name = self::_ClassName();

		//	Generate testcase controlloer path.
		$path = ConvertPath('unit:/') . $name . '/testcase/index.php';

		//	Check if exists.
		if(!file_exists($path) ){
			throw new \Exception("index.php file does not exists. ($path)");
		}

		//	include controlloer.
		call_user_func(function($path, $args){
			include($path);
		}, $path, $args);
	}
	*/
}
