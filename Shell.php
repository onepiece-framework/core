<?php
/**
 * Shell.php
 *
 * @created   2019-05-31
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
OP\Env::Mime('text/shell');

//	...
if( $_SERVER['argv'][0] !== 'asset/app.php' ){
	echo "php [asset/app.php] [path] [url-query-string] --> ";
	echo "php asset/app.php {$_SERVER['argv'][0]}\n";
	exit;
};
