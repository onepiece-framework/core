<?php
/**
 * Encrypt.class.php
 *
 * @created   2017-11-22
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @created   2019-02-20
 */
namespace OP;

/** Encrypt
 *
 * @created   2017-11-22
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Encrypt
{
	/** trait.
	 *
	 */
	use OP_CORE;

	/** Cipher method
	 *
	 * @var string
	 */
	const algorithm = 'aes-256-cbc';

	/** Generate Initial vector.
	 *
	 */
	static function _iv()
	{
		$source = $_SERVER["_OP_OPENSSL_IV_"] ?? Env::AppID();
		$source = md5($source);
		return substr($source, 0, 16);
	}

	/** Generate password.
	 *
	 */
	static function _password()
	{
		$source = $_SERVER["_OP_OPENSSL_PASSWORD_"] ?? Env::AppID();
		$source = md5($source);
		return $source;
	}

	/** Dec is Decoding.
	 *
	 * @param string $str
	 * @param string $str
	 */
	static function Dec($str)
	{
		//	...
		$iv       = self::_iv();
		$password = self::_password();

		//	...
		return openssl_decrypt($str, self::algorithm, $password, 0, $iv);
	}

	/** Enc is Encoding.
	 *
	 * @param string $str
	 * @param string $str
	 */
	static function Enc($str)
	{
		//	...
		$iv       = self::_iv();
		$password = self::_password();

		//	...
		return openssl_encrypt($str, self::algorithm, $password, 0, $iv);
	}
}
