<?php
/**
 * IF_SQL_DCL.interface.php
 *
 * @created   2019-01-08
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

 /** namespace
 *
 * @created   2019-03-04
 */
namespace OP;

/** IF_SQL_DCL
 *
 * @created   2019-01-08
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
interface IF_SQL_DCL
{
	/** Construct.
	 *
	 * @created  2019-01-08
	 * @param    IF_DATABASE $_DB
	 */
	public function __construct(IF_DATABASE & $_DB);

	/** Generate Grant SQL.
	 *
	 * @created  2019-01-08
	 * @param    array      $config
	 */
	public function Grant();

	/** Generate Revoke SQL.
	 *
	 * @created  2019-01-08
	 * @param    array       $config
	 */
	public function Revoke(array $config);

	/** Generate Begin SQL.
	 *
	 * @created  2019-01-08
	 * @param    array       $config
	 */
	public function Begin(array $config);

	/** Generate Commit SQL.
	 *
	 * @created  2019-01-08
	 * @param    array       $config
	 */
	public function Commit(array $config);

	/** Generate Rollback SQL.
	 *
	 * @created  2019-01-08
	 * @param    array       $config
	 */
	public function Rollback(array $config);

	/** Generate Lock SQL.
	 *
	 * @created  2019-01-08
	 * @param    array       $config
	 */
	public function Lock(array $config);

	/** Generate Savepoint SQL.
	 *
	 * @created  2019-01-08
	 * @param    array       $config
	 */
	public function Savepoint(array $config);
}
