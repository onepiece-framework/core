<?php
/** op-core:/OP_UNIT.php
 *
 * @created   2019-02-21
 * @version   1.0
 * @package   op-core
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
 * @package   op-core
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
	 * @created
	 * @deprecated 2020-10-09
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
