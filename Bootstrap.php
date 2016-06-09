<?php
/**
 * Bootstrap.php
 *
 * @created   2016-06-09
 * @version   1.0
 * @package   core7
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

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
include(__DIR__.'/Autoloader.php');
if(!spl_autoload_register('Autoloader::Autoload',true,true)){
	function __autoload($class){
		Autoloader::Autoload($class);
	}
}

