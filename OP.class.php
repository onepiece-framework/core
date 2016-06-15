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
	static function Mark($var=null)
	{
		//	If not admin will skip.
		if(!Env::isAdmin()){
			return;
		}

		//	Checking type of argument.
		switch( $type = gettype($var) ){
			case 'object':
				$var = get_class($var);
				break;

			case 'array':
				$var = 'array';
				break;

			case 'NULL':
				$var = func_num_args() ? 'null': '';
				break;

			default:
				print $type;
		}

		//	Get trace.
		if( version_compare('5.4.0', PHP_VERSION) >= 1 ){
			$temp = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT||DEBUG_BACKTRACE_IGNORE_ARGS);
		}else{
			$temp = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT||DEBUG_BACKTRACE_IGNORE_ARGS, 1);
		}

		//	Print.
		$file = $temp[0]['file'];
		$line = $temp[0]['line'];
		$file = CompressPath($file);
		print "<div>{$file}[$line] - $var </div>".PHP_EOL;
	}

	static function D()
	{
		self::Mark();
	}
}
