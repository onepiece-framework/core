<?php
/** op-core:/IF_DATABASE.interface.php
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

/** IF_DATABASE
 *
 * @created   2018-04-20
 * @version   1.0
 * @package   op-core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
interface IF_DATABASE
{
	/** Return PDO instance.
	 *
	 * <pre>
	 * $db->PDO()->Query();
	 * </pre>
	 *
	 * @created   2018-04-20
	 * @return   \PDO
	 */
	public function PDO();

	/** Get configuration.
	 *
	 * <pre>
	 * //  Configuration.
	 * $config = [];
	 * $conifg['prod']     = 'mysql';
	 * $conifg['host']     = 'localhost';
	 * $conifg['port']     = '3306';
	 * $conifg['user']     = 'username';
	 * $conifg['password'] = 'password';
	 * $conifg['charset']  = 'utf8';
	 * </pre>
	 *
	 * @addition 2018-11-13
	 * @return	 array		 $config
	 */
	public function Config();

	/** Connect to database. And instantiate PDO.
	 *
	 * @created   2018-04-20
	 * @param     array     $config
	 * @return   \PDO
	 */
	public function Connect($config);

	/** Count number of records at SELECT conditions.
	 *
	 * @created   2018-04-20
	 * @param     array     $config
	 * @return    integer   $count
	 */
	public function Count($config);

	/** Execute SELECT SQL.
	 *
	 * @created   2018-04-20
	 * @param     array     $config
	 */
	public function Select($config);

	/** Execute INSERT SQL.
	 *
	 * @created   2018-04-20
	 * @param     array     $config
	 */
	public function Insert($config);

	/** Execute UPDATE SQL.
	 *
	 * @created   2018-04-20
	 * @param     array     $config
	 */
	public function Update($config);

	/** Execute DELETE SQL.
	 *
	 * @created   2018-04-20
	 * @param     array     $config
	 */
	public function Delete($config);

	/** Quote to SQL at each product.
	 *
	 * @created   2018-04-20
	 * @param     array     $config
	 */
	public function Quote($config);

	/** Execute to SQL query string. And return records array.
	 *
	 * @created   2018-04-20
	 * @param     string    $SQL
	 * @param     string    $type
	 * @return    array     $record
	 */
	public function SQL(string $SQL, string $type);

	/** Execute Quick Query Language string.
	 *
	 * @created   2018-04-20
	 * @param     array     $config
	 */
	public function QQL(string $config, array $options);
}
