<?php
/** op-core:/IF_SQL.interface.php
 *
 * @created   2018-04-20
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

/** IF_SQL
 *
 * @created   2018-04-20
 * @version   1.0
 * @package   op-core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
interface IF_SQL
{
	/** Data Definition Language.
	 *
	 * @created  2019-01-08
	 * @return	 IF_SQL_DDL	 $_DDL
	 */
	public function DDL();

	/** Data Manipulation Language.
	 *
	 * @created  2019-01-08
	 * @return	 IF_SQL_DML	 $_DML
	 */
	public function DML();

	/** Data Control Language
	 *
	 * @created  2019-01-08
	 * @return	 IF_SQL_DCL	 $_DCL
	 */
	public function DCL();
}
