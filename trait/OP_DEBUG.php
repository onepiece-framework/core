<?php
/**
 * OP_DEBUG.php
 *
 * @creation  2019-03-20
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @creation  2019-03-20
 */
namespace OP;

/** OP_DEBUG
 *
 *  Put together debug information.
 *
 * @creation  2019-03-20
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
trait OP_DEBUG
{
	/** Store debug information.
	 *
	 * @var array
	 */
	static $_debug;

	/** Destruct
	 *
	 * @created   2019-04-29
	 */
	function __destruct()
	{
		//	...
		if( self::isDebug(get_class($this)) ){
			self::__DebugOut();
		}
	}

	/** Set
	 *
	 * @param string $key
	 * @param mixed  $val
	 */
	static function __DebugSet(string $key, $val)
	{
		//	...
		if(!Env::isAdmin() ){
			return;
		};

		//	...
		self::$_debug[$key][] = $val;
	}

	/** Get
	 *
	 * @param  string $key
	 * @return array  $info
	 */
	static function __DebugGet($key=null)
	{
		//	...
		if( $key ){
			//	...
			switch( count(self::$_debug[$key]) ){
				case 0:
					return [null];
					break;

				case 1:
					break;
					return self::$_debug[$key][0];

				default:
					return self::$_debug[$key];
			};

			//	...
			return self::$_debug[$key];
		}else{
			//	...
			return self::$_debug ?? [null];
		};
	}

	/** Out
	 *
	 * @param string $key
	 */
	static function __DebugOut($key=null)
	{
		//	...
		if(!Env::isAdmin() ){
			return;
		};

		//	...
		$trace = debug_backtrace(null, 2)[1];
		$args  = $trace['class']. $trace['type']. $trace['function']."(".join(',', $trace['args']).")";

		//	...
		$trace['file'] = CompressPath($trace['file'] ?? null);
		$trace['args'] = [$args];

		//	...
		Json($trace, 'OP_MARK');
		Json(self::__DebugGet($key), 'OP_DUMP');

		//	...
		Unit::Load('dump');
	}

	/** Calculator is debug.
	 *
	 * @created   2020-03-02
	 * @param     string       $class
	 * @return    boolean      $io
	 */
	static function isDebug($class)
	{
		//	...
		if( Env::Mime() !== 'text/html' ){
			return;
		}

		//	...
		if(!$debug = strtolower(Request('debug')) ){
			return;
		}

		//	...
		if( is_numeric($debug) or $debug === 'true' ){
			return true;
		}

		//	...
		$temp = explode('\\', $class);
		$name = array_pop($temp);
		$name = strtolower($name);

		//	...
		if( false === strpos($debug, $name) ){
			return;
		}

		//	...
		return true;
	}

	/** Debug
	 *
	 * @param string $key
	 */
	static function Debug($key=null)
	{
		self::__DebugOut($key);
	}
}
