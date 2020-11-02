<?php
/** op-core:/function/IsInt.php
 *
 * @created   2020-10-31
 * @package   op-core
 * @version   1.0
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** Check is integer.
 *
 * @created   2020-10-31
 * @param     string|integer $v
 * @return    boolean
 */
function IsInt($v)
{
	//	...
	if( is_int($v) ){
		return true;
	}

	//	...
	if(!is_numeric($v) ){
		return false;
	}

	//	...
	if( is_float($v) ){
		return false;
	}

	//	...
	if( strpos($v, '.') ){
		return false;
	}

	//	...
	return true;
}
