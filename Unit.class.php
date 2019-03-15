<?php
/**
 * Unit.class.php
 *
 * @creation  2016-11-28
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @creation  2019-02-20
 */
namespace OP;

/** Used class
 *
 */
use Exception;

/** Unit
 *
 * <pre>
 * //	Set unit directory.
 * Unit::Director('app:/asset/unit');
 *
 * //	Get instance.
 * $obj = Unit::Instance('UnitName');
 *
 * //	Load static class.
 * Unit::Load('unitname');
 *
 * //	Use static class.
 * $val = OP\UNIT\NAME::Get();
 * </pre>
 *
 * @creation  2016-11-28
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Unit
{
	/** trait.
	 *
	 */
	use OP_CORE;

	/** Return new instance.
	 *
	 * @param  string $name
	 * @return object
	 */
	static function Instantiate($name)
	{
		//	...
		if(!self::Load($name)){
			return false;
		}

		//	Generate name space path.
		$class = '\OP\UNIT\\'.$name;

		//	Instantiate.
		if(!class_exists($class, true) ){
			throw new Exception("Has not been exists class. ($class)");
		};

		//	...
		$classes = class_implements($class);

		//	Check IF_UNIT is implemented.
		if(!isset($classes['OP\IF_UNIT']) ){
			throw new Exception("This unit has not implemented IF_UNIT. ($class)");
		};

		//	Check implemented restriction.
		switch( strtolower($name) ){
			case 'form':
			case 'database':
			case 'sql':
				//	...
				$key = "OP\IF_".strtoupper($name);

				//	...
				if(!isset($classes[$key]) ){
					throw new Exception("This unit has not implemented {$key}. ($name)");
				};
			break;
		};

		//	...
		return new $class();
	}

	/** Load of unit controller.
	 *
	 * @param string $name
	 */
	static function Load($name)
	{
		//	...
		static $_result = [];
		static $_dir;

		//	...
		$name = strtolower($name);

		//	...
		if( isset( $_result[$name] ) ){
			return $_result[$name];
		};

		//	...
		if(!$_dir ){
			//	...
			if(!$_dir = Env::Get('unit')['directory'] ?? null ){
				throw new Exception('Has not been set unit directory.');
			};

			//	...
			$_dir = ConvertPath($_dir);

			//	...
			if(!file_exists($_dir)){
				throw new Exception("Does not exists unit directory. ($_dir)");
			};
		};

		//	...
		if(!file_exists("{$_dir}/{$name}") ){
			throw new Exception("Does not exists this unit. ($name)");
		};

		//	...
		$path = "{$_dir}/{$name}/index.php";

		//	...
		if(!file_exists($path) ){
			throw new Exception("Does not exists unit controller. ($path)");
		};

		//	...
		$_result[$name] = call_user_func(function($path){
			return include($path);
		}, $path);

		//	...
		return $_result[$name];
	}
}
