<?php
/**
 * Env.class.php
 *
 * @creation  2016-06-09
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/**
 * Env
 *
 * @creation  2016-06-09
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Env
{
	/** Constant.
	 *
	 * @var string
	 */
	const _ADMIN_IP_	 = 'admin-ip';
	const _ADMIN_MAIL_	 = 'admin-mail';
	const _MIME_		 = 'output-mime';
	const _CHARSET_		 = 'output-charset';
	const _LOCALE_		 = 'output-locale';

	/** Private static values.
	 *
	 * @var array
	 */
	static $_env;
	static $_is_admin;
	static $_is_localhost;

	/** Is Admin
	 *
	 * @return boolean
	 */
	static function isAdmin()
	{
		if(!self::$_is_admin){
			if( self::isLocalhost() ){
				self::$_is_admin = true;
			}
		}
		return self::$_is_admin;
	}

	/** Is localhost
	 *
	 * @return boolean
	 */
	static function isLocalhost()
	{
		if(!self::$_is_localhost){
			self::$_is_localhost = ($_SERVER['REMOTE_ADDR'] === '127.0.0.1' or $_SERVER['REMOTE_ADDR'] === '::1') ? true : false;
		}
		return self::$_is_localhost;
	}

	/** Get
	 *
	 * @param  string $key
	 * @param  string|integer|boolean|array|object $default
	 * @return string|integer|boolean|array|object
	 */
	static function Get($key, $default=null)
	{
		return ifset(self::$_env[$key], $default);
	}

	/** Set
	 *
	 * @param string $key
	 * @param string|integer|boolean|array|object $var
	 */
	static function Set($key, $var)
	{
		if( $key === self::_ADMIN_IP_ ){
			self::$_is_admin = null;
		}
		self::$_env[$key] = $var;
	}
}