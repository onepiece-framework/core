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

/** namespace
 *
 * @creation  2019-02-20
 */
namespace OP;

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

	/** Get/Pop Notice array.
	 *
	 * @param	 boolean	 true=Get(First in), false=Pop(Last in)
	 * @return	 array
	 */
	static function _Get(bool $is_get=true) : array
	{
		//	...
		$app_id = Env::Get(_OP_APP_ID_);

		//	...
		if(!isset($_SESSION[$app_id][__CLASS__]) ){
			$_SESSION[$app_id][__CLASS__] = [];
		};

		//	Get
		$session = &$_SESSION[$app_id][__CLASS__];

		//	Shift
		if( $is_get ){
			//	...
			$notice  = array_shift($session);
		}else{
			//	...
			$notice  = array_pop($session);
		};

		//	Return
		return $notice ?? [];
	}

	/** Get Notice array.
	 *
	 * @return	 array
	 */
	static function Get() : array
	{
		return self::_Get(true);
	}

	/** Pop Notice array.
	 *
	 * @return	 array
	 */
	static function Pop() : array
	{
		return self::_Get(false);
	}

	/** Set notice array.
	 *
	 * @param string $message
	 */
	static function Set($e, $backtrace=null)
	{
		//	...
		$app_id = Env::Get(_OP_APP_ID_);

		//	...
		if(!isset($_SESSION[$app_id][__CLASS__]) ){
			$_SESSION[$app_id][__CLASS__] = [];
		};

		//	Get
		$session = &$_SESSION[$app_id][__CLASS__];

		//	...
		if( $e instanceof \Throwable ){
			$message   = $e->getMessage();
			$backtrace = $e->getTrace();
			$file      = $e->getFile();
			$line      = $e->getLine();
			array_unshift($backtrace, ['file'=>$file, 'line'=>$line]);
		}else{
			$message   = $e;
		}

		//	...
		$key		 = Hasha1($message);
		$timestamp	 = gmdate('Y-m-d H:i:s', time()+date('Z'));

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
		//	...
		$app_id = Env::Get(_OP_APP_ID_);

		//	...
		if(!isset($_SESSION[$app_id][__CLASS__]) ){
			$_SESSION[$app_id][__CLASS__] = [];
		};

		//	...
		return count($_SESSION[$app_id][__CLASS__]) ? true: false;
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
	if( $notice = Unit::Instantiate('Notice') ){
		$notice->Auto();
	}else{
		while( $notice = Notice::Get() ){
			var_dump($notice);
		};
	};
});
