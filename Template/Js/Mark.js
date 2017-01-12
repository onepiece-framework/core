/**
 * Template/Js/Mark.js
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
		var type = json.type;
		var value= json.value;
		var text = '';

		var span_mark = document.createElement('span');
		var span_file = document.createElement('span');
		var span_line = document.createElement('span');
		var span_type = document.createElement('span');
		var span_val  = document.createElement('span');

		//	...
		switch( type ){
			case 'string':
				value = __op_value(value);
			//	break;
			case 'integer':
			case 'double':
				value = '<span class="'+type+'">'+value+'</span>';
				break;

			case 'boolean':
				value = '<span class="boolean '+value+'">'+value+'</span>';
				break;

			case 'NULL':
				value = '<span class="null">null</span>';
				break;

			case 'array':
				console.log(value);
				value = '';
				break;

			case 'object':
				console.log(value);
				value = '';
				break;

			default:
				value = type;
		}

		//	...
		span_mark.classList.add('mark');
		span_file.innerHTML = '<span class="file">'+file+'</span>';
		span_line.innerHTML = '<span class="line-'+String(line).length+'">('+line+')</span>';
	//	span_type.innerHTML = '<span class="type">['+type+']</span>';
		span_val .innerHTML = '<span class="value">'+value+'</span>';

		//	...
		span_mark.appendChild(span_file);
		span_mark.appendChild(span_line);
	//	span_mark.appendChild(span_type);
		span_mark.appendChild(span_val);

		//	...
		mark.innerText = "";
		mark.appendChild(span_mark);
	};

	function __op_value(val){
		val = val.replace(/</g,'&lt;');
		val = val.replace(/>/g,'&gt;');
		val = val.replace(/ /g,'<span class="space">_</span>');
		val = val.replace(/\t/g,'<span class="tab">\\t</span>');
		val = val.replace(/\n/g,'<span class="line-feed">\\n</span>');
		val = val.replace(/\r/g,'<span class="carriage-return">\\r</span>');
		return val;
	}
});
