<?php
/** op-core:/IF_SQL_DDL_DROP.interface.php
 *
 * @created   2019-01-08
 * @version   1.0
 * @package   op-core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @created   2019-03-04
 */
namespace OP;

/** IF_SQL_DDL_DROP
 *
 * @created   2019-01-08
 * @version   1.0
 * @package   op-core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
interface IF_SQL_DDL_DROP
{
	/** Construct.
	 *
	 * @created   2019-01-08
	 * @param     IF_DATABASE $_DB
	 */
	public function __construct(IF_DATABASE & $_DB);

	/** Generate Drop User SQL.
	 *
	 * @created   2019-01-08
	 * @param     array     $config
	 * @return    string    $sql
	 */
	public function User(array $config);

	/** Generate Drop Database SQL.
	 *
	 * @created   2019-01-08
	 * @param     array     $config
	 * @return    string    $sql
	 */
	public function Database(array $config);

	/** Generate Drop Table SQL.
	 *
	 * @created   2019-01-08
	 * @param     array     $config
	 * @return    string    $sql
	 */
	public function Table(array $config);
}
