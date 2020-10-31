<?php
/** op-core:/Defines
 *
 * @created   2016-11-25
 * @version   1.0
 * @package   op-core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @created   2020-01-24
 */
namespace OP;

/** Namespace
 *
 * @var string
 */
define('_OP_NAME_SPACE_', 'ONEPIECE', false);

/** App ID
 *
 * @var string
 */
define('_OP_APP_ID_', 'APP_ID', false);

/** Date format. (Not include hour, min, sec)
 *
 * @var string
 */
define('_OP_DATE_', 'Y-m-d', false);

/** Date and time format.
 *
 * @var string
 */
define('_OP_DATE_TIME_', 'Y-m-d H:i:s', false);

/** Developer IP Address.
 *
 * @created   2020-01-24
 * @var       string
 */
define('_OP_DEVELOPER_IP_', 'DEVELOPER_IP', false);

/** Developer E-Mal Address.
 *
 * @created   2020-01-24
 * @var       string
 */
define('_OP_DEVELOPER_MAIL_', 'DEVELOPER_MAIL', false);

/** Deny access IP-Address
 *
 *  The values are hashed so that they do not duplicate.
 *
 * @var string
 */
define('_OP_DENY_IP_', substr(md5(__FILE__), 0, 10), false);

/** If is shell not do blacklist check.
 *
 */
if( isset($_SERVER['SHELL']) ){
	return;
}

/** If empty host name or user agent.
 *
 */
if( empty($_SERVER['HTTP_HOST']) or empty($_SERVER['HTTP_USER_AGENT']) ){
	$_SESSION[_OP_DENY_IP_] = true;
}

/** Deny access.
 *
 * @created   2020-05-11
 */
if( $_SESSION[_OP_DENY_IP_] ?? null ){
	var_dump($_SESSION[_OP_DENY_IP_]);
	exit("Your IP-Adderss in blacklist.");
}
