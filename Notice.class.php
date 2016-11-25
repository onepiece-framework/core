<?php
/**
 * Notice.class.php
 *
 * @creation  2016-11-17
 * @version   1.0
 * @package   core7
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright 2016 (C) Tomoaki Nagahara All right reserved.
 */

/**
 * Notice
 *
 * @creation  2016-11-17
 * @version   1.0
 * @package   core7
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright 2016 (C) Tomoaki Nagahara All right reserved.
 */
class Notice extends OnePiece
{
	/**
	 * Namespace
	 *
	 * @var string
	 */
	const _NAME_SPACE_ = 'NOTICE';

	/**
	 * Get notice array.
	 *
	 * @return array
	 */
	static function Get()
	{
		if( empty($_SESSION[OnePiece::_NAME_SPACE_][self::_NAME_SPACE_]) ){
			$_SESSION[OnePiece::_NAME_SPACE_][self::_NAME_SPACE_] = [];
		}
		return array_shift($_SESSION[OnePiece::_NAME_SPACE_][self::_NAME_SPACE_]);
	}

	/**
	 * Set notice array.
	 *
	 * @param string $message
	 */
	static function Set($message)
	{
		$notice['message']   = $message;
		$notice['backtrace'] = debug_backtrace();
		$_SESSION[OnePiece::_NAME_SPACE_][self::_NAME_SPACE_][] = $notice;
	}

	/**
	 * Callback at shutodown.
	 */
	static function Shutdown()
	{
		while( $notice = self::Get() ){
			if( Env::isAdmin() ){
				Developer::Notice($notice);
			}else{
				Developer::Sendmail($notice);
			}
		}
	}
}
