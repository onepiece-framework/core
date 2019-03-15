<?php
/**
 * Autoloader.class.php
 *
 * @creation  2014-11-29  Probably, a single file yet.
 * @updation  2016-06-09  Separate from singe file.
 *
 * @version   2.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** Register autoloder.
 *
 * @creation  2014-11-29  Not spl, Autoload was occupied.
 * @updation  2016-06-09  Change to class.
 * @updation  2019-02-20  Made to extremely simple.
 *
 * @version   3.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
spl_autoload_register( function($class_name)
{
	//	...
	$pos = strpos($class_name, 'OP\\');

	//	...
	if( $pos === false ){
		return;
	};

	//	Check namespace of OP.
	if( $pos === 0 ){
		$class_name = substr($class_name, 3);
	};

	//	Generate each full file path.
	if( strpos($class_name, 'OP_') === 0 ){
		//	Trait
		$path = __DIR__."/trait/{$class_name}.php";
	}else if( strpos($class_name, 'IF_') === 0 ){
		//	Interface
		$path = __DIR__."/interface/{$class_name}.php";
	}else{
		//	Standard onepiece core class.
		$path = __DIR__."/{$class_name}.class.php";
	};

	//	...
	if( file_exists( $path) ){
		include_once($path);
	};
});
