<?php
/** op-core:/IF_SQL_DML.interface.php
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

/** IF_SQL_DML
 *
 * @created   2019-01-08
 * @version   1.0
 * @package   op-core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
interface IF_SQL_DML
{
	/** Construct.
	 *
	 * @created   2019-01-08
	 * @param     IF_DATABASE $_DB
	 */
	public function __construct(IF_DATABASE & $_DB);

	/** Generate Insert SQL.
	 *
	 * @created   2019-01-08
	 * @param     array     $config
	 * @return    string    $sql
	 */
	public function Insert(array $config);

	/** Generate Select SQL.
	 *
	 * @created   2019-01-08
	 * @param     array     $config
	 * @return    string    $sql
	 */
	public function Select(array $config);

	/** Generate Update SQL.
	 *
	 * @created   2019-01-08
	 * @param     array     $config
	 * @return    string    $sql
	 */
	public function Update(array $config);

	/** Generate Delete SQL.
	 *
	 * @created   2019-01-08
	 * @param     array     $config
	 * @return    string    $sql
	 */
	public function Delete(array $config);
}
