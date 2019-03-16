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

/** Meta label root path.
 *
 * @param string $meta
 * @param string $path
 */
function RootPath(string $meta='', string $path='')
{
	//	...
	static $root;

	//	...
	if( $meta and $path ){
		$root[$meta] = rtrim($path,'/').'/';
	};

	//	...
	if( $meta ){
		return $root[$meta] ?? null;
	};

	//	...
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
	foreach( RootPath() as $meta => $root ){
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
	//	...
	$root = RootPath();

	//	...
	if(!$pos = strpos($path, ':/') ){
		return false;
	};

	//	...
	$meta = substr($path, 0, $pos);

	//	...
	if( empty($root[$meta]) ){
		return false;
	};

	//	...
	return $root[$meta] . substr($path, $pos+2);
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
	//	...
	$root = RootPath();

	//	...
	if( $pos = strpos($url, ':/') ){

		//	...
		$meta = substr($url, 0, $pos);
		$path = substr($url, $pos+2);

		//	...
		if( empty($root[$meta]) ){
			return false;
		};

		//	Convert to URL from meta path.
		//	app:/foo/bar --> /app/path/foo/bar
		$result = substr($root[$meta] . $path, strlen($_SERVER['DOCUMENT_ROOT']));

	}else if( strpos($url, $_SERVER['DOCUMENT_ROOT']) === 0 ){

		//	Convert to URL from full path.
		//	/var/www/html/app/path/index.html --> /app/path/index.html
		$result = substr($url, strlen($_SERVER['DOCUMENT_ROOT']));
	};

	//	...
	return $result;
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
 * @param  null|integer|float|string|array|object $var
 * @param  integer $length
 * @return string  $hash
 */
function Hasha1($var, $length=8){
	//	...
	if( is_string($var) ){
		//	...
	}else if( is_array($var) or is_object($var) ){
		$var = json_encode($var);
	}

	//	...
	return substr(sha1($var . _OP_SALT_), 0, $length);
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
	//	Decode
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
function Html($string, $attr=null, $escape=true)
{
	//	Escape tag and quote.
	if( $escape ){
		$string = Encode($string);
	}

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
