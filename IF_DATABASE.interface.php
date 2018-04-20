<?php
/**
 * IF_DATABASE.interface.php
 *
 * @creation  2018-04-20
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** IF_DATABASE
 *
 * @creation  2018-04-20
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
interface IF_DATABASE
{
	public function PDO();
	public function Connect($config);
	public function Insert($config);
	public function Select($config);
	public function Update($config);
	public function Delete($config);
	public function Quick($config);
	public function Query($config);
	public function Quote($config);
	public function Queries($config);
}
