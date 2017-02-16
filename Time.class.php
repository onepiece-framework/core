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

	/** Frozen of world time.
	 *
	 * @var integer
	 */
	static private $_time;

	/** Timezone.
	 *
	 * @var string
	 */
	static private $_timezone;

	/** Return date. (not include time)
	 *
	 * @return string
	 */
	static function Date()
	{
		return date('Y-m-d', self::Get());
	}

	/** Return date and time.
	 *
	 * @return string
	 */
	static function Datetime()
	{
		return date('Y-m-d H:i:s', self::Get());
	}

	/** Get frozen time.
	 *
	 */
	static function Get()
	{
		if(!self::$_time){
			self::$_time = strtotime(gmdate('Y-m-d H:i:s'));
		}
		return self::$_time;
	}

	/** Get/Set Timezone.
	 *
	 * @param  null|string $timezone
	 * @return null|string
	 */
	static function Timezone($timezone=null)
	{
		if( $timezone ){
			date_default_timezone_set($timezone);
		}else{
			return self::$_timezone;
		}
	}
}