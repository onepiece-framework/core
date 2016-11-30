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
	 * Namespace
	 *
	 * @var string
	 */
	const _NAME_SPACE_ = 'ONEPIECE';

	/**
	 * Session method's default value.
	 *
	 * @var string
	 */
	const _SESSION_VALUE_ = ' unset session value ';

	/**
	 * Call to has not been set method.
	 *
	 * @param string $name
	 * @param array  $args
	 */
	function __call($name, $args)
	{
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
		Notice::Set($message);
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
		Notice::Set($message);
	}

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
	static function Session($key, $value=self::_SESSION_VALUE_)
	{
		$class = get_called_class();
		if( $value !== self::_SESSION_VALUE_ ){
			$_SESSION[OnePiece::_NAME_SPACE_][$class][$key] = $value;
		}else{
			return $_SESSION[OnePiece::_NAME_SPACE_][$class][$key];
		}
	}
}