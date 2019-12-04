<?php
/**
 * Dump.php
 *
 * Separate from Functions.php.
 * The "D" function has out of need namespace.
 *
 * @creation  2019-02-21
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** Dump of value are displayed only for developers.
 *
 */
function D()
{
	//	If not admin will skip.
	if(!OP\Env::isAdmin()){
		return;
	};

	//	...
	if(!OP\Unit::Load('dump') ){
		//	Throw away last time Notice.
		OP\Notice::Pop();

		//	...
		var_dump(func_get_args());

		//	...
		return;
	};

	//	...
	'\OP\UNIT\Dump'::Mark(func_get_args());
}
