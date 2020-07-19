<?php
/** op-core:/Notice.class.php
 *
 * @created   2016-11-17
 * @version   1.0
 * @package   op-core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @created   2019-02-20
 */
namespace OP;

/**
 * Notice
 *
 * @created   2016-11-17
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

	/** Get session by reference.
	 *
	 * @return array
	 */
	static private function & _Session()
	{
		//	...
		$app_id = Env::AppID();

		//	...
		if(!isset($_SESSION['OP']['CORE']['NOTICE'][$app_id]) ){
			$_SESSION['OP']['CORE']['NOTICE'][$app_id] = [];
		};

		//	...
		return $_SESSION['OP']['CORE']['NOTICE'][$app_id];
	}

	/** Get Notice array.
	 *
	 * @return	 array
	 */
	static function Get() : array
	{
		$session = & self::_Session();
		$notice  = array_shift($session);
		return $notice ?? [];
	}

	/** Pop Notice array.
	 *
	 * @return	 array
	 */
	static function Pop() : array
	{
		$session = & self::_Session();
		$notice  = array_pop($session);
		return $notice ?? [];
	}

	/** Set notice array.
	 *
	 * @param string $message
	 */
	static function Set($e, $backtrace=null)
	{
		//	Get session reference.
		$session = & self::_Session();

		//	...
		if( $e instanceof \Throwable ){
			$message   = $e->getMessage();
			$backtrace = $e->getTrace();
			$file      = $e->getFile();
			$line      = $e->getLine();
			array_unshift($backtrace, ['file'=>$file, 'line'=>$line]);
		}else if( is_array($e) ){
			$file    = $e['file'];
			$line    = $e['line'];
		//	$type    = $e['type'];
			$message = $e['message'];
		}else{
			$message   = $e;
		}

		//	...
		$key         = substr(md5($message), 0, 8);
		$timestamp   = Env::Timestamp();

		/*
		$key		 = Hasha1($message);

		//	...
		$offset		 = date('Z');
		$timestamp	 = gmdate('Y-m-d H:i:s');
		if( $offset ){
			$timestamp += ' ' . ($timestamp > 0 ? '+': '');
			$timestamp += $offset;
		}
		*/

		//	...
		$reference	 = isset($session[$key]) ? $session[$key]: null;

		//	...
		if( empty($reference) ){
			//	...
			$reference['count']		 = 1;
			$reference['created']	 = $timestamp;
			$reference['message']	 = $message;
			$reference['backtrace']	 = $backtrace ?? debug_backtrace(false);
		}else{
			$reference['count']		+= 1;
			$reference['updated']	 = $timestamp;
		}

		//	...
		$session[$key] = $reference;
	}

	/** If has notice.
	 *
	 * @return  boolean
	 */
	static function Has()
	{
		//	Get session reference.
		$session = & self::_Session();

		//	...
		return count($session) ? true: false;
	}
}

/** Register shutdown function.
 *
 *  This shutdown function is called only when there is the Notice.
 *  If not have Notice, this file will not be called.
 *
 * @creation  2016-11-17
 * @moved     2017-01-19
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
register_shutdown_function(function(){

	/*
	if( $notice = Unit::Instantiate('Notice') ){
		$notice->Auto();
	}else{
		while( $notice = Notice::Get() ){
			var_dump($notice);
		};
	};
	*/

	try{
		//	...
		Unit('Notice')->Auto();

	}catch( \Exception $e ){
		//	...
		html($e->getMessage());

		//	...
		while( $notice = Notice::Get() ){
			html($notice['message'], 'b');
			foreach($notice['backtrace'] as $backtrace){
				html(
					($backtrace['file']  ?? null).' '.($backtrace['line'] ?? null).' '.
					($backtrace['class'] ?? null).($backtrace['type'] ?? null).($backtrace['function'] ?? null)
				);
				if(!empty($backtrace['args']) ){
					var_dump($backtrace['args']);
				}
			}
		};
	};
});
