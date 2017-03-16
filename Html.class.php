<?php
/**
 * Html.class.php
 *
 * @creation  2017-02-17
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/**
 * Html
 *
 * @creation  2017-02-17
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Html
{
	/** trait.
	 *
	 */
	use OP_CORE;

	/** Convert attribute.
	 *
	 * @param  array  $attr
	 * @return string
	 */
	static function _attribute($attr)
	{
		if( is_string($attr) ){
			foreach( explode(' ', $attr) as $temp ){
				switch($temp{0}){
					case '.':
						$classes[] = substr($temp, 1);
						break;

					case '#':
						$ids = substr($temp, 1);
						break;
					default:
						D("Does not define this type. ($temp)");
				}
			}

			//	...
			$result = '';

			//	...
			if( isset($ids) ){
				$result = sprintf(' id="%s"', $ids);
			}

			//	...
			if( isset($classes) ){
				$result .= sprintf(' class="%s"', join(' ', $classes));
			}

			return $result;
		}

		//	...
		$temp = [];

		//	...
		if( isset($attr['class']) ){
			$temp[] = sprintf(' class="%s"', $attr['class']);
		}

		//	...
		if( isset($attr['style']) ){
			$temp[] = sprintf(' style="%s"', $attr['style']);
		}

		//	...
		return join(' ', $temp);
	}

	/** Output P tag join error class.
	 *
	 * @param string $text
	 */
	static function E($text, $arrt=null)
	{
		if( empty($attr['class']) ){
			$attr['class'] = 'op error';
		}
		$class = get_called_class();
		$class::Tag('P', $text, $attr);
	}

	/** Output P tag.
	 *
	 * @param string $text
	 */
	static function P($text, $arrt=null)
	{
		$class = get_called_class();
		$class::Tag(__FUNCTION__, $text, $arrt);
	}

	/** Output P tag.
	 *
	 * @param string $text
	 */
	static function Span($text, $arrt=null)
	{
		$class = get_called_class();
		$class::Tag(__FUNCTION__, $text, $arrt);
	}

	/** Output P tag.
	 *
	 * @param string $text
	 */
	static function Tag($tag, $text, $attr=null)
	{
		//	...
		$tag = strtolower($tag);

		//	...
		$text = Escape($text);

		//	...
		$text = nl2br($text);

		//	...
		if( $attr ){
			$class = get_called_class();
			$attr  = $class::_attribute($attr);
		}

		//	...
		echo "<{$tag}{$attr}>{$text}</{$tag}>".PHP_EOL;
	}
}