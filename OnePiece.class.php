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
	 * Call to has not been set method.
	 *
	 * @param string $name
	 * @param array  $args
	 */
	function __call($name, $args)
	{
		$message = "This method has not been exists. ($name)";
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

	function __construct()
	{

	}

	function __destruct()
	{

	}
}
