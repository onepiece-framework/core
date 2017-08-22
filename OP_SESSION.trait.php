<?php
/**
 * OP_SESSION.trait.php
 *
 * @creation  2017-02-16
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/**
 * OP_SESSION
 *
 * @creation  2017-02-16
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
trait OP_SESSION
{
	/**
	 * Get/Set Session value.
	 *
	 * Separated from each class/object.
	 * Static class and instantiated object to do the same behavior.
	 *
	 * <pre>
	 * //  Save by static class.
	 * OnePiece::Session('test', true);
	 * //  Load by static class.
	 * print OnePiece::Session('test');
	 *
	 * //  Load by instantiated object.
	 * $op = new OnePiece();
	 * print $op->Session('test');
	 * </pre>
	 *
	 * @param string
	 * @param null|boolean|integer|string|array
	 */
	static function Session($key, $value=null)
	{
		static $app_id;
		if(!$app_id){
			if(!$app_id = Env::Get(_OP_APP_ID_) ){
				$app_id = Hasha1(ConvertPath('app:/'));
			}
		}

		//	...
		$class = get_called_class();

		//	...
		if( $value !== null ){
			$_SESSION[_OP_NAME_SPACE_][$app_id][$class][$key] = $value;
		}else{
			return ifset($_SESSION[_OP_NAME_SPACE_][$app_id][$class][$key]);
		}
	}
}
