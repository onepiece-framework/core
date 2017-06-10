/**
 * op\core:Template/Js/Core.js
 *
 * @creation  2017-01-12
 * @version   1.0
 * @package   core7
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
function CompressPath( path ){
	//	...
	if(!__meta_root__){
		return;
	}

	//	...
	for(var key in __meta_root__){
		var root = __meta_root__[key];
		if( root === path.substr(0, root.length ) ){
			return key + ':/' + path.substr(root.length);
		}
	};

	return path;
}

//	...
function ConvertPath( path ){
	//	...
	if(!__meta_root__){
		return;
	}

	//	...
	var m = path.match(/^([\w]+):/);
	if( m[1] ){
		//	...
		var r = new RegExp('^'+m[1]+':/');
		path = path.replace(r,__meta_root__[m[1]]);

		//	...
		var r = new RegExp('^'+__meta_root__.doc);
		path = path.replace(r,'/');
	}

	//	...
	return path;
}
