<?php
/**
 * OP.class.php
 *
 * @creation  2016-06-09
 * @version   1.0
 * @package   core7
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/**
 * OP
 *
 * @creation  2014-11-29
 * @version   1.0
 * @package   core7
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class OP
{
	/**
	 * Marking line number of file.
	 *
	 * @param string $var
	 */
	static function Mark($value=null)
	{
		//	If not admin will skip.
		if(!Env::isAdmin()){
			return;
		}

		//	null is explicit.
		if( is_null($value) ){
			$value = func_num_args() ? null: '';
		}

		//	Get trace.
		if( version_compare('5.4.0', PHP_VERSION) >= 1 ){
			$trace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT||DEBUG_BACKTRACE_IGNORE_ARGS);
		}else{
			$trace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT||DEBUG_BACKTRACE_IGNORE_ARGS, 1);
		}

		//	Do marking.
		Developer::_Mark($value, $trace[0]);
	}

	static function D()
	{
		self::Mark();
	}
}
