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
	static function Tag($tag, $text)
	{
		//	...
		$tag = strtolower($tag);

		//	...
		$text = Escape($text);

		//	...
		$text = nl2br($text);

		//	...
		echo "<{$tag}>{$text}</{$tag}>".PHP_EOL;
	}
}