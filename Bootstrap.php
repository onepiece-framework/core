<?php
/**
 * Bootstrap.php
 *
 * @creation  2015-12-10 --> 2016-06-09
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** Checking PHP version.
 *
 */
if( version_compare(PHP_VERSION, '7.0.0') < 0 ){
	exit('<p>onepiece-framework is not support to this php version.('.PHP_VERSION.')</p>');
}

/** Auto start of session.
 *
 */
if(!session_id()){
	if(!session_start() ){
		exit("<h1>Session start was failed.</h1>");
	}
}

/** Include Error hendler.
 *
 */
include_once(__DIR__.'/Error.php');

/** Include defines.
 *
 */
include_once(__DIR__.'/Defines.php');

/** Include custome functions.
 *
 */
include_once(__DIR__.'/Functions.php');

/** Include OP CORE.
 *
 */
include_once(__DIR__.'/OP_CORE.trait.php');

/** Security: PHP_SELF has XSS risk.
 *
 */
$_SERVER['PHP_SELF_XSS'] = _EscapeString($_SERVER['PHP_SELF'], 'utf-8');
$_SERVER['PHP_SELF'] = $_SERVER['SCRIPT_NAME'];

/** Calculate each root path.
 *
 */
(function(){
	//	Call global variable.
	global $_OP;

	//	Decide the order.
	$_OP = [
	     OP_ROOT => null,
	  ASSET_ROOT => null,
	    APP_ROOT => null,
	    DOC_ROOT => null,
	];

	//	Calculate each root path.
	$_OP[ASSET_ROOT] = dirname($_SERVER['SCRIPT_FILENAME']).'/';
	$_OP[   OP_ROOT] = $_OP[ASSET_ROOT].'core/';
	$_OP[  DOC_ROOT] = rtrim($_SERVER['DOCUMENT_ROOT'], '/').'/';
})();

/** Register autoloader.
 *
 */
include(__DIR__.'/Autoloader.class.php');
