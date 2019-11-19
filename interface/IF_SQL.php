<?php
/**
 * IF_SQL.interface.php
 *
 * @creation  2018-04-20
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

/** IF_SQL
 *
 * @creation  2018-04-20
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
interface IF_SQL
{
	/** Data Definition Language.
	 *
	 * @creation 2019-01-08
	 * @return	 IF_SQL_DDL	 $_DDL
	 */
	public function DDL();

	/** Data Manipulation Language.
	 *
	 * @creation 2019-01-08
	 * @return	 IF_SQL_DML	 $_DML
	 */
	public function DML();

	/** Data Control Language
	 *
	 * @creation 2019-01-08
	 * @return	 IF_SQL_DCL	 $_DCL
	 */
	public function DCL();
}
