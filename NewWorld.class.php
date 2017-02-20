<?php
/**
 * NewWorld.class.php
 *
 * The NewWorld is the new world.
 *
 * @creation  2009-09-27 at Kozhikode in India.
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** Dispatcher
 *
 * @creation  2017-02-15
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Dispatcher
{
	/** trait
	 *
	 */
	use OP_CORE;

	/** Execute end-point.
	 *
	 * @return string
	 */
	static function Run()
	{
		//	Execute app's end point. (app's controller)
		$route = Router::Get();

		//	Get current directory.
		$cdir = getcwd();

		//	Change current directory.
		chdir(dirname($route[Router::_END_POINT_]));

		//	Execute content.
		try{
			//	Execute end-point.
			$content = Template::Get($route[Router::_END_POINT_]);
		}catch( Exception $e ){
			Notice::Set($e->getMessage(), $e->getTrace());
		}

		//	Recovery current directory.
		chdir($cdir);

		//	...
		return $content;
	}
}

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

	/** Charset
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

	/** Mime
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
}

/** Layout
 *
 * @creation  2017-02-14
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Layout
{
	/** trait.
	 *
	 */
	use OP_CORE;

	/** Constants
	 *
	 * @var string
	 */
	const _EXECUTE_		 = 'layout-execute';
	const _DIRECTORY_	 = 'layout-dir';
	const _NAME_		 = 'layout-name';

	/** Get layout controller.
	 *
	 * @return $string
	 */
	static private function _GetLayoutController()
	{
		//	Get layout directory.
		if(!$layout_dir  = Env::Get(Layout::_DIRECTORY_)){
			$message = "Has not been set layout directory.";
			Notice::Set($message, debug_backtrace());
			return false;
		}

		//	Get layout name.
		if(!$layout_name = Env::Get(Layout::_NAME_)){
			$message = "Has not been set layout name.";
			Notice::Set($message, debug_backtrace());
			return false;
		}

		//	Get layout controller's file path.
		$directory = rtrim(ConvertPath($layout_dir),'/');
		$full_path = "{$directory}/{$layout_name}/index.php";

		//	Check exists layout controller.
		if(!file_exists($full_path)){
			$message = "Does not exists layout controller. ($full_path)";
			Notice::Set($message, debug_backtrace());
			return false;
		}

		//	...
		return $full_path;
	}

	/** Execute layout.
	 *
	 * @param string $content
	 */
	static function Run($content)
	{
		//	Search layout controller.
		if(!$file_path = self::_GetLayoutController()){
			return false;
		}

		//	...
		Template::Run($file_path, ['content'=>$content]);
	}
}

/** Router
 *
 * @creation  2015-01-30 --> 2016-11-26
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Router
{
	/** trait.
	 *
	 */
	use OP_CORE;

	/** Use for route table's associative key name.
	 *
	 * @var string
	 */
	const _END_POINT_ = 'end-point';

	/** Route table.
	 *
	 * @var array
	 */
	private static $_route;

	/** Init route table.
	 *
	 * 1. Search end-point by request uri.
	 * 2. Generate smart-url's arguments by request uri.
	 *
	 * @return array
	 */
	static private function _InitRouteTable()
	{
		global $_OP;

		//	...
		$file  = 'index.php'; // Env::Get(Router::_END_POINT_FILE_NAME_, 'index.php');

		//	...
		self::$_route = [];
		self::$_route['args'] = [];

		//	Generate real full path.
		$full_path = $_SERVER['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI'];

		//	Check url query.
		if( $pos = strpos($full_path, '?') ){
			//	Separate url query.
			$query = substr($full_path, $pos+1);
			$full_path = substr($full_path, 0, $pos);
		}

		//	HTML path through.
		if( true ){
			//	Get extension.
			$extension = substr($full_path, strrpos($full_path, '.')+1);

			//	In case of html.
			if( $extension === 'html' ){
				if( file_exists($full_path) ){
					self::$_route[Router::_END_POINT_] = $full_path;
					return self::$_route;
				}
			}
		}

		//	Added slash to tail. /www/foo/bar --> /www/foo/bar/
		$full_path = rtrim($full_path,DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;

		//	...
		$uri = str_replace($_OP[APP_ROOT], '', $full_path);

		//	...
		$dirs = explode('/', rtrim($uri, DIRECTORY_SEPARATOR));

		//	...
		do{
			//	...
			$path = trim(join(DIRECTORY_SEPARATOR, $dirs).'/'.$file, DIRECTORY_SEPARATOR);

			//	...
			if( isset($dir) ){
				array_unshift(self::$_route['args'], _EscapeString($dir));
			}

			//	...
			if( file_exists($_OP[APP_ROOT].$path) ){
				self::$_route[Router::_END_POINT_] = $_OP[APP_ROOT].$path;
				break;
			}

			//	...
		}while( $dir = array_pop($dirs) );

		//	Return route table.
		return self::$_route;
	}

	/** Get dispatch route by request uri.
	 *
	 * @return array
	 */
	static function Get()
	{
		if(!self::$_route ){
			self::_InitRouteTable();
		}
		return self::$_route;
	}

	/** Set custom route table.
	 *
	 * @param array $route
	 */
	static function Set($route)
	{
		self::$_route = $route;
	}
}

/** Template
 *
 * @creation  2017-02-09
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Template
{
	/** trait.
	 */
	use OP_CORE;

	/** Search to this template directory.
	 *
	 * @var string
	 */
	const _DIRECTORY_ = 'template-dir';

	/** Return real file path from meta path.
	 *
	 * @param  string
	 * @return string
	 */
	static function _GetTemplateFilePath($path)
	{
		//	Convert to real path from meta path.
		if( strpos($path, ':') ){
			$path = ConvertPath($path);
		}

		//	File was found.
		if( file_exists($path) ){
			return $path;
		}

		//	Search to in template directory.
		if( $dir  = Env::Get(self::_DIRECTORY_) ){
			$path = rtrim(ConvertPath($dir), '/').'/'.$path;
			if( file_exists($path) ){
				//	File was found.
				return $path;
			}
		}

		//	...
		Notice::Set("Does not exists this file path. ($file_path)");

		//	...
		return '';
	}

	/** Return executed file content.
	 *
	 * @param  string $file_path
	 * @param  array  $args
	 * @return string
	 */
	static function Get($file_path, $args=null)
	{
		//	...
		if(!ob_start()){
			Notice::Set("ob_start was failed.");
			return;
		}

		//	...
		self::Run($file_path, $args);

		//	...
		return ob_get_clean();
	}

	/** Catch fatal error and Exception.
	 *
	 * @param  string $file_path
	 * @param  array  $args
	 */
	static function Run($file_path, $args=null)
	{
		try {
			//	...
			if(!file_exists($file_path) ){
				//	...
				if(!$file_path = self::_GetTemplateFilePath($file_path)){
					return;
				}
			}

			//	...
			if( $args ){
				if(!$count = extract($args, null, null)){
					$message = "Passed arguments is not an assoc array. (count=$count)";
					Notice::Set($message, debug_backtrace());
				}
			}

			//	...
			$save = getcwd();

			//	...
			chdir( dirname($file_path) );

			//	...
			include($file_path);

			//	...
			chdir($save);

		} catch (Throwable $e) {
			$trace = $e->getTrace();
			$temp  = [];
			$temp['file'] = $e->getFile();
			$temp['line'] = $e->getLine();
			array_unshift($trace, $temp);
			Notice::Set($e->getMessage(), $trace);
		}
	}
}
