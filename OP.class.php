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

		//	Checking type of argument.
		$style = $styles = array();
		switch( $type = gettype($value) ){
			case 'object':
				$style['color'] = "green";
				$value = get_class($value);
				break;

			case 'array':
				$style['color'] = "green";
				$value = 'array';
				break;

			case 'NULL':
				$style['color'] = "red";
				$value = func_num_args() ? 'null': '';
				break;

			case 'boolean':
				$style['color'] = $value ? 'blue': 'red';
				$value = $value ? 'true': 'false';
				break;

			case 'string':
				$style['color'] = 'black';
				$style['font-weight'] = 'bold';
				break;

			case 'integer':
				$style['font-style'] = "italic";
				break;

			case 'double':
				$style['color'] = 'orange';
				$style['font-style'] = "italic";
			//	$value = strval($value);
				break;

			default:
				print $type;
		}

		//	Generate style of span.
		foreach( $style as $key => $var ){
			$styles[] = "$key:$var;";
		}
		$style = join(" ", $styles);

		//	Generate span of value.
		$span = "<span style=\"{$style}\">$value</span>";

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
		print "<div style=\"color:#999;\">{$file} [$line] - $span </div>".PHP_EOL;
	}

	static function D()
	{
		self::Mark();
	}
}
