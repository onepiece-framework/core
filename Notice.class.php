<?php
/**
 * Notice.class.php
 *
 * @creation  2016-11-17
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/**
 * Notice
 *
 * @creation  2016-11-17
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Notice
{
	/** trait.
	 *
	 */
	use OP_CORE;

	/** Namespace
	 *
	 * @var string
	 */
	const _NAME_SPACE_ = 'NOTICE';

	/** Get notice array.
	 *
	 * @return array
	 */
	static function Get()
	{
		if( empty($_SESSION[_OP_NAME_SPACE_][self::_NAME_SPACE_]) ){
			$_SESSION[_OP_NAME_SPACE_][self::_NAME_SPACE_] = [];
		}
		return array_shift($_SESSION[_OP_NAME_SPACE_][self::_NAME_SPACE_]);
	}

	/** Set notice array.
	 *
	 * @param string $message
	 */
	static function Set($message, $backtrace=null)
	{
		if(!$backtrace ){
			$backtrace = debug_backtrace();
		//	array_shift($backtrace); Do not use for app world.
		}

		//	...
		$key = Hash1($message);
		$timestamp = gmdate('Y-m-d H:i:s', time()+date('Z'));

		//	...
		if( isset($_SESSION[_OP_NAME_SPACE_][self::_NAME_SPACE_][$key]) ){
			$_SESSION[_OP_NAME_SPACE_][self::_NAME_SPACE_][$key]['count']++;
			$_SESSION[_OP_NAME_SPACE_][self::_NAME_SPACE_][$key]['updated'] = $timestamp;
		}else{
			$notice['count']     = 1;
			$notice['message']   = $message;
			$notice['backtrace'] = $backtrace;
			$notice['created']   = $timestamp;
			$_SESSION[_OP_NAME_SPACE_][self::_NAME_SPACE_][$key] = $notice;
		}
	}

	/** Callback at shutodown.
	 *
	 */
	static function Shutdown()
	{
		if(!Env::isAdmin()){
			while( $notice = self::Get() ){
				//	...
				$to = Env::Get(Env::_ADMIN_MAIL_);
				$subject = $notice['message'];
				$content = Template::Get('op:/Template/Notice/Sendmail.phtml', $notice);

				//	...
				$mail = new EMail();
				$mail->From($mail->GetLocalAddress());
				$mail->To($to);
				$mail->Subject($subject);
				$mail->Content($content);
				$mail->Send();
			}
		}
	}
}

/**
 * Register shutdown function.
 *
 * Moved from Bootstrap.php
 * If not exists Notice message, will not from call Notice class.
 * So far, has always been called up.
 *
 * @creation  2016-11-17
 * @moved     2017-01-19
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
register_shutdown_function('Notice::Shutdown');
