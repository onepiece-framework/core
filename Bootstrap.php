<?php
/**
 * Bootstrap.php
 *
 * @creation  2015-12-10
 * @rebirth   2016-06-09
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/**
 * Auto start of session.
 */
if(!session_id()){
	session_start();
}

/**
 * Include custome functions.
 */
include_once(__DIR__.'/Functions.php');

/**
 * Include defines.
 */
include_once(__DIR__.'/Defines.php');

/**
 * Security: PHP_SELF has XSS risk.
 */
$_SERVER['PHP_SELF_XSS'] = _EscapeString($_SERVER['PHP_SELF']);
$_SERVER['PHP_SELF'] = $_SERVER['SCRIPT_NAME'];

/**
 * OP_ROOT, APP_ROOT
 */
$_OP[OP_ROOT]  = __DIR__.'/';
$_OP[APP_ROOT] = dirname($_SERVER['SCRIPT_FILENAME']).'/';
$_OP[DOC_ROOT] = $_SERVER['DOCUMENT_ROOT'].'/';

/**
 * Register autoloader.
 */
include(__DIR__.'/Autoloader.class.php');
if(!spl_autoload_register('Autoloader::Autoload',true,true)){
	function __autoload($class){
		Autoloader::Autoload($class);
	}
}

/**
 * Register shutdown function.
 */
register_shutdown_function('Notice::Shutdown');

/**
 * Check mbstring installed.
 */
if(!function_exists('mb_language') ){
	include(__DIR__.'/Template/Introduction/Php/Mbstring.phtml');
	exit();
}
