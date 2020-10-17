<?php
/** op-core:/include/isLocalhost.php
 *
 * @created   2020-10-17
 * @version   1.0
 * @package   op-core
 * @author    Tomoaki Nagahara<tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 */
namespace OP;

//	Check if http.
if( self::isHttp() ){
	//	...
	$remote_addr = $_SERVER['REMOTE_ADDR'] ?? null;

	//	localhost ip address
	$_is_localhost = ($remote_addr === '127.0.0.1' or $remote_addr === '::1') ? true : false;
}else{
	//	Shell
	$_is_localhost = true;
}

//	...
return $_is_localhost;
