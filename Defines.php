<?php
/**
 * Defines
 *
 * @created   2016-11-25
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

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

/** Deny access IP-Address
 *
 *  The values ​​are hashed so that they do not duplicate.
 *
 * @var string
 */
define('_OP_DENY_IP_', substr(md5(__FILE__), 0, 10), false);

/** Deny access.
 *
 * @created   2020-05-11
 */
if( $_SESSION[_OP_DENY_IP_] ?? null ){
	exit("Your IP-Adderss in blacklist.");
}
