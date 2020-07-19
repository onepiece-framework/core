<?php
/** op-core:/Autoloader.class.php
 *
 * @created   2014-11-29  Perhaps did not yet a single file.
 * @updated   2016-06-09  Separate from singe file.
 * @version   2.0
 * @package   op-core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** Register autoloder.
 *
 * @created   2014-11-29  Autoloader was not spl yet.
 * @updated   2016-06-09  Autoloader is change to spl and class.
 * @updated   2019-02-20  It is no longer a class. Load process is changed to extremely simple.
 * @updated   2019-06-13  Corresponds to UNIT loading.
 * @version   3.0
 * @package   op-core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
spl_autoload_register( function($class_name)
{
	//	Challenge to automatically load of unit.
	if( 0 === strpos($class_name, 'OP\UNIT\\') ){
		//	If that unit name.
		if( 2 === mb_substr_count($class_name, '\\', 'utf-8') ){
			$pos  = strrpos($class_name, '\\');
			$name = substr($class_name, $pos+1);
			OP\Unit::Load($name);
		};
	};

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
