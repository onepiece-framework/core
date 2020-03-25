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
		//	Automatically load unit.
		if(!self::Load($name)){
			return false;
		}

		//	Generate name space path.
		$class = '\OP\UNIT\\'.$name;

		//	Instantiate.
		if(!class_exists($class, true) ){
			throw new Exception("Has not been exists class. ($class)");
		};

		//	Get the interface implemented by the class.
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
				//	Generate interface name.
				$key = "OP\IF_".strtoupper($name);

				//	Check to implemented.
				if(!isset($classes[$key]) ){
					throw new Exception("This unit has not implemented {$key}. ($name)");
				};
			break;
		};

		//	Return new instance.
		return new $class();
	}

	/** Load of unit controller.
	 *
	 * @param  string  $name
	 * @return boolean $io
	 */
	static function Load($name)
	{
		//	Shared under app.
		static $_result = [];
		static $_dir;

		//	Label of unit name is always lower case.
		$name = strtolower($name);

		//	Already loaded.
		if( isset( $_result[$name] ) ){
			return $_result[$name];
		};

		//	If dir is empty, find dir.
		if(!$_dir ){
			//	Get meta path from config file.
			if(!$_dir = Env::Get('unit')['directory'] ?? null ){
				throw new Exception('Has not been set unit directory.');
			};

			//	Change to real path from meta path.
			$_dir = ConvertPath($_dir);

			//	Does not exists this unit directory.
			if(!file_exists($_dir)){
				throw new Exception("Does not exists this unit directory. ($_dir)");
			};

			//	Register meta path.
			RootPath('unit', $_dir);
		};

		//	Path of file that initialize unit.
		$path = "{$_dir}/{$name}/index.php";

		//	Does not exists this unit.
		if(!file_exists("{$_dir}/{$name}") ){
			throw new Exception("Does not exists this unit. ($name)");
		};

		//	Does not exist file that initialize unit.
		if(!file_exists($path) ){
			throw new Exception("Does not exist file that initialize unit. ($path)");
		};

		//	Initialize of unit.
		$_result[$name] = call_user_func(function($path){
			return include($path);
		}, $path);

		//	Return result.
		return $_result[$name];
	}

	/** Singleton
	 *
	 * @created  2019-09-18
	 * @param    string      $name
	 * @return   object      $unit
	 */
	static function & Singleton($name)
	{
		return Unit($name);
	}
}

/** Unit is factory singleton.
 *
 * @created   2020-03-06
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
function Unit($name)
{
	//	...
	static $_unit;

	//	...
	if( empty($_unit[$name]) ){
		$_unit[$name] = Unit::Instantiate($name);
	}

	//	...
	return $_unit[$name];
}
