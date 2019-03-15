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
		exit("<p>Session start was failed.</p>");
	}
}

/** Register autoloader.
 *
 */
include(__DIR__.'/Autoloader.php');

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

/** Include custome functions.
 *
 */
include_once(__DIR__.'/D.php');

/** Include OP CORE.
 *
 */
include_once(__DIR__.'/trait/OP_CORE.php');
