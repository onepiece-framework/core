<?php
/**
 * Router.class.php
 *
 * This class is part of the "New World".
 *
 * @creation  2015-02-27 (Moved from NewWorld5.)
 * @rebirth   2016-11-26
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/**
 * Router
 *
 * @creation  2015-01-30
 * @rebirth   2016-11-26
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Router extends OnePiece
{
	/**
	 * Use for route table's associative key name.
	 *
	 * @var string
	 */
	const _END_POINT_ = 'end-point';

	/**
	 * Route table.
	 *
	 * @var array
	 */
	private static $_route;

	/**
	 * Init route table.
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

	/**
	 * Get dispatch route by request uri.
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

	/**
	 * Set custom route table.
	 *
	 * @param array $route
	 */
	static function Set($route)
	{
		self::$_route = $route;
	}
}