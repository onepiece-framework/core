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
	 * Search dispatch route by request uri.
	 *
	 * @return array
	 */
	static private function _Search()
	{
		global $_OP;

		//	...
		$file  = 'index.php'; // Env::Get(Router::_END_POINT_FILE_NAME_, 'index.php');

		//	...
		self::$_route = [];
		self::$_route['args'] = [];

		//	...
		$full_path = $_SERVER['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI'];
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
				array_unshift(self::$_route['args'], $dir);
			}

			//	...
			if( file_exists($_OP[APP_ROOT].$path) ){
				self::$_route[Router::_END_POINT_] = $_OP[APP_ROOT].$path;
				break;
			}

			//	...
		}while( $dir = array_pop($dirs) );

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
			self::_Search();
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