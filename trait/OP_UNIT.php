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
	/** Unit
	 *
	 *  Always return instantiated instance.
	 *  That so-called "Singleton" or "Factory method".
	 *
	 * @param	 string		 $name
	 * @return	 object
	 */
	static function Unit($name)
	{
		//	...
		Notice::Set('This method will obsolete. Please usage following method.'.PHP_EOL."Unit::Singleton({$name})");

		//	...
		return Unit::Singleton($name);
	}
}
