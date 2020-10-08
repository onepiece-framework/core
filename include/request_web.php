<?php
/** op-core:/include/request_web.php
 *
 * @created   2020-04-24
 * @version   1.0
 * @package   op-core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 */
namespace OP;

/** use
 *
 */

//	...
$_request = [];

//	...
switch( $_SERVER['REQUEST_METHOD'] ?? null ){
	case 'POST':
		if( $_POST ){
			$_request = $_POST;
		}else{
			switch( $_SERVER['CONTENT_TYPE'] ?? null ){
				case 'application/json':
					$_content = file_get_contents("php://input");
					$_request = json_decode($_content, true);
					break;
				default:
			}
		}

		break;

	case 'GET':
		$_request = $_GET;
		break;

	default:
}

//	...
return $_request;
