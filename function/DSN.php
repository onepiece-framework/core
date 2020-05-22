<?php
/** op-core:/function/DSN.php
 *
 * @created   2020-05-23   Move from Functions.php
 * @package   op-core
 * @version   1.0
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 */
namespace OP;

/** Data Sourse Name parse and build.
 *
 * @created  2019-04-21
 * @param    string|array $value
 * @return   string|array $value
 */
function DSN($arg)
{
	//	...
	if( is_string($arg) ){
		//	...
		$arr = parse_url($arg);

		//	...
		if( $arr['query'] ?? null ){
			$tmp = [];
			parse_str($arr['query'], $tmp);

			//	...
			if( $tmp['pass'] ?? null ){
				$tmp['password'] = $tmp['pass'];
				unset($tmp['pass']);
			};

			//	...
			unset($arr['query']);

			//	...
			$arr = array_merge($arr, $tmp);
		};

		//	...
		return $arr;
	}else

	//	...
	if( is_array($arg) ){
		//	...
		$scheme = $arg['scheme'] ?? 'unknown';

		//	...
		if( $user = ($arg['user'] ?? null) ){
			if( isset($arg['password']) ){
				$user .= ':'.$arg['password'];
				unset($arg['args']['password']);
			}else if( isset( $arg['args']['password']) ){
				$user .= ':'.$arg['args']['password'];
			};

			//	...
			$user .= '@';
		};

		//	...
		$host = $arg['host'];

		//	Add port number to domain name.
		if( $arg['port'] ){
			$host .= ':'.$arg['port'];
		};

		//	...
		$path = $arg['path'] ?? null;

		//	...
		$query = isset($arg['args']) ? '?'.http_build_query($arg['args']) : null;

		//	...
		return "{$scheme}://{$user}{$host}{$path}{$query}";
	}
}
