<?php
/**
 * Error.php
 *
 * @creation  2014-02-18
 * @rebirth   2016-12-07
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/**
 * Error report settings.
 *
 * To display error log to until startuped of the onepiece-framework.
 */
ini_set('display_errors', 1);
error_reporting(E_ALL);

/**
 * Set error handlers.
 */
set_error_handler('_HandlerError', E_ALL);
set_exception_handler('_HandlerException');
register_shutdown_function('_HandlerShutdown');

/**
 * Catch standard error.
 *
 * @see   http://php.net/manual/ja/function.restore-error-handler.php
 * @param integer $errno
 * @param string  $error
 * @param string  $file
 * @param integer $line
 * @param array   $context
 */
function _HandlerError($errno, $error, $file, $line, $context)
{
	switch($errno){
		default:
			Notice::Set($error);
			return true;
	}
}

/**
 * Catch to not caught error.
 *
 * @param Throwable $e
 */
function _HandlerException($e)
{
	Notice::Set($e->getMessage(), $e->getTrace());
}

/**
 * Called back on shutdown.
 *
 * @see http://www.php.net/manual/ja/function.pcntl-signal.php
 */
function _HandlerShutdown()
{
	if( $error = error_get_last() ){
		_HandlerError($error['type'], $error['message'], $error['file'], $error['line'], null);
	}
}
