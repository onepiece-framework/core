<?php
/**
 * Functions.php
 *
 * @creation  2016-11-16
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @creation  2019-02-19
 */
namespace OP;

/** Used class
 *
 */
use Exception;

/** Meta label root path.
 *
 * @param string $meta
 * @param string $path
 */
function RootPath(string $meta='', string $path='')
{
	//	Stack root list.
	static $root;

	//	Register root path.
	if( $meta and $path ){

		//	Replace duplicate slash.
		$path = str_replace('//', '/', $path);

		//	Added slash to tail.
		$path = rtrim($path, '/');

		//	Check if alias.
		if( isset($root['alias']) ){
			//	Check if match alias root.
			if( strpos($path, $root['alias']) === 0 ){
				//	Replace to app root.
				$path = $root['app'] . substr($path, strlen($root['alias']));
			};
		};

		//	Register.
		$root[$meta] = $path.'/';
	};

	//	Return meta root path.
	if( $meta ){
		//	...
		if( empty($root[$meta]) ){
			throw new \Exception("This meta label has not been set. ($meta)");
		}

		//	...
		return $root[$meta] ?? null;
	};

	//	Return root list.
	return $root;
}

/** Compress to meta path from local file path.
 *
 * <pre>
 * print CompressPath(__FILE__); // -> App:/index.php
 * </pre>
 *
 * @param  string $file_path
 * @return string
 */
function CompressPath($path)
{
	//	...
	foreach( array_reverse(RootPath()) as $meta => $root ){
		//	...
		$pos = strpos($path, $root);

		//	...
		if( $pos === 0 ){
			//	...
			$path = substr($path, strlen($root));

			//	...
			return "{$meta}:/{$path}";
		};
	};

	//	...
	return false;
}

/** Convert to local file path from meta path.
 *
 * <pre>
 * print ConvertPath('app:/index.php'); // -> /www/localhost/index.php
 * </pre>
 *
 * @param  string $meta_path
 * @return string
 */
function ConvertPath($path)
{
	//	Get root list.
	$root = RootPath();

	//	Search meta label.
	/* @var $match array */
	if(!preg_match('|([-_a-z]+):/|', $path, $match) ){
		throw new Exception("This path is not meta path. ({$path})");
	};

	//	Get meta label.
	$meta = $match[1];

	//	Check exists meta label.
	if( empty($root[$meta]) ){
		throw new Exception("This meta label has not been set. ({$meta})");
	};

	//	Return full path.
	return $root[$meta] . substr($path, strlen($meta)+2);
}

/** Convert to Document root URL from meta path or full path.
 *
 * This function is for abstract whatever path the application on placed.
 *
 * Example:
 * Document root    --> /var/www/html
 * Application root --> /var/www/html/onepiece-app/
 *
 * ConvertURL('doc:/index.html'); --> /index.html
 * ConvertURL('app:/index.php');  --> /onepiece-app/index.php
 *
 * @param  string $meta_url
 * @return string $document_root_url
 */
function ConvertURL($url)
{
	//	Check if full path.
	if( $url[0] === '/' and $url[1] !== '/' ){

		//	Calc document root.
		foreach(['doc','alias'] as $key){
			//	...
			$doc_root = RootPath()[$key];

			//	Check if document root.
			if( 0 === strpos($url, $doc_root) ){
				//	Return compressed document root path.
				return substr($url, strlen($doc_root));
			}
		}

		//	...
		throw new \Exception("This full path is not document root path. ($url)");
	}

	//	Separate URL Query.
	if( $pos = strpos($url, '?') ){
		$que = substr($url, $pos);
		$url = substr($url, 0, $pos);
	};

	//	In case of current URL.
	if( $url === '.' ){
		//	...
		$scheme = $_SERVER['REQUEST_SCHEME'];

		//	...
		$host = $_SERVER['HTTP_HOST'];

		//	...
		$uri = $_SERVER['REQUEST_URI'];

		//	...
		return "{$scheme}://{$host}{$uri}";
	};

	//	Convert to full path.
	$full_path = ConvertPath($url);

	//	Document root.
	$doc_root = rtrim($_SERVER['DOCUMENT_ROOT'], '/');

	//	Check whether document root path.
	if( strpos($full_path, $doc_root) !== 0 ){
		throw new Exception("This path has not been document root path. ({$full_path})");
	};

	//	Generate document root path.
	$url = substr($full_path, strlen($doc_root));

	//	Add slash if directory.
	if( is_dir($full_path) ){
		//	Check if already added slash.
		if( $url[strlen($url)-1] !== '/' ){
			$url = rtrim($url, '/') . '/';
		};
	};

	//	Check if had URL Query.
	if( isset($que) ){
		$url .= $que;
	};

	//	Remove document root path.
	return $url;
}

/** Decode
 *
 * @param  mixed  $value
 * @param  string $charset
 * @return string $var
 */
function Decode($value, $charset=null)
{
	//	...
	if(!$charset ){
		$charset = Env::Charset();
	}

	//	...
	switch( gettype($value) ){
		//	...
		case 'string':
			$value = html_entity_decode($value, ENT_QUOTES, $charset);
			break;

		//	...
		case 'array':
			$result = [];
			foreach( $value as $key => $val ){
				$key = is_string($key) ? Decode($key, $charset): $key;
				$val = Decode($val, $charset);
				$result[$key] = $val;
			}
			$value = $result;
			break;

		//	...
		default:
	}

	//	...
	return $value;
}

/** Encode mixed value.
 *
 * @param  mixed  $var
 * @param  string $charset
 * @return mixed  $var
 */
function Encode($value, $charset=null)
{
	//	...
	if(!$charset ){
		$charset = Env::Charset();
	}

	//	...
	switch( gettype($value) ){
		case 'string':
			$value = str_replace("\0", '\0', $value);
			return htmlentities($value, ENT_QUOTES, $charset, false);

		case 'array':
			$result = [];
			foreach( $value as $key => $val ){
				$key = is_string($key) ? Encode($key, $charset): $key;
				$val = Encode($val, $charset);
				$result[$key] = $val;
			}
			$value = $result;
			break;

		case 'object':
			/*
			D("Objects are not yet supported.");
			*/
			$value = get_class($value);
			break;

		default:
	}

	//	...
	return $value;
}

/** To hash
 *
 * This function is convert to fixed length unique string from long or short strings.
 *
 * @param   null|integer|float|string|array|object $var
 * @param   integer  $length
 * @param   string   $salt
 * @return  string   $hash
 */
function Hasha1($var, $length=8, $salt=null)
{
	//	...
	if( $salt === null ){
		$salt = Env::Get(_OP_APP_ID_);
	};

	//	...
	if( is_string($var) ){
		//	...
	}else if( is_array($var) or is_object($var) ){
		$var = json_encode($var);
	}

	//	...
	return substr(sha1($var . $salt), 0, $length);
}

/** ifset
 *
 * @see    http://qiita.com/devneko/items/ee83854eb422c352abc8
 * @param  mixed $check
 * @param  mixed $alternate
 * @return mixed
 */
function ifset(&$check, $alternate=null)
{
	return isset($check) ? $check : $alternate;
}

/** Parse html tag attribute from string to array.
 *
 * @param  string $attr
 * @return array  $result
 */
function Attribute(string $attr)
{
	//	...
	$key = 'tag';
	$result = null;

	//	...
	for($i=0, $len=strlen($attr); $i<$len; $i++){
		//	...
		switch( $attr[$i] ){
			case '.':
				$key = 'class';
				if(!empty($result[$key]) ){
					$result[$key] .= ' ';
				}
				continue 2;

			case '#':
				$key = 'id';
				continue 2;

			case ' ':
				continue 2;

			default:
		}

		//	...
		if( empty($result[$key]) ){
			$result[$key] = '';
		}

		//	...
		$result[$key] .= $attr[$i];
	}

	//	...
	return $result;
}

/** Output secure JSON.
 *
 * @param	 array	 $json
 * @param	 string	 $attr
 */
function Json($json, $attr)
{
	//	HTML Decode
	$json = Decode($json);

	//	Convert to json.
	$json = json_encode($json);

	//	Encode XSS. (Not escape quote)
	$json = htmlentities($json, ENT_NOQUOTES, 'utf-8');

	//	...
	Html($json, 'div.'.$attr, false);
}

/** Display HTML.
 *
 * <pre>
 * Html('message', 'span #id .class');
 * </pre>
 *
 * @param	 string		 $string
 * @param	 string		 $config
 * @param	 boolean	 $escape tag and quote
 */
function Html($string, $attr=null /* , $escape=true */ )
{
	//	Escape tag and quote.
	/*
	if( $escape ){
		$string = Encode($string);
	}
	*/
	$string = Encode($string);

	//	...
	if( $attr ){
		$attr = Attribute($attr);
	}

	//	...
	$tag = $id = $class = null;
	foreach( ['tag','id','class'] as $key ){
		${$key} = $attr[$key] ?? null;
	}

	//	...
	if( empty($tag) ){
		$tag = 'div';
	}

	//	...
	$attr = $id    ? " id='$id'"      :'';
	$attr.= $class ? " class='$class'":'';

	//	...
	if( $tag === 'a' ){
		$attr = ' href="' . $string . '"';
		printf('<%s%s>%s</%s>'.PHP_EOL, $tag, $attr, $string, $tag);
	}else{
		printf('<%s%s>%s</%s>'.PHP_EOL, $tag, $attr, $string, $tag);
	}
}

/** Data Sourse Name parse and build.
 *
 * @created  2019-04-21
 * @param    string|array $value
 * @return   string|array $value
 */
function DSN($arg)
{
	//	...
	if( is_string($arg) ){
		//	...
		$arr = parse_url($arg);

		//	...
		if( $arr['query'] ?? null ){
			$tmp = [];
			parse_str($arr['query'], $tmp);

			//	...
			if( $tmp['pass'] ?? null ){
				$tmp['password'] = $tmp['pass'];
				unset($tmp['pass']);
			};

			//	...
			unset($arr['query']);

			//	...
			$arr = array_merge($arr, $tmp);
		};

		//	...
		return $arr;
	}else

	//	...
	if( is_array($arg) ){
		//	...
		$scheme = $arg['scheme'] ?? 'unknown';

		//	...
		if( $user = ($arg['user'] ?? null) ){
			if( isset($arg['password']) ){
				$user .= ':'.$arg['password'];
				unset($arg['args']['password']);
			}else if( isset( $arg['args']['password']) ){
				$user .= ':'.$arg['args']['password'];
			};

			//	...
			$user .= '@';
		};

		//	...
		$host = $arg['host'];

		//	Add port number to domain name.
		if( $arg['port'] ){
			$host .= ':'.$arg['port'];
		};

		//	...
		$path = $arg['path'] ?? null;

		//	...
		$query = isset($arg['args']) ? '?'.http_build_query($arg['args']) : null;

		//	...
		return "{$scheme}://{$user}{$host}{$path}{$query}";
	}
}
