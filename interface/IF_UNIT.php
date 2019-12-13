<?php
/**
 * IF_UNIT.php
 *
 * @creation  2019-02-20
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @creation  2019-02-20
 */
namespace OP;

/** IF_UNIT
 *
 * @creation  2019-02-20
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
interface IF_UNIT
{
	/** This method is return instantiated object.
	 *
	 * @created   2019-12-13
	 * @param     string       $name
	 * @return    IF_UNIT
	 */
	static function Unit($name);

	/** Testcase
	 *
	 * @created   2019-12-13
	 * @param     array        $args
	 */
	static function Testcase($args);
}
