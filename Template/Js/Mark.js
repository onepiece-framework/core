/**
 * op\core:Template/Js/Mark.js
 *
 * @creation  2016-11-30
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

//	Document is ready.
document.addEventListener('DOMContentLoaded', function() {
	//	Start to Mark.
	var mark = document.body.getElementsByClassName('OP_MARK');
	if( mark ){
		for( var i=0; i<mark.length; i++ ){
			__op_mark(mark[i]);
		};
	};

	//	...
	function __op_mark(mark){
		var json = JSON.parse(mark.innerText);
		var file = json.file;
		var line = json.line;
		var args = json.args;
		var text = '';

		var span_mark = document.createElement('span');
		var span_file = document.createElement('span');
		var span_line = document.createElement('span');
		var span_args = document.createElement('span');

		//	...
		span_mark.classList.add('mark');
		span_file.innerHTML = '<span class="file">' + file + '</span>';
		span_line.innerHTML = '<span class="line">' + line + '</span>';
		span_args.innerHTML = '<span class="args">' + __op_args(args) + '</span>';

		//	...
		span_mark.appendChild(span_file);
		span_mark.appendChild(span_line);
		span_mark.appendChild(span_args);

		//	...
		mark.innerText = "";
		mark.appendChild(span_mark);
	};

	//	...
	function __op_args(args){
		//	...
		var html = '';

		//	...
		for(var i=0; i<args.length; i++){
			var arg  = args[i];
			var type = arg.type;
			var val  = arg.value;

			//	...
			if( type === 'string' ){
				val = __op_value_replace(val);
			}
			if( type === 'boolean' ){
				type += ' ' + val;
			}

			//	...
			html += '<span class="value '+type+'">'+val+'</span>';
		}

		//	...
		return html;
	}

	//	...
	function __op_value_replace(val){
		val = val.replace(/</g, '&lt;');
		val = val.replace(/>/g, '&gt;');
		val = val.replace(/ /g, '<span class="space">_</span>');
		val = val.replace(/\t/g,'<span class="tab">\\t</span>');
		val = val.replace(/\n/g,'<span class="line-feed">\\n</span>');
		val = val.replace(/\r/g,'<span class="carriage-return">\\r</span>');
		return val;
	}
});
