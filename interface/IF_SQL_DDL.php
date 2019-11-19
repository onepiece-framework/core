<?php
/**
 * IF_SQL_DDL.interface.php
 *
 * @creation  2019-01-08
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @creation  2019-03-04
 */
namespace OP;

/** IF_SQL_DDL
 *
 * @creation  2019-01-08
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
interface IF_SQL_DDL
{
	/** Construct.
	 *
	 * @creation 2019-01-08
	 * @param    IF_DATABASE $_DB
	 */
	public function __construct(IF_DATABASE & $_DB);

	/** Generate Show Object.
	 *
	 * @creation 2019-01-08
	 * @return   IF_SQL_DDL_SHOW
	 */
	public function Show();

	/** Generate Create Object.
	 *
	 * @creation 2019-01-08
	 * @return   IF_SQL_DDL_CREATE
	 */
	public function Create();

	/** Generate Drop Object.
	 *
	 * @creation 2019-01-08
	 * @return   IF_SQL_DDL_CREATE
	 */
	public function Drop();

	/** Generate Alter Object.
	 *
	 * @creation 2019-01-08
	 * @return   IF_SQL_DDL_CREATE
	 */
	public function Alter();

	/** Generate Truncate SQL.
	 *
	 * @creation 2019-01-08
	 */
	public function Truncate();
}
