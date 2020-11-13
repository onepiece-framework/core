<?php
/** op-core:/include/json.php
 *
 * @created   2020-10-25
 * @version   1.0
 * @package   op-core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 */
namespace OP;

/** If json string submitted, Overwrite to $_POST.
 *
 */
if(($_SERVER['CONTENT_TYPE'] ?? null) === 'application/json' ){
	$input = file_get_contents("php://input");
	$_POST = json_decode($input, true);
}
