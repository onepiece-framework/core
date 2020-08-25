<?php
/** op-core:/function/DSN.php
 *
 * @created   2020-08-24
 * @version   1.0
 * @package   op-core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 */
namespace OP;

/** DSN
 *
 * @created   2020-08-24
 * @param     string|array
 * @return    string|array
 */
function DSN($dsn=null)
{
	if( $dsn ){
		/* @var $queries array */

		//	Parse DSN.
		$parsed = parse_url($dsn);

		//	Password.
		$parsed['password'] = $parsed['pass'];
		unset($parsed['pass']);

		//	Parse URL Query.
		parse_str($parsed['query'], $queries);

		//	Return merged array.
		return array_merge($parsed, $queries);
	}else{
		/* @var $query string */
	}
}
