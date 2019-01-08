<?php
/**
 * Unit.class.php
 *
 * @creation  2016-11-28
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/**
 * Unit
 *
 * <pre>
 * //	Set unit directory.
 * Unit::Director('app:/asset/unit');
 *
 * </pre>
 *
 * @creation  2016-11-28
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Unit
{
	/** trait.
	 *
	 */
	use OP_CORE;

	/** Repository
	 *
	 * @var string
	 */
	const _REPOSITORY_ = 'https://github.com/onepiece-framework/';

	/** Get/Set unit directory.
	 *
	 * @param  string|null         $dir
	 * @return string|null|boolean $dir
	 */
	static function Directory($dir=null)
	{
		static $_dir;

		//	...
		if( $dir ){
			//	...
			if( strpos($dir, ':') ){
				$dir = rtrim(ConvertPath($dir), '/').'/';
			}

			//	...
			if(!file_exists($dir)){
				$message = "Does not exists unit directory. ($dir)";
				Notice::Set($message, debug_backtrace());
				return false;
			}

			//	...
			$_dir = $dir;
		}

		//	...
		return $_dir;
	}

	/** Fetch git repository from github.
	 *
	 * @param  string $name
	 * @return boolean
	 */
	static function Fetch($name)
	{
		//	...
		$save_dir = getcwd();

		//	...
		if(!$unit_dir = Env::Get(self::_DIRECTORY_)){
			return false;
		}

		//	...
		$unit_dir = ConvertPath($unit_dir);

		//	...
		chdir($unit_dir);

		//	...
		$command = 'git clone '. self::_REPOSITORY_ ."unit-{$name}.git $name";
		$return = exec($command, $output, $status);

		//	...
		chdir($save_dir);

		//	...
		switch( ifset($status, 0) ){
			case 0: // successful
				break;

			case 128:
				$status = 'Permission denied';
				break;

			default:
				Notice::Set("Command execution has failed. ($status, $command)");
		}

		//	...
		return $status === 0 ? true: false;
	}

	/** Load of unit controller.
	 *
	 * @param string $name
	 */
	static function Load($name)
	{
		static $_result;

		//	...
		$hash = Hasha1($name);

		//	...
		if( isset( $_result[$hash] ) ){
			return $_result[$hash];
		}

		//	...
			Notice::Set($message, debug_backtrace());
		if(!$dir = self::Directory() ){
			$message = "Has not been set unit directory.\n".' Example: Unit::Directory("app:/asset/unit");';
			return false;
		}

		//	...
		$dir = ConvertPath($dir);
		$dir = realpath($dir);

		//	...
		if(!file_exists($dir)){
			$message = "Does not exists unit directory. ($dir)";
			Notice::Set($message, debug_backtrace());
			return false;
		}

		//	...
		if(!file_exists("{$dir}/{$name}")){
			//	...
			if(!self::Fetch($name) ){
				$message = "Does not exists this unit. ($dir/$name)";
				Notice::Set($message, debug_backtrace());
				return false;
			}
		}

		//	...
		$path = "{$dir}/{$name}/index.php";

		//	...
		if(!file_exists($path)){
			$message = "Does not exists unit controller. ({$name}/index.php)";
			Notice::Set($message, debug_backtrace());
			return false;
		}

		//	...
		$_result[$hash] = include($path);

		//	...
		return $_result[$hash];
	}
}
