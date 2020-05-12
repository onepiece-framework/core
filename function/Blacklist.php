<?php
/** op-core:/function/Blacklist.php
 *
 * @created   2020-05-12
 * @version   1.0
 * @package   op-core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 */
namespace OP;

/** use
 *
 */

/** Blacklist
 *
 * @created   2020-05-12
 * @param     boolean      $add
 * @return    boolean      $io
 */
function Blacklist($add=null)
{
	//	...
	if( $add ){
		//	...
		$_SESSION[_OP_DENY_IP_] = true;

		//	...
		$key = md5($_SERVER['REMOTE_ADDR']);

		//	...
		apcu_add($key, true);
	}

	//	...
	return $_SESSION[_OP_DENY_IP_] ?? null;
}
