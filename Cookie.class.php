<?php
/**
 * Cookie.class.php
 *
 * @creation  2017-02-25
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
/**
 * Cookie
 *
 * @creation  2017-02-25
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Cookie
{
	/** trait.
	 *
	 */
	use OP_CORE;

	/** Get cookie value of key.
	 *
	 * @param  string $key
	 * @param  string $val default
	 * @return mixed
	 */
	static function Get($key, $val=null)
	{
		//	...
		$domain = '';

		//	...
		$key = Hash1("$key, $domain");

		//	...
		return isset($_COOKIE[$key]) ? unserialize($_COOKIE[$key]): null;
	}

	/**
	 *
	 * @param unknown $key
	 * @param unknown $val
	 */
	static function Set($key, $val, $expire=null, $option=null)
	{
		//	...
		$domain = '';

		//	...
		$key = Hash1("$key, $domain");

		//	...
		if( $expire === null ){
			$expire = Time::Get() + (60*60*24*365*10);
		}

		//	...
		$path = ifset( $option['path'], '/');

		//	...
		$domain = ifset( $option['domain'], Http::Domain());

		//	...
		$secure = false;

		//	...
		$httponly = false;

		//	...
		if( setcookie($key, serialize($val), $expire, $path, $domain, $secure, $httponly) ){
			//	Successful.
			$_COOKIE[$key] = $val;
		}else{
			//	Failed.
			if( headers_sent($file, $line) ){
				Notice::Set("Header has already been sent. ($file, $line)");
			}else{
				Notice::Set("Set cookie was failed.");
			}
		}
	}
}