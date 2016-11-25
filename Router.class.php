<?php
/**
 * Router.class.php
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
	private static $_route;

	/**
	 * Get dispatch route by request uri.
	 *
	 * @return array
	 */
	static function Get()
	{
		if(!self::$_route ){
			self::Search();
		}
		return self::$_route;
	}

	/**
	 * Search dispatch route by request uri.
	 *
	 * @return array
	 */
	static function Search()
	{
		global $_OP;

		//	...
		$file  = 'index.php'; // Env::Get('controller-name', 'index.php');

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
				self::$_route['path'] = $_OP[APP_ROOT].$path;
				break;
			}

			//	...
		}while( $dir = array_pop($dirs) );

		return self::$_route;
	}
}