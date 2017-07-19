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

	/** Dump of notice.
	 *
	 * @param array $notice
	 */
	static function Dump( $notice )
	{
		$mime = Env::Mime();
		switch( $mime ){
			case 'text/html':
				echo '<div class="notice">';
				echo json_encode($notice);
				echo '</div>'."\r\n";
				break;
			default:
		}
	}

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
	static function Set($e, $backtrace=null)
	{
		//	...
		if( $e instanceof Throwable ){
			$message   = $e->getMessage();
			$backtrace = $e->getTrace();
			$file      = $e->getFile();
			$line      = $e->getLine();
			$function  = null;
			array_unshift($backtrace, ['file'=>$file, 'line'=>$line]);
		}else{
			$message   = $e;
		}

		//	...
		if(!$backtrace ){
			$backtrace = debug_backtrace();
		//	array_shift($backtrace); Do not use for app world.
		}

		//	...
		$key = Hasha1($message);
		$timestamp = gmdate('Y-m-d H:i:s', time()+date('Z'));

		//	...
		if(!isset($_SESSION[_OP_NAME_SPACE_][self::_NAME_SPACE_][$key]) ){
		          $_SESSION[_OP_NAME_SPACE_][self::_NAME_SPACE_][$key] = [];
		}

		//	...
		$reference = &$_SESSION[_OP_NAME_SPACE_][self::_NAME_SPACE_][$key];

		//	...
		if( empty($reference) ){
			$reference['count']		 = 1;
			$reference['message']	 = $message;
			$reference['backtrace']	 = $backtrace;
			$reference['created']	 = $timestamp;
		}else{
			$reference['count']		+= 1;
			$reference['updated']	 = $timestamp;
		}
	}

	/** Callback at shutodown.
	 *
	 */
	static function Shutdown()
	{
		if(!Env::isAdmin()){
			//	...
			$file_path = ConvertPath('op:/Template/Notice/Sendmail.phtml');
			if(!file_exists($file_path) ){
				print "<p>Does not file exists. ($file_path)</p>";
				return;
			}

			//	...
			$to = Env::Get(Env::_ADMIN_MAIL_);

			//	...
			if(!$to){
				Html::P('Has not been set admin mail address.');
				return;
			}

			//	...
			while( $notice = self::Get() ){
				try {
					$subject = $notice['message'];

					//	...
					if(!ob_start()){
						Html::P('"ob_start" was failed. (Notice::Shutdown)');
						return;
					}

					//	...
					include($file_path);

					//	...
					$content = ob_get_clean();

					//	...
					$mail = new EMail();
					$mail->From($mail->GetLocalAddress());
					$mail->To($to);
					$mail->Subject($subject);
					$mail->Content($content);
					if(!$io = $mail->Send()){
						return;
					}
				} catch ( Throwable $e ) {
					Html::P($e->GetMessage());
				}
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
