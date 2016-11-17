<?php
/**
 * Developer.class.php
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
class Developer extends OP
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
			print '<script type="text/javascript" src="/Dump.js"></script>'.PHP_EOL;
			print '<link rel="stylesheet" type="text/css" href="/Dump.css">'.PHP_EOL;
		}

		//	Checking type of argument.
		$style = $styles = array();
		switch( $type = gettype($value) ){
			case 'object':
				$style['color'] = "green";
				$value = get_class($value);
				break;

			case 'array':
				$style['color'] = "green";
				$array = $value;
				$value = 'array';
				break;

			case 'NULL':
				$style['color'] = "pink";
				$value = 'null';
				break;

			case 'boolean':
				$style['color'] = $value ? 'blue': 'red';
				$value = $value ? 'true': 'false';
				break;

			case 'string':
				$style['color'] = 'black';
				$style['font-weight'] = 'bold';
				break;

			case 'integer':
				$style['font-style'] = "italic";
				break;

			case 'double':
				$style['color'] = 'orange';
				$style['font-style'] = "italic";
				break;

			default:
				print $type;
		}

		//	Generate style of span.
		foreach( $style as $key => $var ){
			$styles[] = "$key:$var;";
		}
		$style = join(" ", $styles);

		//	...
		$value = Escape($value);

		//	Generate span of value.
		$span = "<span style=\"{$style}\">$value</span>";

		//	Print mark label.
		$file = $trace['file'];
		$line = $trace['line'];
		$file = CompressPath($file);
		print "<div style=\"color:#999;\">{$file} [$line] $span </div>".PHP_EOL;

		if( $type === 'array' ){
			$json = json_encode($array);
			print "<div class=\"OP_DUMP\">$json</div>";
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
			print __FILE__;
			print '<script type="text/javascript" src="/Notice.js"></script>'.PHP_EOL;
			print '<link rel="stylesheet" type="text/css" href="/Notice.css">'.PHP_EOL;
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
		$timestamp = Time::Date();

		//	...
		$content.= '<table>';
		$content.= "<tr><th> Timestamp	</th><td>{$timestamp}<td></tr>";
		$content.= "<tr><th> User		</th><td>{$user}	 <td></tr>";
		$content.= "<tr><th> UserAgent	</th><td>{$ua}		 <td></tr>";
		$content.= "<tr><th> Host		</th><td>{$host}	 <td></tr>";
		$content.= "<tr><th> URL		</th><td>{$url}		 <td></tr>";
		$content.= "<tr><th> Referer	</th><td>{$referer}	 <td></tr>";
		$content.= '</table>';
		$content.= '<hr/>';

		/*
			Timestamp	2016-11-15 22:29:07
			User	40.77.167.30 --> msnbot-40-77-167-30.search.msn.com
			UserAgent	Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)
			Host	cctokyo.co.jp
			URL	https://cctokyo.co.jp:443/welcome/access/
			Referer
			*/


		//	...
		$to = Env::Get(Env::_ADMIN_MAIL_);
		$subject = $notice['message'];

		//	...
		$mail = new EMail();
		$mail->From($mail->GetLocalAddress());
		$mail->To($to);
		$mail->Subject($subject);
		$mail->Content($content);
		$mail->Send();
	}
}
