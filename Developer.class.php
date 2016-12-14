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
		switch( $mime = Env::Get(Env::_MIME_) ){
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
	 * MarkHtml
	 *
	 * @param mixed $value
	 * @param array $trace
	 */
	static function MarkHtml($value, $trace)
	{
		//	Output is first time only.
		static $is_dump;
		if(!$is_dump ){
			$is_dump = true;
			print '<script type="text/javascript" src="/js/Mark.js"></script>'.PHP_EOL;
			print '<script type="text/javascript" src="/js/Dump.js"></script>'.PHP_EOL;
			print '<link rel="stylesheet" type="text/css" href="/css/Mark.css">'.PHP_EOL;
			print '<link rel="stylesheet" type="text/css" href="/css/Dump.css">'.PHP_EOL;
		}

		//	...
		$type = gettype($value);

		//	Mark
		$mark = [];
		$mark['file'] = CompressPath($trace['file']);
		$mark['line'] = $trace['line'];
		$mark['type'] = $type;
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
		print "console.log($value)".PHP_EOL;
		print "console.dir($trace)".PHP_EOL;
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
		$_JSON['mark'][] = $mark;
	}

	/**
	 * Show notice message for developer.
	 *
	 * @param array $notice
	 */
	static function Notice($notice)
	{
		//	Output is first time only.
		static $is_notice;
		if(!$is_notice ){
			$is_notice = true;
			global $_OP;
			$op_root  = $_OP[OP_ROOT];
			$app_root = $_OP[APP_ROOT];
			$doc_root = $_OP[DOC_ROOT];
			print "<div id=\"OP_NOTICE\" data-OP_ROOT=\"{$op_root}\" data-APP_ROOT=\"{$app_root}\" data-DOC_ROOT=\"{$doc_root}\"></div>".PHP_EOL;
			print '<script type="text/javascript" src="/js/Notice.js"></script>'.PHP_EOL;
			print '<link rel="stylesheet" type="text/css" href="/css/Notice.css">'.PHP_EOL;
		}
		print '<div class="OP_NOTICE">'.self::_toJson($notice).'</div>';
	}

	/**
	 * Send admin notice mail.
	 *
	 * @param array
	 */
	static function Sendmail($notice)
	{
		//	...
		$to = Env::Get(Env::_ADMIN_MAIL_);
		$subject = $notice['message'];
		$content = Template::Get('op:/Template/Developer/Sendmail.phtml', $notice);

		//	...
		$mail = new EMail();
		$mail->From($mail->GetLocalAddress());
		$mail->To($to);
		$mail->Subject($subject);
		$mail->Content($content);
		$mail->Send();
	}
}