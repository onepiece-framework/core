<?php
/**
 * Developer.class.php
 *
 * This class is part of the "New World".
 *
 * @creation  2016-06-09
 * @version   1.0
 * @package   core7
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/**
 * Developer
 *
 * @creation  2014-11-29
 * @version   1.0
 * @package   core7
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Developer extends OnePiece
{
	/**
	 * Namespace
	 *
	 * @var string
	 */
	const _NAME_SPACE_ = 'DEVELOPER';

	static function _toJson($obj)
	{
		$json = json_encode($obj);
		$json = htmlentities($json, ENT_NOQUOTES, 'utf-8');
	//	$json = str_replace(['&lt;','&gt;'], ['＜','＞'], $json);
		$json = str_replace(['&'], ['&amp;'], $json);
		return $json;
	}

	/**
	 * Mark
	 *
	 * @param mixed $value
	 * @param array $trace
	 */
	static function Mark($value, $trace)
	{
		switch( $mime = strtolower(Env::Get(Env::_MIME_)) ){
			case 'text/css':
				self::MarkCss($value, $trace);
				break;

			case 'text/javascript':
				self::MarkJS($value, $trace);
				break;

			case 'text/json':
			case 'text/jsonp':
				self::MarkJson($value, $trace);
				break;

			case 'text/html':
			default:
				self::MarkHtml($value, $trace);
		}
	}

	/**
	 * MarkCss
	 *
	 * @param mixed $value
	 * @param array $trace
	 */
	static function MarkCss($value, $trace)
	{
		print PHP_EOL;
		print "/* $value */".PHP_EOL;
	}

	/**
	 * MarkHtml
	 *
	 * @param mixed $value
	 * @param array $trace
	 */
	static function MarkHtml($value, $trace)
	{
		//	...
		$type = gettype($value);

		//	Mark
		$mark = [];
		$mark['file']  = CompressPath($trace['file']);
		$mark['line']  = $trace['line'];
		$mark['type']  = $type;
		$mark['value'] = $value;
		print '<div class="OP_MARK">'.self::_toJson($mark).'</div>'.PHP_EOL;

		//	Dump
		if( $type === 'array' or $type === 'object' ){
			print '<div class="OP_DUMP">'.self::_toJson($value).'</div>'.PHP_EOL;
		}
	}

	/**
	 * MarkJS
	 *
	 * @param mixed $value
	 * @param array $trace
	 */
	static function MarkJS($value, $trace)
	{
		print PHP_EOL;
		print "console.log($value);".PHP_EOL;
		print "console.dir($trace);".PHP_EOL;
	}

	/**
	 * MarkJson
	 *
	 * @param mixed $value
	 * @param array $trace
	 */
	static function MarkJson($value, $trace)
	{
		global $_JSON;
		$mark['message']   = $value;
		$mark['backtrace'] = $trace;
		$_JSON['admin']['mark'][] = $mark;
	}
}