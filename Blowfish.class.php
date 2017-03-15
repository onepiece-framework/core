<?php
/**
 * Blowfish.class.php
 *
 * @creation  2017-02-28
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** Blowfish
 *
 * @creation  2017-02-28
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Blowfish
{
	/** trait.
	 *
	 */
	use OP_CORE;

	/** Padding (pkcs5)
	 *
	 * @param  string|binary $data
	 * @param  integer       $blocksize
	 * @return string|binary
	 */
	static function _Padding($data, $blocksize)
	{
		$pad = $blocksize - (strlen($data) % $blocksize);
		return $data . str_repeat(chr($pad), $pad);
	}

	/** Un Padding (pkcs5)
	 *
	 */
	static function _UnPadding($data)
	{
		//	...
		$pad = ord($text{strlen($data)-1});

		//	...
		if( $pad > strlen($data) ){
			return false;
		}

		//	...
		if( strspn($data, chr($pad), strlen($data) - $pad) != $pad ){
			return false;
		}

		//	...
		return substr($data, 0, -1 * $pad);
	}

	/** Encrypt.
	 *
	 * @param  string|binary $data      Correspond to binary data.
	 * @param  string        $keyword   keyword
	 * @param  boolean       $to_string Return value is convert to string from binary.
	 * @return string|binary
	 */
	static function Encrypt($data, $keyword, $to_string=true)
	{
		//	...
		if(!class_exists('mcrypt_encrypt',false) ){
			Notice::Set("The mcrypt module at PHP was not installed.");
			return false;
		}

		//	...
		$cipher	 = 'BLOWFISH';
		$mode	 = 'CBC';
		$pad	 =  true;

		// Padding block size
		if( $pad ){
			$size = mcrypt_get_block_size($cipher, $mode);
			$data = self::_Padding($data, $size);
		}

		//	Init rand
		srand();
		mt_srand();

		// Windows is only use MCRYPT_RAND.
		if( strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ){
			$rand = MCRYPT_RAND;
		}else{
			$rand = MCRYPT_DEV_URANDOM;
		}

		//	...
		$ivs = mcrypt_get_iv_size($cipher, $mode);
		$iv  = mcrypt_create_iv($ivs, $rand);
		$bin = mcrypt_encrypt($cipher, $keyword, $data, $mode, $iv);

		//	...
		return bin2hex($iv).bin2hex($bin);
	}

	/** Decrypt.
	 *
	 */
	static function Decrypt($data, $keyword, $is_string=true)
	{
		//	...
		if(!class_exists('mcrypt_encrypt',false) ){
			Notice::Set("The mcrypt module at PHP was not installed.");
			return false;
		}

		//	...
		$cipher	 = 'BLOWFISH';
		$mode	 = 'CBC';
		$pad	 =  true;

		//	...
		if( $is_string ){
			//	head 16byte is initial vector
			$ivt = substr($data, 0, 16);
			$hex = substr($data, 16);

			//  unpack
			$iv  = pack('H*', $ivt);
			$bin = pack('H*', $hex);
		}else{
			//	...
		}

		//	...
		$data = mcrypt_decrypt( $cipher, $keyword, $bin, $mode, $iv );

		//	Remove padding.
		if( $pad ){
			$data = self::_UnPadding($data);
		}else{
			$data = rtrim($data, "\0");
		}

		return $data;
	}
}