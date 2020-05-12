<?php
/** op-core:/function/ConvertURL-1.php
 *
 * @created   2020-03-08
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @creation  2019-02-19
 */
namespace OP;

/** Convert to Document root URL from meta path or full path.
 *
 * This function is for abstract whatever path the application on placed.
 *
 * Example:
 * Document root    --> /var/www/html
 * Application root --> /var/www/html/onepiece-app/
 *
 * ConvertURL('doc:/index.html'); --> /index.html
 * ConvertURL('app:/index.php');  --> /onepiece-app/index.php
 *
 * @param     string       $meta_url
 * @return    string       $document_root_url
 */
function ConvertURL($url)
{
	//	...
	$root = RootPath();

	//	Check if meta URL.
	if( $pos = strpos($url, ':/') ){

		//	Separate to meta label and file path.
		$meta = substr($url, 0, $pos);
		$path = substr($url, $pos+2 );

		//	This meta path has not been set.
		if( empty($root[$meta]) ){
			throw new \Exception("This meta label has not been set. ({$meta})");
		};

		//	Convert to URL from meta path.
		//	app:/foo/bar --> /app/path/foo/bar
		$result = substr($root[$meta] . $path, strlen($_SERVER['DOCUMENT_ROOT'])-1 );
	}else

	//	Check if full path.
	if( strpos($url, $_SERVER['DOCUMENT_ROOT']) === 0 ){
		//	Convert to URL from full path.
		//	/var/www/html/app/path/index.html --> /app/path/index.html
		$result = substr($url, strlen($_SERVER['DOCUMENT_ROOT']));
	};

	//	...
	return $result ?? $url;
}
