<?php
/**
 * Layout.class.php
 *
 * This class is part of the "New World".
 *
 * @creation  2015-04-24
 * @rebirth   2016-11-26
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/**
 * Layout
 *
 * @creation  2015-04-24
 * @rebirth   2016-11-26
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Layout extends OnePiece
{
	const _EXECUTE_   = 'layout';
	const _DIRECTORY_ = 'layout-dir';
	const _NAME_      = 'layout-name';
	const _TITLE_     = 'layout-title';

	/**
	 * Dispatched content.
	 *
	 * @var string
	 */
	static private $_content;

	/**
	 * Execute controller.
	 */
	static function Content()
	{
		print self::$_content;
	}

	/**
	 * Dispatch.
	 */
	static function Dispatch()
	{
		//	...
		if(!$layout_dir  = Env::Get(self::_DIRECTORY_)){
			Notice::Set("Has not been set layout directory. (null)");
			return;
		}

		//	...
		if(!$layout_name = Env::Get(self::_NAME_)){
			Notice::Set("Has not been set layout name. (null)");
			return;
		}

		//	Get layout controller file path.
		$full_path = ConvertPath($layout_dir.'/'.$layout_name.'/index.php');

		//	Check exists layout controller.
		if( file_exists($full_path) ){

			//	Execute app's end point. (app's controller)
			$route = Router::Get();

			//	Change current directory.
			chdir(dirname($route['path']));

			//	Buffering content.
			self::$_content = Template::Get($route['path']);

			//	Get layout flag.
			$is_layout = Env::Get(self::_EXECUTE_);
			if( $is_layout === null ){
				Notice::Set("Has not been set layout flag. (null)");
				return;
			}

			//	Would you like to execute the layout?
			if( $is_layout === false ){
				//	Layout is not done.
				print self::$_content;
			}else{
				//	Execute layout.
				include($full_path);
			}
		}else{
			Notice::Set("Does not exists layout controller. ($full_path)");
		}
	}

	/**
	 *
	 */
	static function Title($title=null, $separator='|')
	{
		$_title = Env::Get(self::_TITLE_);
		if( $title ){
			$_title = "{$title} {$separator} {$_title}";
			Env::Set(self::_TITLE_, $_title);
		}else{
			print $_title;
		}
	}
}