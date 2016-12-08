/**
 * Template/Js/Notice.js
 *
 * @creation  2016-11-17
 * @version   1.0
 * @package   core7
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

//	Document is ready.
document.addEventListener('DOMContentLoaded', function() {
	//	...
	var div = document.getElementById('OP_NOTICE');
	var root = {};
		root.op  = div.getAttribute("data-OP_ROOT");
		root.app = div.getAttribute("data-APP_ROOT");
		root.doc = div.getAttribute("data-DOC_ROOT");
		console.log(root);

	//	Start to dump.
	var dump = document.body.getElementsByClassName('OP_NOTICE')
	if( dump ){
		for( var i=0; i<dump.length; i++ ){
			__op_dump(dump[i]);
		}
	}

	//	Do dump.
	function __op_dump(dump){
		var json = JSON.parse(dump.innerText);
		var message   = json.message;
		var backtrace = json.backtrace;

		console.log(json);

		dump.innerText = '';
		dump.appendChild(__op_message(json.message));
		dump.appendChild(__op_backtrace(json.backtrace));
	};

	//	Generate message html.
	function __op_message(message){
		var p = document.createElement('p');
			p.innerText = message;
		return p;
	};

	//	Generate backtrace html.
	function __op_backtrace(backtrace){
		var table = document.createElement('table');
		for(var i in backtrace){
			table.appendChild(__op_backtrace_tr(backtrace[i]));
		};
		return table;
	};

	//	Generate backtrace tr html.
	function __op_backtrace_tr(backtrace){
		//	...
		var td1 = document.createElement('td');
		var td2 = document.createElement('td');
		var td3 = document.createElement('td');

		//	Set arguments string.
		var arg = '';
		if( backtrace.args ){
			arg = '(' + JSON.stringify(backtrace.args).slice(1,-1) + ')';
		}else{
			arg = '()';
		}

		//	...
			td1.innerText = __op_backtrace_file(backtrace.file);
			td2.innerText = backtrace.line;
		if( backtrace.type ){
			td3.innerText = backtrace.class + backtrace.type + backtrace.function;
		}else if( backtrace.function ){
			td3.innerText = backtrace.function + arg;
		}

		var tr = document.createElement('tr');
			tr.appendChild(td1);
			tr.appendChild(td2);
			tr.appendChild(td3);
		return tr;
	};

	//	Compress file path.
	function __op_backtrace_file(path){
		//	...
		for(var key in root){
			if( root[key] === path.substr(0, root[key].length ) ){
				return key + ':/' + path.substr(root[key].length);
			}
		};
		return path;
	};
});