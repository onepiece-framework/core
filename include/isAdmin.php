<?php
/** op-core:/include/isAdmin.php
 *
 * @created   2020-04-29
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara<tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 */
namespace OP;

//	...
if( self::isLocalhost() ){
	return true;
}

//	...
$remote_addr = $_SERVER['REMOTE_ADDR'] ?? false;

//	...
if( $remote_addr === ($_SERVER['ADMIN_IP'] ?? null) ){
	return true;
}

//	...
if( $remote_addr === (self::$_env[self::_ADMIN_IP_] ?? null) ){
	return true;
}

//	...
return false;
