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
	if( dump = document.body.getElementsByClassName('OP_DUMP') ){
		var len = dump.length;
		for( var i=0; i<len; i++ ){
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

		for( var i in json ){

			var tr = document.createElement('tr');
			var th = document.createElement('th');

			th.innerText = i;
			var td = __op_td(json[i]);

			table.appendChild(tr);
			tr.appendChild(th);
			tr.appendChild(td);
		}
		return table;
	}

	function __op_td(value){
		var td   = document.createElement('td');
		var type = typeof value;

		switch(type){
			case 'string':
				var length = value.length;
				break;
			case 'object':
				return __op_table(value);
		}

		if( length ){
			head = '['+type+' ('+length+')] ';
		}else{
			head = '['+type+'] ';
		}

		td.innerText = head + value;
		return td;
	}
});
