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
			p.innerHTML = message;
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

		//	file path
			td1.innerText = backtrace.file ? __op_backtrace_file(backtrace.file): null;
		//	line number
			td2.innerText = backtrace.line ?                     backtrace.line : null;
		if( backtrace.type ){
		//	class + method + args
			td3.innerHTML  = backtrace.class;
			td3.innerHTML += backtrace.type;
			td3.innerHTML += backtrace.function;
			td3.innerHTML += __op_backtrace_args(backtrace.args);
		}else{
		//	function + args
			td3.innerHTML = backtrace.function + __op_backtrace_args(backtrace.args);
		}

		//	...
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

	//	Generate arguments
	function __op_backtrace_args(args){
		var result;
		if( args ){
			//	Object to string.
			result = JSON.stringify(args);
			//	Remove bracket([]).
			result = result.slice(1,-1);
			//	Add comma(,).
			result = ','+result+',';

			//	true, false, null
			var keys = ['true','false','null'];
			for(var i=0; i<keys.length; i++){
				var key = keys[i];
				result = result.replace(new RegExp(key,"g"),'<span class="'+key+'">'+key+'</span>');
			}

			//	String
			result = result.replace(/,"([^"]+)",/g, ',"<span class="string">$1</span>",');
			//	Remove comma.
			result = result.slice(1,-1);
			//	Add space to after comma.
			result = result.replace(/,/g, ', ');
		}
		return result ? '(<span class="args">' + result + '</span>)': '()';
	};
});
