<?php
/**
 * OnePiece.class.php
 *
 * @creation  2014-11-29
 * @rebirth   2016-06-09
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/**
 * OP_CORE
 *
 * @creation  2016-12-05
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
trait OP_CORE
{
	/**
	 * Call to has not been set method.
	 *
	 * @param string $name
	 * @param array  $args
	 */
	function __call($name, $args)
	{
		$join = [];
		foreach( $args as $val ){
			switch( $type = gettype($val) ){
				case 'array':
				case 'object':
					$join[] = $type;
					break;
				default:
					$join[] = $val;
			}
		}
		$class   = get_class($this);
		$serial  = join(', ', $join);
		$message = "This method has not been exists. ({$class}->{$name}({$serial}))";
		Notice::Set($message, debug_backtrace());
	}

	/**
	 * Call to has not been set static method.
	 *
	 * @param string $name
	 * @param array  $args
	 */
	static function __callstatic($name, $args)
	{
		$message = "This method has not been exists. ($name)";
		Notice::Set($message, debug_backtrace());
	}

	/**
	 * Call to has not been set property.
	 *
	 * @param string $name
	 */
	function __get($name)
	{
		$message = "This property has not been exists. ($name)";
		Notice::Set($message, debug_backtrace());
	}

	/**
	 * Call to has not been set property.
	 *
	 * @param string $name
	 * @param array  $args
	 */
	function __set($name, $args)
	{
		$message = "This property has not been exists. ($name)";
		Notice::Set($message, debug_backtrace());
	}

	/**
	 * Property name to serialize.
	 */
	function __sleep()
	{
		return [];
	}

	/**
	 * Process to restore from serialized character string.
	 */
	function __wakeup()
	{

	}
}

/**
 * OnePiece
 *
 * @creation  2014-11-29
 * @rebirth   2016-06-09
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class OnePiece
{
	/**
	 * Use OPCORE.
	 */
	use OP_CORE
	{

	}

	/**
	 * Namespace
	 *
	 * @var string
	 */
	const _NAME_SPACE_ = 'ONEPIECE';

	/**
	 * Get/Set Session value.
	 *
	 * Separated from each class/object.
	 * Static class and instantiated object to do the same behavior.
	 *
	 * <pre>
	 * //  Save by static class.
	 * OnePiece::Session('test', true);
	 * //  Load by static class.
	 * print OnePiece::Session('test');
	 *
	 * //  Load by instantiated object.
	 * $op = new OnePiece();
	 * print $op->Session('test');
	 * </pre>
	 *
	 * @param string
	 * @param null|boolean|integer|string|array
	 */
	static function Session($key, $value=null)
	{
		$class = get_called_class();
		if( $value !== null ){
			$_SESSION[self::_NAME_SPACE_][$class][$key] = $value;
		}else{
			return ifset($_SESSION[self::_NAME_SPACE_][$class][$key]);
		}
	}
}