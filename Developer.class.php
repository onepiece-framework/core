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

	/**
	 * Mark
	 *
	 * @param mixed $value
	 * @param array $trace
	 */
	static function Mark($value, $trace)
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
		print '<div class="OP_MARK">'.Escape(json_encode($mark)).'</div>'.PHP_EOL;

		//	Dump
		if( $type === 'array' or $type === 'object' ){
			print '<div class="OP_DUMP">'.Escape(json_encode($value)).'</div>'.PHP_EOL;
		}
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
			print '<script type="text/javascript" src="/js/Notice.js"></script>'.PHP_EOL;
			print '<link rel="stylesheet" type="text/css" href="/css/Notice.css">'.PHP_EOL;
		}
		print '<div class="OP_NOTICE">'.Escape(json_encode($notice)).'</div>';
	}

	/**
	 * Build notice html.
	 *
	 * @param array $notice
	 */
	static private function _NoticeHtml($notice)
	{
		$html = '';
		$html.= "<div>{$notice['message']}</div>".PHP_EOL;
		$html.= "<table>".PHP_EOL;
		foreach( $notice['backtrace'] as $i => $a ){
			foreach( ['file','line','function','class','type','args'] as $key ){
				${$key} = ifset($a[$key]);
			}
			$file = CompressPath($file);
			$method = $type ? "{$class}{$type}{$function}":"$function";
			$argument = self::_NoticeHtmlArguments($args, $function);
			$html.= "<tr><td>{$file}</td><td>{$line}</td><td>{$method}($argument)</td></tr>".PHP_EOL;
		}
		$html.= "</table>".PHP_EOL;
		return $html;
	}

	/**
	 * Build notice html's arguments.
	 *
	 * @param array $notice
	 */
	static private function _NoticeHtmlArguments($args, $function)
	{
		$join = [];
		foreach( $args as $val ){
			$val = Escape($var);
			switch( $type = gettype($val) ){
				case 'array':
				case 'object':
					$join[] = $type;
					break;

				case 'string':
					if( $function === 'include' ){
						$val = CompressPath($val);
					}
					$join[] = '"'.$val.'"';
					break;

				default:
					$join[] = $val;
			}
		}
		return join(', ', $join);
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