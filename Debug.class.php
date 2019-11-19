<?php
/**
 * Debug.class.php
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

/** Debug
 *
 *  Put together debug information.
 *
 * @creation  2019-03-19
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Debug
{
	/** trait.
	 *
	 */
	use OP_CORE, OP_DEBUG;

	/** Set debug info.
	 *
	 * @param  string  $key
	 * @param  mixed   $val
	 */
	static function Set($key, $val)
	{
		self::__DebugSet($key, $val);
	}

	/** Display debug info.
	 *
	 * @param  string  $key
	 */
	static function Out($key='')
	{
		self::__DebugOut($key);
	}
}
