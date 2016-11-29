/**
 * Template/Js/Dump.js
 *
 * @creation  2016-06-16
 * @version   1.0
 * @package   core7
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

//	Document is ready.
document.addEventListener('DOMContentLoaded', function() {
	//	Start to Dump.
	var dump = document.body.getElementsByClassName('OP_DUMP');
	if( dump ){
		for( var i=0; i<dump.length; i++ ){
			__op_dump(dump[i]);
		}
	}

	//	Dump each notice.
	function __op_dump(dump){
		var json = JSON.parse(dump.innerText);

		//	Get table tag.
		table = __op_table(json);
		//	Reset inner text.
		dump.innerText = "";
		//	Append table to dump tag.
		dump.appendChild(table);
	}

	function __op_table(json){
		var table = document.createElement('table');

		//	...
		if( json === null ){
			var tr = document.createElement('tr');
			var td = document.createElement('td');

			table.appendChild(tr);
			tr.appendChild(td);

			td.innerHTML = '<span class="null">null</span>';
		}

		//	...
		if( json && json.length === 0 ){
			var tr = document.createElement('tr');
			var td = document.createElement('td');
			table.appendChild(tr);
			tr.appendChild(td);
			td.innerHTML = '<span class="empty">(empty)</span>';
		}

		//	...
		for(var i in json){
			var tr = document.createElement('tr');
			var th = document.createElement('th');

			th.innerText = i;
			th.addEventListener("click", __op_th_click, false);
			th.addEventListener("dblclick", __op_th_dblclick, false);
			var td = __op_td(json[i]);

			table.appendChild(tr);
			tr.appendChild(th);
			tr.appendChild(td);
		}

		//	...
		return table;
	}

	function __op_td(value){
		var td   = document.createElement('td');
		var type = typeof value;

		//	...
		switch( type ){
			case 'string':
				var length = value.length;
				break;

			case 'boolean':
				value = '<span class="'+value+'">'+value+'</span>';
				break;

			case 'object':
				return __op_table(value);
		}

		//	...
		var span_type = '<span class="'+type+'">'+type+'</span>';

		//	...
		var span_length = '';
		if( length ){
			var class_length = length < 10 ? 'length1': 'length2';
		//	span_length = '<span class="'+class_length+'">'+'('+length+')'+'</span>';
		}

		//	...
		var head = '<span class="type">['+span_type+span_length+']</span>';

		//	...
		var val = type !== 'string' ? value: __op_value(value);

		//	...
		td.innerHTML = head + val;
		return td;
	}

	function __op_value(value){
		console.log(value);
		var val = value;
			val = val.replace(/ /g,'<span class="space">_</span>');
			val = val.replace(/\t/g,'<span class="tab">\\t</span>');
			val = val.replace(/\n/g,'<span class="line-feed">\\n</span>');
			val = val.replace(/\r/g,'<span class="carriage-return">\\r</span>');
		return val;
	}

	function __op_th_click(){
		if( this.nextSibling.style.display === "none" ){
			this.nextSibling.style.display = "block";
		}else{
			this.nextSibling.style.display = "none";
		}
	}

	function __op_th_dblclick(){

	}
});