<?php
/**
 * OP_UNIT.php
 *
 * @creation  2019-02-21
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @creation  2019-02-21
 */
namespace OP;

/** OP_UNIT
 *
 * @creation  2019-02-21
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
trait OP_UNIT
{
	/** This variable is stores information used for debugging.
	 *
	 */
	protected $_debug;

	/** Env
	 *
	 * @return \OP\Env
	 */
	function Env()
	{
		//	...
		static $_env;

		//	...
		if(!$_env ){
			$_env = new Env();
		};

		//	...
		return $_env;
	}

	/** Time
	 *
	 * @return \OP\Time
	 */
	function Time()
	{
		//	...
		static $_time;

		//	...
		if(!$_time ){
			$_time = new Time();
		};

		//	...
		return $_time;
	}

	/** Unit
	 *
	 *  Always return instantiated instance.
	 *  That so-called "Singleton" or "Factory method".
	 *
	 * @param	 string		 $name
	 * @return	 object
	 */
	function Unit($name)
	{
		//	...
		static $_instance = [];

		//	...
		if(!isset($_instance[$name]) ){
			try{
				//	...
				$_instance[$name] = Unit::Instantiate($name);
			}catch( \Exception $e ){
				$_instance[$name] = new Ghost($name);

				//	...
				Notice::Set($e);
			};

			//	...
			if( Env::isAdmin() ){
				$this->_debug['unit']['instantiate'][$name] = (get_class($_instance[$name]) === 'OP\Ghost') ? false: true;
			};
		};

		//	...
		return $_instance[$name];
	}

	/** Debug for developers only.
	 *
	 * @param string $topic
	 */
	function Debug(string $topic='')
	{
		//	...
		if(!Env::isAdmin() ){
			return;
		};

		//	...
		if( method_exists($this, '_PreDebug') ){
			$this->_PreDebug($topic);
		};

		//	...
		$trace = debug_backtrace(null,1)[0];
		echo CompressPath($trace['file']) .' #'. $trace['line'];

		//	...
		\OP\Json(isset($this->_debug[$topic]) ? $this->_debug[$topic]: $this->_debug, 'OP_DUMP');

		//	...
		if( file_exists( $path = $this->Path('unit:/dump') ) ){
			//	...
			$webpack = Unit::Instantiate('Webpack');
			$webpack->Js ([$path.'/mark', $path.'/dump']);
			$webpack->Css([$path.'/mark', $path.'/dump']);
		};
	}
}

/** Ghost
 *
 * @creation  2019-02-25
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
