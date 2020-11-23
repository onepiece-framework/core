<?php
/** op-core:/function/Template.php
 *
 * @created   2020-04-25
 * @version   1.0
 * @package   op-core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 */
namespace OP;

/** Template
 *
 * @created   2020-04-25
 * @version   1.0
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 * @param     string      $file
 * @param     array       $args
 * @throws   \Exception
 */
function Template(string $file, array $args=[])
{
	//	Trim white space.
	$file = trim($file);

	//	Check if full path.
	if( $file[0] === '/' ){
		throw new \Exception("Template function can not specify the full path from root. ($file)");
	}

	//	Check if parent path include.
	if( strpos($file, '..') !== false ){
		throw new \Exception("Does not support specifying parent directory. ($file)");
	}

	//	Check if meta path.
	if( strpos($file, ':') ){
		$file = ConvertPath($file);
	}else{
		$file = RootPath('asset') . 'template/' . $file;
	}

	//	Change real path.
	if(!$path = realpath($file) ){
		throw new \Exception("There are no files in this path. ($file)");
	}

	//	Check if file exists.
	if(!file_exists($path) ){
		throw new \Exception("There are no files in this path. ($path)");
	}

	//	Check if directory include.
	if( strpos($path, '/') !== false ){
		//	Get current directory.
		$save_directory = getcwd();

		//	Chenge direcotry.
		chdir(dirname($path));
	}

	//	Load file.
	try {
		(function() use ($path, $args){
			//	Swap file name. Because avoid conflicts. --> $args['path']
			$md5 = 'file_' . md5(microtime());
			${$md5} = $path;

			//	If variables passed.
			if(!empty($args) ){
				//	Extract passed variables.
				extract($args, null, null);
			};

			//	Execute file.
			include(${$md5});
		});
	}catch(\Throwable $e){
		Notice::Set($e);
	}

	//	Check if directory changed.
	if( $save_directory ?? null ){
		//	Recovery save direcotry.
		chdir($save_directory);
	}
}
