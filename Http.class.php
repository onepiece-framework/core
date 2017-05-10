<?php
/**
 * Http.class.php
 *
 * @creation  2017-05-09
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** Http
 *
 * @creation  2017-02-16
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Http
{
	/** trait.
	 *
	 */
	use OP_CORE;

	/** Output MIME (User land)
	 *
	 * @var string
	 */
	const _MIME_		 = 'output-mime';

	/** Output charset (User land)
	 *
	 * @var string
	 */
	const _CHARSET_		 = 'output-charset';

	/** Get/Set Charset
	 *
	 * @param  string $mime
	 * @return string
	 */
	static function Charset($charset=null)
	{
		//	...
		static $_charset;

		//	...
		if( $charset ){
			$_charset = $charset;
		}else{
			return $_charset;
		}
	}

	/** Get access domain name by url.
	 *
	 * @return string
	 */
	static function Domain()
	{
		return $_SERVER['SERVER_NAME'];
	}

	/** Get current server's host name.
	 *
	 * @return string
	 */
	static function Host()
	{
		return $_SERVER['HTTP_HOST'];
	}

	/** Set header.
	 *
	 * @param string $key
	 * @param string $val
	 */
	static function Header($key, $val)
	{
		header("$key: $val");
	}

	/** Set location.
	 *
	 * @param string $url
	 */
	static function Location($url)
	{
		if( headers_sent($file, $line) ){
			Notice::Set("Header has already been sent. ($file, $line)");
		}else{
			if( strpos($url, 'app:/') !== false ){
				$url = ConvertURL($url);
			}
			Header("Location: $url");
			exit;
		}
	}

	/** Get/Set Mime.
	 *
	 * @param  string $mime
	 * @return string
	 */
	static function Mime($mime=null)
	{
		//	...
		static $_mime;

		//	...
		if( $mime ){
			//	...
			if( headers_sent($file, $line) ){
				Notice::Set("Header has already sent. ($file, $line)");
			}else{
				//	...
				$_mime = strtolower($mime);

				//	...
				$header = "Content-type: $mime";

				//	...
				if( $charset = self::Charset() ){
					$header .= "; charset={$charset}";
				}

				//	...
				header($header);

				//	...
				if( $mime !== 'text/html' ){
					//	Disable layout system.
					Env::Set(Layout::_EXECUTE_, false);
				}
			}
		}else{
			return $_mime;
		}
	}

	/** Get request each http's request method.
	 *
	 * @return array
	 */
	static function Request($method=null)
	{
		//	...
		if(!$method){
			$method = $_SERVER['REQUEST_METHOD'];
		}

		//	...
		switch( strtolower($method) ){
			case 'get':
				$request = Escape($_GET);
				break;
			case 'post':
				$request = Escape($_POST);
				break;
			default:
				$request = [];
		}

		//	...
		return $request;
	}
}
