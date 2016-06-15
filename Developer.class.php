<?php
/**
 * Developer.class.php
 *
 * @creation  2016-06-09
 * @version   1.0
 * @package   core7
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/**
 * Developer
 *
 * @creation  2014-11-29
 * @version   1.0
 * @package   core7
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Developer extends OP
{
	static function _Mark($value, $trace)
	{
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
				$style['color'] = "pink";
				$value = 'null';
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

		//	Print.
		$file = $trace['file'];
		$line = $trace['line'];
		$file = CompressPath($file);
		print "<div style=\"color:#999;\">{$file} [$line] - $span </div>".PHP_EOL;
	}
}
