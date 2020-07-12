<?php
/**
 * Config.php
 *
 * Purpose: Want to combine Env::Get()/Set() and Unit::Config().
 *
 * @created   2019-12-27
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @created   2019-12-27
 */
namespace OP;

/** Config
 *
 * @created   2019-12-27
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Config
{
	/** Config
	 *
	 * @created   2019-12-27
	 * @var       array
	 */
	static $_config;

	/** Init config from asset:/config/{$name}.php
	 *
	 * @created   2019-12-27
	 * @param     string       $name
	 */
	static private function _Init($name)
	{
		//	Force lower case.
		$name = strtolower($name);

		//	Check by class name whether config is initialized.
		if(!isset(self::$_config[$name]) ){

			//	Include closure function.
			$include = function($path){ return include($path); };

			//	Get asset root path.
			$asset_root = RootPath('asset');

			//	Ignore "unit" config. --> Got to infinity loop.
			if( $name !== 'unit' ){
				//	Check exists.
				if( file_exists($path = $asset_root . "unit/{$name}/config.php" ) ){
					//	Load the config file that each unit has by default.
					self::$_config[$name] = $include($path);
				}
			}

			//	Get current directory.
			$save_directory = getcwd();

			//	Chenge config direcotry.
			chdir("{$asset_root}config/");

			//	Correspond to overwrite public config at privete local config.
			//	  --> config.php --> _config.php
			foreach([$name, "_{$name}"] as $file_name){
				//	Check if file exists.
				if( file_exists($path = "{$file_name}.php") ){
					//	Include config.
					$config = $include($path);

					/** About array merge.
					 *
					 *  array_replace_recursive() is all replace.
					 *  array_merge_recursive() is number index is renumbering.
					 *
					 */
					self::$_config[$name] = isset(self::$_config[$name]) ? array_merge(self::$_config[$name], $config) : $config;

					//	Escape.
					continue;
				}

				//	Check if under score file. --> _config.php
				if( $file_name[0] === '_'  ){
					continue;
				}

				//	Flags
				$fail = true;
			}

			//	Recovery save direcotry.
			chdir($save_directory);

			//	...
			if( $fail ?? null ){
				$message = "This config file is not exists. ($name)";
				Debug::Set('file', $message);
			//	Notice::Set($message);
			}
		}

		//	...
		return $name;
	}

	/** Get
	 *
	 * @created   2019-12-27
	 */
	static function Get($name)
	{
		//	...
		$name = self::_Init($name);

		//	...
		return self::$_config[$name] ?? null;
	}

	/** Set
	 *
	 * @created   2019-12-13   Moved Env::Get() --> OP_UNIT::Config()
	 * @moved     2019-12-27   Moved OP_UNIT::Config() --> Config::Set()
	 * @param     string       $name
	 * @param     mixed        $config
	 * @return    mixed
	 */
	static function Set($name, $config)
	{
		//	...
		$name = self::_Init($name);

		/** About array merge.
		 *
		 *  array_replace_recursive() is all replace.
		 *  array_merge_recursive() is number index is renumbering.
		 */
		//	self::$_env[$key] = array_merge_recursive(self::$_env[$key], $var);
		if( $config ){
			//	...
			if( self::$_config[$name] === null ){
				self::$_config[$name]  =  [];
			}

			//	...
			self::$_config[$name] = array_replace_recursive(self::$_config[$name], $config);
		}

		//	...
		return self::$_config[$name];
	}
}
