<?php
/**
 * IF_QQL.interface.php
 *
 * @creation  2018-05-14
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** IF_QQL
 *
 * @creation  2018-05-14
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
interface IF_QQL
{
	/** Parse to QQL from serial string.
	 *
	 * @addition 2018-06-29
	 * @param	 string		 $string
	 * @param	 string		 $options
	 * @return	 array		 $config
	 */
	static public function Parse($string, $options);
}
