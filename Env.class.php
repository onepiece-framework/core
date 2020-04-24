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

/** namespace
 *
 * @creation  2019-02-20
 */
namespace OP;

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
	/** trait.
	 *
	 */
	use OP_CORE;

	/** Constant.
	 *
	 * @var string
	 */
	const _ADMIN_IP_	 = 'admin-ip';
	const _ADMIN_MAIL_	 = 'admin-mail';
	const _MAIL_FROM_	 = 'mail-from';

	/** Private static values.
	 *
	 * @var array
	 */
	static private $_env;

	/** Is Admin
	 *
	 * @return boolean
	 */
	static function isAdmin()
	{
		//	Keep calced value.
		static $_is_admin;

		//	Check if not init.
		if( $_is_admin === null ){
			if( self::isLocalhost() ){
				$_is_admin = true;
			}else{
				$_is_admin = (self::$_env[self::_ADMIN_IP_] ?? null) === ($_SERVER['REMOTE_ADDR'] ?? null) ? true: false;
			}
		}

		//	Return already calced static value.
		return $_is_admin;
	}

	/** Is localhost
	 *
	 * @return boolean
	 */
	static function isLocalhost()
	{
		//	Keep calced value.
		static $_is_localhost;

		//	Check if not init.
		if( $_is_localhost === null ){
			//	Check if http.
			if( self::isHttp() ){
				//	...
				$remote_addr = $_SERVER['REMOTE_ADDR'] ?? null;

				//	localhost ip address
				$_is_localhost = ($remote_addr === '127.0.0.1' or $remote_addr === '::1') ? true : false;
			}else{
				//	Shell
				$_is_localhost = true;
			}
		}

		//	Return already calced static value.
		return $_is_localhost;
	}

	/** Is Http
	 *
	 * @return boolean
	 */
	static function isHttp()
	{
		return isset($_SERVER['REDIRECT_STATUS']);
	}

	/** Is Shell
	 *
	 * @return boolean
	 */
	static function isShell()
	{
		return isset($_SERVER['SHELL']);
	}

	/** Get environment value.
	 *
	 * @param  string $key
	 * @return string|integer|boolean|array|object
	 */
	static function Get($key)
	{
		//	...
		if( $key === _OP_APP_ID_ ){
			return self::AppID();
		};

		//	Always lowercase.
		$key = strtolower($key);


		//	...
		return self::$_env[$key] ?? null;
	}

	/** Set environment value.
	 *
	 * @param string $key
	 * @param string|integer|boolean|array|object $var
	 */
	static function Set($key, $var)
	{
		//	...
		$key = strtolower($key);

		//	What is this necessary for? --> Initialize when Admin-IP is set. (for re calc)
		/*	This process is necessary?  --> Change admin ip feature.
		 *
		 * @disabled 2020-04-24

		if( $key === self::_ADMIN_IP_ ){
			self::$_is_admin = null;
		}
		*/


		//	...
		if( isset(self::$_env[$key]) and is_array($var) ){
			/** About array merge.
			 *
			 *  array_replace_recursive() is all replace.
			 *  array_merge_recursive() is number index is renumbering.
			 *
			 */
		//	self::$_env[$key] = array_merge_recursive(self::$_env[$key], $var);
			self::$_env[$key] = array_replace_recursive(self::$_env[$key], $var);
		}else{
			self::$_env[$key] = $var;
		};
	}

	/** Get/Set Language.
	 *
	 * @created 2019-04-27
	 * @param   string     $lang
	 * @return  string     $lang
	 */
	static function Language($lang=null)
	{
		//	...
		if( $lang ){
			$cont = self::Country();
			self::$_env['locale'] = $lang.':'.$cont;
		}else{
			return explode(':', self::Locale())[0];
		};
	}

	/** Get/Set Country.
	 *
	 * @created 2019-04-29
	 * @param   string     $country
	 * @return  string     $country
	 */
	static function Country($country=null)
	{
		//	...
		if( $country ){
			$lang = self::Language();
			self::$_env['locale'] = $lang.':'.$country;
		}else{
			return strtoupper(explode(':',self::Locale())[1] ?? null);
		};
	}

	/** Get/Set Locale.
	 *
	 * @created 2019-04-27
	 * @param   string     $locale
	 * @return  string     $locale
	 */
	static function Locale($locale=null)
	{
		//	...
		if( $locale ){
			self::$_env['locale'] = $locale;
		};

		//	...
		return $locale;
	}

	/** Get/Set charset.
	 *
	 * This charset is just html only.
	 * For developers charset is not yet consider.
	 * Source code is always UTF-8.
	 *
	 * @param  string $charset
	 * @return string $charset
	 */
	static function Charset($charset=null)
	{
		//	...
		if( $charset ){
			/*
			if( self::$_env['charset'] ){
				throw new \Exception("Charset was already set.");
			}else{
				self::$_env['charset'] = $charset;
			};
			*/
			self::$_env['charset'] = $charset;
		};

		//	...
		if( empty(self::$_env['charset']) ){
			self::$_env['charset'] = 'utf-8';
		};

		//	...
		return self::$_env['charset'];
	}

	/** Get/Set MIME
	 *
	 * @param  string $mime
	 * @return string $mime
	 */
	static function Mime($mime=null)
	{
		//	...
		if( $mime ){
			//	...
			$file = $line = null;

			//	...
			if( headers_sent($file, $line) ){
				throw new \Exception("Header has already sent. ($file, $line)");
			}else{
				//	...
				self::$_env['mime'] = strtolower($mime);

				/*
				//	...
				$header = "Content-type: $mime";

				//	...
				if( $charset = self::Charset()){
					$header .= "; charset={$charset}";
				}

				//	...
				header($header);
				*/
			}
		}

		//	...
		return self::$_env['mime'] ?? null;
	}

	/** Get frozen unix time.
	 *
	 * @param  integer|string $time
	 * @return integer        $time
	 */
	static function Time($time=null)
	{
		//	...
		if( $time ){
			//	...
			if( self::$_env['time'] ?? null ){
				throw new \Exception("Frozen time has already set.");
			};

			//	...
			self::$_env['time'] = is_int($time) ? $time: strtotime($time);
		};

		//	...
		if( empty(self::$_env['time']) ){
			self::$_env['time'] = time();
		};

		//	...
		return self::$_env['time'];
	}

	/** Get local timezone timestamp.
	 *
	 * @created  2019-09-24
	 * @return   string      $timestamp
	 */
	static function Timestamp($gmt=null)
	{
		return $gmt ? gmdate(_OP_DATE_TIME_, self::Time()) : date(_OP_DATE_TIME_, self::Time());
	}

	/** Get/Set App ID.
	 *
	 * @created  2019-09-13
	 * @param    string      $app_id
	 * @return   string      $app_id
	 */
	static function AppID($app_id=null)
	{
		//	...
		if( $app_id ){
			//	...
			if( isset(self::$_env[_OP_APP_ID_]) ){
				throw new \Exception("AppID is already set.");
			}

			//	...
			self::$_env[_OP_APP_ID_] = $app_id;
		}

		//	...
		return self::$_env[_OP_APP_ID_];
	}
}
