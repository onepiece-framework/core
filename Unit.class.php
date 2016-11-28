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
 * @creation  2016-11-28
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Unit extends OnePiece
{
	const _DIRECTORY_ = 'unit-dir';

	/**
	 * Pooling of object. (singleton)
	 *
	 * @var array
	 */
	static $_pool;

	/**
	 * Get instance. (singleton)
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
		if(!$dir = Env::Get(self::_DIRECTORY_)){
			Notice::Set("Has not been set unit directory.");
			return false;
		}

		//	...
		$dir = ConvertPath($dir);

		//	...
		if(!file_exists($dir)){
			Notice::Set("Does not exists unit directory.");
			return false;
		}

		//	...
		if(!file_exists("{$dir}/{$name}")){
			Notice::Set("Does not exists this unit. ($name)");
			return false;
		}

		//	...
		if(!file_exists("{$dir}/{$name}/index.php")){
			Notice::Set("Does not exists unit controller. (index.php)");
			return false;
		}

		//	...
		include("{$dir}/{$name}/index.php");
		self::$_pool[$name] = new $name();
		return self::$_pool[$name];
	}
}