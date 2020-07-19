<?php
/** op-core:/function/table.php
 *
 * @created   2019-11-25
 * @version   1.0
 * @package   op-core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @created   2019-11-25
 */
namespace OP\FUNC\HTML\TABLE;

/** Display table tag.
 *
 * @created   2019-11-25
 * @param     array       $table
 */
function _Build($table)
{
	echo '<table>';
	foreach($table as $key => $val){
		echo '<tr>';
		_TH( \OP\Encode($key) );
		_TD( \OP\Encode($val) );
		echo '</tr>'.PHP_EOL;
	}
	echo '</table>'.PHP_EOL;
}

/** Display th tag.
 *
 * @created  2019-11-25
 * @param    array       $val
 */
function _TH($val)
{
	echo "<th>{$val}</th>";
}

/** Display td tag.
 *
 * @created  2019-11-25
 * @param    array       $td
 */
function _TD($td)
{
	//	...
	$type = strtolower(gettype($td));

	//	...
	echo '<td class="'.$type.'">';

	//	...
	switch( $type ){
		case 'string':
		case 'integer':
		//	$val = $td;
			break;

		case 'null':
			$val = 'null';
			break;

		case 'boolean':
			$val = $td ? 'true':'false';
			break;

		case 'array':
		//	_Build($val);
			$val = null;
			break;

		default:
			$val = $type;
	}

	echo "{$val}";
	echo '</td>'.PHP_EOL;
}
