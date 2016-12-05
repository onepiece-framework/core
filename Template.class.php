<?php
/**
 * Template.class.php
 *
 * This class is part of the "New World".
 *
 * @rebirth   2016-11-26
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/**
 * Template
 *
 * @rebirth   2016-11-26
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Template extends OnePiece
{
	const _DIRECTORY_ = 'template-dir';

	/**
	 * Get template content.
	 *
	 * @param  string $path
	 * @param  array  $args
	 * @return string
	 */
	static function Get($path, $args=null)
	{
		//	...
		if(!$path){
			Notice::Set('$path is empty.');
			return null;
		}

		//	Start buffering.
		if(!ob_start()){
			Notice::Set("ob_start is failed.");
			return null;
		}

		// Extract array.
		if( is_array($args) and count($args) ){
			if(isset($args[0])){
				Notice::Set('Passed arguments is not an assoc array. Ex. Template::Get("index.phtml", array("key"=>"value")');
			}else{
				extract($args);
			}
		}else if(is_object($args)){
			$name = get_class($args);
			Notice::Set("Object is not correspond. ($name)");
		}

		//	...
		$path = ConvertPath($path);

		//	...
		if( file_exists($path) ){
			include($path);
		}else if( file_exists($full_path = ConvertPath($path)) ){
			include($full_path);
		}else if( $dir = Env::Get(self::_DIRECTORY_) ){
			$dir = ConvertPath($dir);
			if( file_exists($dir) ){
				if( file_exists($dir.'/'.$path) ){
					include($dir.'/'.$path);
				}else{
					Notice::Set("File is not exists. ($dir)");
				}
			}else{
				Notice::Set("This directory is not exists. ($dir)");
			}
		}else{
			Notice::Set("File is not exists. ($path)");
		}

		//	...
		return ob_get_clean();
	}
}