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

/**
 * Unit
 *
 * <pre>
 * //	Set unit directory.
 * Env::Set(Unit::_DIRECTORY_, '/www/op/7/unit/');
 *
 * //	Factory
 * $obj = Unit::Factory('UnitName');
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

	/** Search directory.
	 *
	 * @var string
	 */
	const _DIRECTORY_ = 'unit-dir';

	/** Pooling of object. (singleton)
	 *
	 * @var array
	 */
	static $_pool;

	/** Return instance. (singleton)
	 *
	 * @param  string $name
	 * @return boolean|object
	 */
	static function Factory($name)
	{
		//	...
		if( isset( self::$_pool[$name] ) ){
			return self::$_pool[$name];
		}

		//	...
		if(!self::Load($name)){
			return false;
		}

		//	Instantiate.
		self::$_pool[$name] = new $name();
		return self::$_pool[$name];
	}

	/** Load of unit controller.
	 *
	 * @param string $name
	 */
	static function Load($name)
	{
		//	...
		if(!$dir = Env::Get(self::_DIRECTORY_)){
			$message = "Has not been set unit directory.\n".' Example: Env::Set(Unit::_DIRECTORY_, "/www/op/unit");';
			Notice::Set($message, debug_backtrace());
			return false;
		}

		//	...
		$dir = ConvertPath($dir);

		//	...
		if(!file_exists($dir)){
			$message = "Does not exists unit directory.";
			Notice::Set($message, debug_backtrace());
			return false;
		}

		//	...
		if(!file_exists("{$dir}/{$name}")){
			$message = "Does not exists this unit. ($name)";
			Notice::Set($message, debug_backtrace());
			return false;
		}

		//	...
		if(!file_exists("{$dir}/{$name}/index.php")){
			$message = "Does not exists unit controller. (index.php)";
			Notice::Set($message, debug_backtrace());
			return false;
		}

		//	...
		return include("{$dir}/{$name}/index.php");
	}
}