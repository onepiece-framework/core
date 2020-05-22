<?php
/**
 * Unit.class.php
 *
 * @created   2016-11-28
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @created   2019-02-20
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
	 * @created
	 * @updated 2019-06-13  To simplified.
	 * @param   string      $name
	 */
	static function Load($name)
	{
		//	...
		if(!$dir = RootPath('asset') . 'unit/' ){
			throw new Exception('Has not been set meta root of unit.');
		};

		//	...
		$path = $dir . strtolower($name) . '/index.php';

		//	...
		if(!file_exists($path) ){
			throw new Exception("Does not exists index.php file. ($path)");
		};

		//	...
		return require_once($path);
	}

	/** Singleton
	 *
	 * @created  2019-09-18
	 * @deprecated
	 * @param    string      $name
	 * @return   object      $unit
	 */
	static function Singleton($name)
	{
		return Unit($name);
	}
}
