<?php
/**
 * NewWorld.class.php
 *
 * @creation  2009-09-27 at Kozhikode in India.
 * @version   1.0
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/**
 * NewWorld
 *
 * The NewWorld is the new world.
 *
 * NewWorld's job:
 *  1. Execute end-point file. (Generally is called a controller)
 *  2. Wrap to result of end-point (content) at layout.
 *
 * @creation  2009-09-27, 2016-12-11
 * @version   1.0
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
abstract class NewWorld extends OnePiece
{
	/**
	 * Buffered content.
	 *
	 * @var string
	 */
	private $_content;

	/**
	 * Execute end-point.
	 *
	 * @return string
	 */
	private function _ExecuteEndPoint()
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
			$this->_content = $this->GetTemplate($route[Router::_END_POINT_]);
		}catch( Exception $e ){
			Notice::Set($e->getMessage(), $e->getTrace());
		}

		//	Recovery current directory.
		chdir($cdir);
	}

	/**
	 * Get layout controller.
	 *
	 * @return $string
	 */
	private function _GetLayoutController()
	{
		//	Get layout directory.
		if(!$layout_dir  = Env::Get(Layout::_DIRECTORY_)){
			$message = "Has not been set layout directory. (null)";
			Notice::Set($message, debug_backtrace());
			return false;
		}

		//	Get layout name.
		if(!$layout_name = Env::Get(Layout::_NAME_)){
			$message = "Has not been set layout name. (null)";
			Notice::Set($message, debug_backtrace());
			return false;
		}

		//	Get layout controller's file path.
		$full_path = ConvertPath($layout_dir.'/'.$layout_name.'/index.php');

		//	Check exists layout controller.
		if(!file_exists($full_path)){
			$message = "Does not exists layout controller. ($full_path)";
			Notice::Set($message, debug_backtrace());
			return false;
		}

		//	...
		return $full_path;
	}

	/**
	 * Get real file path.
	 *
	 * @param  string
	 * @return string
	 */
	private function _GetTemplateFilePath($path)
	{
		$result = false;

		if( file_exists($path) ){
			$result = $path;
		}else if( file_exists($full_path = ConvertPath($path)) ){
			$result = $full_path;
		}else if( $dir = Env::Get(Template::_DIRECTORY_) ){
			$full_path = ConvertPath($dir).'/'.$path;
			if( file_exists($full_path) ){
				$result = $full_path;
			}
		}

		return $result;
	}

	/**
	 * Output buffered content.
	 *
	 * @param string $content
	 */
	function Content($content=null)
	{
		print $this->_content;
	}

	/**
	 * "Dispatch" is execute end-point, and do layout.
	 */
	function Dispatch()
	{
		//	Search layout controller.
		if(!$layout_controller_path = $this->_GetLayoutController()){
			return false;
		}

		//	Execute end-point.
		$this->_ExecuteEndPoint();

		//	Get layout flag.
		$is_layout = Env::Get(Layout::_EXECUTE_);
		if( $is_layout === null ){
			$message = "Has not been set layout flag. (null)";
			Notice::Set($message, debug_backtrace());
			return;
		}

		//	Would you like to execute the layout?
		if( $is_layout === false ){
			//	Layout is not done.
			$this->Content();
		}else{
			//	Execute layout.
			include($layout_controller_path);
		}
	}

	/**
	 * Get template content.
	 *
	 * @param  string $path
	 * @param  array  $args
	 * @return string
	 */
	function GetTemplate($path, $args=null)
	{
		//	...
		if(!$path){
			$message = '$path is empty.';
			Notice::Set($message, debug_backtrace());
			return null;
		}

		//	Start buffering.
		if(!ob_start()){
			$message = "ob_start is failed.";
			Notice::Set($message, debug_backtrace());
			return null;
		}

		//	...
		if( $full_path = $this->_GetTemplateFilePath($path) ){
			// Extract array.
			if( is_array($args) and count($args) ){
				if(isset($args[0])){
					$message = 'Passed arguments is not an assoc array. Ex. Template::Get("index.phtml", array("key"=>"value")';
					Notice::Set($message, debug_backtrace());
				}else{
					extract($args);
				}
			}else if(is_object($args)){
				$name = get_class($args);
				$message = "Object is not correspond. ($name)";
				Notice::Set($message, debug_backtrace());
			}

			//	...
			include($full_path);
		}else{
			$message = "File is not exists. ($path)";
			Notice::Set($message, debug_backtrace());
		}

		//	...
		return ob_get_clean();
	}
}

/**
 * Layout
 *
 * <pre>
 * app:/app/layout-dir/layout-name/index.php
 * </pre>
 *
 * @creation  2015-04-24, 2016-11-26
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Layout extends OnePiece
{
	const _EXECUTE_		 = 'layout-execute';
	const _DIRECTORY_	 = 'layout-dir';
	const _NAME_		 = 'layout-name';
}

/**
 * Template
 *
 * @separated 2016-11-26
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Template extends OnePiece
{
	/**
	 * Search to this template directory.
	 *
	 * @var string
	 */
	const _DIRECTORY_ = 'template-dir';
}