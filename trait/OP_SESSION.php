<?php
/**
 * OP_SESSION.php
 *
 * @created   2019-04-10
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @created   2019-04-10
 */
namespace OP;

/** OP_SESSION
 *
 * @created   2019-04-10
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
trait OP_SESSION
{
	/** Get/Set Session
	 *
	 * @created   ????-??-??
	 * @updated   2019-04-10
	 * @return array
	 */
	static function &Session($key=null, $val=null)
	{
		//	...
		$app_id = Env::Get(_OP_APP_ID_);
		$class  = get_called_class();

		//	...
		if( $key ){
			//	...
			if( $val !== null ){
				$_SESSION[$app_id][$class][$key] = $val;
			};
		};

		//	...
		if( $key ){
			return $_SESSION[$app_id][$class][$key];
		}else{
			return $_SESSION[$app_id][$class];
		};
	}
}
