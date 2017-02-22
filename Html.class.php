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
		//	...
		$temp = [];

		//	...
		if( isset($attr['class']) ){
			$temp[] = sprintf('class="%s"', $attr['class']);
		}

		//	...
		if( isset($attr['style']) ){
			$temp[] = sprintf('style="%s"', $attr['style']);
		}

		//	...
		return ' '.join(' ', $temp);
	}

	/** Output P tag join error class.
	 *
	 * @param string $text
	 */
	static function E($text)
	{
		$class = get_called_class();
		$class::Tag('P', $text, ['class'=>'op error']);
	}

	/** Output P tag.
	 *
	 * @param string $text
	 */
	static function P($text)
	{
		$class = get_called_class();
		$class::Tag(__FUNCTION__, $text);
	}

	/** Output P tag.
	 *
	 * @param string $text
	 */
	static function Span($text)
	{
		$class = get_called_class();
		$class::Tag(__FUNCTION__, $text);
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