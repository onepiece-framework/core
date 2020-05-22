<?php
/** op-core:/function/Canonical.php
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

/** Canonical
 *
 * @param    string     $url
 * @return   string     $fqdn
 */
function Canonical($url=null)
{
	$config = Env::Get('canonical');

	//	...
	$scheme = $config['scheme'] ?? empty($_SERVER['HTTPS']) ? 'http':'https';
	$domain = $config['domain'] ?? $_SERVER['HTTP_HOST'];
	$uri    = $url              ?? $_SERVER['REQUEST_URI'];

	//	...
	return "{$scheme}://{$domain}{$uri}";
}
