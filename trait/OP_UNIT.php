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

/** Used class
 *
 */
use Exception;

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
	/** App
	 *
	 * @return UNIT\App
	 */
	function App()
	{
		return $this->Unit('App');
	}

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
		static $_instance = [];

		//	...
		$orig = $name;

		//	...
		$name = strtolower($name);

		//	...
		if(!isset($_instance[$name]) ){
			try{
				//	...
				$_instance[$name] = Unit::Instantiate($orig);
			}catch( Exception $e ){
				$_instance[$name] = new Ghost($orig);

				//	...
				Notice::Set($e);
			};

			/*
			//	...
			if( Env::isAdmin() ){
				self::__DebugSet('instantiate', [$name => (get_class($_instance[$name]) === 'OP\Ghost') ? false: true]);
			};
			*/
		};

		//	...
		return $_instance[$name];
	}
}

/** Ghost
 *
 * @created   2019-02-25
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Ghost implements IF_UNIT
{
	/** Trait
	 *
	 */
	use OP_UNIT;

	/** My Unit name.
	 *
	 * @var string
	 */
	protected $_name;

	/** Constructor.
	 *
	 */
	function __construct($name)
	{
		$this->_name = $name;
	}

	/** Ghost method.
	 *
	 */
	function __call($name, $args)
	{
		D("Unit \"{$this->_name}\" has not been exists. ({$this->_name}->{$name}())");
	}
}
