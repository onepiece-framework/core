<?php
/** op-core:/function/Template.php
 *
 * @created   2020-05-10
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
 * @created   2020-05-10
 * @param     string       $function
 * @param     array        $args
 * @throws   \Exception
 */
function Template(string $path, array $args=[]):void
{
	//	Trim white space.
	$path = trim($path);

	//	Check if full path.
	if( $path[0] === '/' ){
		throw new \Exception("Template function can not specify the full path from root. ($path)");
	}

	//	Convert path.
	$path = ConvertPath($path);

	//	Save current directory.
	$current_dir = getcwd();

	//	Change to execute file in directory.
	chdir( dirname($path) );

	//	Get file name.
	$name = basename($path);

	//	Sandbox
	call_user_func(function($name, $args){

		//	Swap file name.
		$md5 = 'file_' . md5(microtime());
		${$md5} = $name;

		//	If variables passed.
		if(!empty($args) ){
			//	Extract passed variables.
			extract($args, null, null);
		};

		//	Execute file.
		include(${$md5});

	}, $name, $args);

	//	Recovery last directory.
	chdir($current_dir);
}
