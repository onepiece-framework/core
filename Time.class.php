<?php
/**
 * Time.class.php
 *
 * This class is part of the "New World".
 * We call "ICE AGE".
 * "ICE AGE" is very simple, but very powerful.
 *
 * @creation  2016-11-17
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/**
 * Time
 *
 * @creation  2016-11-17
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Time
{
	/** trait.
	 *
	 */
	use OP_CORE;

	/** Format
	 *
	 * @param  string $formt 'Y-m-d H:i:s'
	 * @param  string $calc  '1 month'
	 * @return string
	 */
	static private function _Format($format, $calc)
	{
		$time = self::Time();
		if( $calc ){
			if(!$time = strtotime($calc, $time)){
				Notice::Set("strtotime was failed. ($calc)");
			}
		}
		return date($format, $time);
	}

	/** Return date. (not include time)
	 *
	 * @return string
	 */
	static function Date($calc=null)
	{
		return self::_Format('Y-m-d', $calc);
	}

	/** Return date and time.
	 *
	 * @return string
	 */
	static function Datetime($format=null)
	{
		return self::_Format('Y-m-d H:i:s', $calc);
	}

	/** Get/Set frozen time.
	 *
	 * @param null|integer|string $time
	 */
	static function Time($time=null)
	{
		//	...
		static $_time;

		//	...
		if( $time ){
			//	...
			if( $_time ){
				Notice::Set("Frozen time is already setted.");
			}else{
				//	...
				if(!is_numeric($time)){ // $time --> 2020-01-01 00:00:00
					if(!$time = strtotime($time)){
						Notice::Set("strtotime was failed.");
					}else{
						$time = strtotime(gmdate('Y-m-d H:i:s'));
					}
				}
				$_time = $time;
			}
		}else{
			if(!$_time){
				//	...
				$_time = strtotime(gmdate('Y-m-d H:i:s'));
			}
		}

		//	...
		return $_time;
	}

	/** Get/Set Timezone.
	 *
	 * @param  null|string $timezone
	 * @return null|string
	 */
	static function Timezone($timezone=null)
	{
		if( $timezone ){
			if( self::$_timezone ){
				Notice::Set("Timezone is already set.");
				return false;
			}

			//	...
			self::$_timezone = $timezone;
			return date_default_timezone_set($timezone);
		}else{
			return date_default_timezone_get();
		}
	}
}