<?php
/**
 * File.class.php
 *
 * @created   2019-06-26
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @created   2019-06-26
 */
namespace OP;

/** Browser
 *
 * @created   2019-06-26
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class File
{
	/** trait.
	 *
	 */
	use OP_CORE;

	/** Touch is file create.
	 *
	 * @created 2019-06-26
	 * @param   string     $path
	 * @throws \Exception
	 */
	static function Touch($path)
	{
		self::Create($path);
	}

	/** Create directory.
	 *
	 * @created 2019-06-26
	 * @param   string     $path
	 * @throws \Exception
	 */
	static function Mkdir($path)
	{
		//	...
		umask(0);

		//	...
		if(!mkdir($path, 0755, true) ){
			throw new \Exception("Create directory has failure. ($path)");
		};
	}

	/** Create file.
	 *
	 * @created 2019-06-26
	 * @param   string     $path
	 * @throws \Exception
	 */
	static function Create($path)
	{
		//	...
		if(!file_exists($dir = dirname($path)) ){
			self::Mkdir($dir);
		};

		//	...
		if(!touch($path) ){
			throw new \Exception("Create file has failure. ($path)");
		};
	}
}
