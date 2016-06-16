/**
 * Template/Js/Dump.js
 *
 * @creation  2016-06-16
 * @version   1.0
 * @package   core7
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
(function(){
	if( dump = document.body.getElementsByClassName('OP_DUMP') ){
		var len = dump.length;
		for( var i=0; i<len; i++ ){
			__op_dump(dump[i]);
		}
	}

	//	Dump each notice.
	function __op_dump(dump){
		var json = JSON.parse(dump.innerText);
		console.log(dump.innerText)
		console.dir(json);

		var table = document.createElement('table');
		dump.innerText = "";
		dump.appendChild(table);

		for( var i in json ){
			console.log(i +': '+ json[i]);

			var tr = document.createElement('tr');
			var th = document.createElement('th');
			var td = document.createElement('td');

			table.appendChild(tr);
			tr.appendChild(th);
			tr.appendChild(td);

			th.innerText = i;
			td.innerText = __op_value(json[i]);
		}
	}

	function __op_value(value){
		var type = typeof value;
		switch(type){
			case 'string':
				var length = value.length;
				break;
		}

		var prefix;
		if( length ){
			prefix = '['+type+' ('+length+')] ';
		}else{
			prefix = '['+type+'] ';
		}

		return prefix + value;
	}
})();
