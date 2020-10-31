<?php
/** op-core:/function/Unit.php
 *
 * @created   2020-05-23
 * @package   op-core
 * @version   1.0
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 */
namespace OP;

/** Return already instantiated object.
 *
 * This method that I thought of seems to be called the singleton pattern in the world.
 *
 * <pre>
 * $unit= Unit('unit_name');
 * </pre>
 *
 * @created   2020-03-06
 * @param     string       $unit_name
 * @return    IF_UNIT
 */
function & Unit($name):IF_UNIT
{
	//	...
	static $_unit;

	//	...
	if( empty($_unit[$name]) ){
		$_unit[$name] = Unit::Instantiate($name);
	}

	//	...
	return $_unit[$name];
}
