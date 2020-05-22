<?php
/** op-core:/function/RootPath.php
 *
 * @created   2020-05-23
 * @package   op-core
 * @version   1.0
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 */
namespace OP;

/** Can register meta root path.
 *
 * @param string $meta
 * @param string $path
 */
function RootPath(string $meta='', string $path='')
{
	//	Stack root list.
	static $root;

	//	Register root path.
	if( $meta and $path ){

		//	Check if exists.
		if( $root[$meta] ?? null ){
			Notice::Set("This meta path already set. ($meta, $path)");
		}

		//	Init
		$root[$meta] = rtrim($path,'/').'/';
	};

	//	Return meta root path.
	if( $meta ){
		return $root[$meta] ?? null;
	};

	//	Return root list.
	return $root;
}
