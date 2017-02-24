/**
 * op\core:Template/Js/Notice.js
 * 
 * <pre>
 * For IE example.
 * 
 * if (window.XMLHttpRequest){
 *   xmlHttp = new XMLHttpRequest();
 * }else{
 *   if (window.ActiveXObject){
 *     xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
 *   }else{
 *     xmlHttp = null;
 *   }
 * }
 * </pre>
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
	setTimeout(__op_notice_fetch, 1000);

	//	...
	function __op_notice_fetch(){
		var xhr = new XMLHttpRequest();
		if(!xhr){
			console.log("XMLHttpRequest was failed.");
			return;
		}
		var url = null;
		var doc = __meta_root__.doc;
		var app = __meta_root__.app;
		if( doc === app.substr( 0, doc.length ) ){
			url = '/' + app.substr(doc.length) + 'api/notice/load';
		}else{
			console.log("FAIL: "+ doc +' != '+ app.substr(0, doc.length));
			return;
		}

		//	...
		xhr.onreadystatechange = function(){
			/**
			 * 0 = uninitialized
			 * 1 = loading
			 * 2 = loaded
			 * 3 = interactive
			 * 4 = complete
			 */
			var state  = this.readyState;
			/**
			 * 200	OK
			 * 401	Unauthorized
			 * 403	Forbidden
			 * 404	Not Found
			 * 500	Internal Server Error
			 */
			var status = this.status;
			if( state === 4 && status === 200 ){
				var type = xhr.getResponseHeader('content-type');
				var text = this.responseText;

				//	...
				if( type.substr(0, 9) !== 'text/json' ){
					console.log('Not json.' + url);
					console.log(xhr.getAllResponseHeaders());
					console.log(text);
					return;
				}

				//	...
				var json = JSON.parse(text);
				if( json.result ){
					json.result.forEach(function(value, index, parent){
						__op_notice(value);
					});
				}
			}
		};
	//	xhr.setRequestHeader();
		xhr.open("GET", url, true);
		xhr.send(null);
	//	xhr.abort();
	};

	//	Do dump.
	function __op_notice(json){
		console.log(json);

		//	...
		var message   = json.message;
		var backtrace = json.backtrace;

		//	...
		var html = document.getElementsByTagName('html');
		var body = document.getElementsByTagName('body');
		var div  = document.createElement('div');

		//	...
		body[0].appendChild(div);
		div.className = 'OP_NOTICE';
		div.appendChild(__op_message(json.message));
		div.appendChild(__op_backtrace(json.backtrace));
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
		return CompressPath(path);
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
