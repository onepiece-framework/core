<?php
/** op-core:/IF_SQL_DDL.interface.php
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

/** IF_SQL_DDL
 *
 * @created   2019-01-08
 * @version   1.0
 * @package   op-core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
interface IF_SQL_DDL
{
	/** Construct.
	 *
	 * @created   2019-01-08
	 * @param     IF_DATABASE $_DB
	 */
	public function __construct(IF_DATABASE & $_DB);

	/** Generate Show Object.
	 *
	 * @created   2019-01-08
	 * @return    IF_SQL_DDL_SHOW
	 */
	public function Show();

	/** Generate Create Object.
	 *
	 * @created   2019-01-08
	 * @return    IF_SQL_DDL_CREATE
	 */
	public function Create();

	/** Generate Drop Object.
	 *
	 * @created   2019-01-08
	 * @return    IF_SQL_DDL_CREATE
	 */
	public function Drop();

	/** Generate Alter Object.
	 *
	 * @created   2019-01-08
	 * @return    IF_SQL_DDL_CREATE
	 */
	public function Alter();

	/** Generate Truncate SQL.
	 *
	 * @created   2019-01-08
	 */
	public function Truncate();
}
