<?php
/**
 * Bootstrap.php
 *
 * @creation  2015-12-10
 * @rebirth   2016-06-09
 * @version   1.0
 * @package   core7
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/**
 * @see    http://qiita.com/devneko/items/ee83854eb422c352abc8
 * @param  mixed $check
 * @param  mixed $alternate
 * @return mixed
 */
function ifset(&$check, $alternate = NULL)
{
	return (isset($check)) ? $check : $alternate;
}

//	Check mbstring installed.
if(!function_exists('mb_language') ){
	include(__DIR__.'/Template/introduction-php-mbstring.phtml');
	exit;
}

//	Security: PHP_SELF has XSS risk.
$_SERVER['PHP_SELF_XSS'] = htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES);
$_SERVER['PHP_SELF'] = $_SERVER['SCRIPT_NAME'];

//	OP_ROOT
$_OP['OP_ROOT'] = __DIR__.'/';

//	APP_ROOT
$_OP['APP_ROOT'] = dirname($_SERVER['SCRIPT_FILENAME']).'/';

//	Register autoloader.
include(__DIR__.'/Autoloader.class.php');
if(!spl_autoload_register('Autoloader::Autoload',true,true)){
	function __autoload($class){
		Autoloader::Autoload($class);
	}
}

