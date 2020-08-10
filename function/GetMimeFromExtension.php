<?php
/** op-core:/function/GetMimeFromExtension.php
 *
 * @created   2020-08-10
 * @package   op-core
 * @version   1.0
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 */
namespace OP;

/** Get MIME from extension.
 *
 * @param  string $extension
 * @return string $mime
 */
function GetMimeFromExtension(string $ext):string
{
	//	...
	switch( $ext ){
		case 'js':
			$mime = 'text/javascript';
			break;
		case 'css':
			$mime = 'text/css';
			break;
		default:
			$mime = '';
	};

	//	...
	return $mime;
}
