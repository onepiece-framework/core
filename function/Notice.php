<?php
/** op-core:/function/Notice.php
 *
 * @created   2020-10-07
 * @package   op-core
 * @version   1.0
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 */
namespace OP;

/** Notice
 *
 * @created   2020-10-07
 * @param     string       $message
 * @param     array        $debug_backtrace
 */
function Notice($message, $debug_backtrace)
{
	Notice::Set($message, $debug_backtrace);
}
