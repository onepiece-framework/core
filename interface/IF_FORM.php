<?php
/**
 * IF_FORM.interface.php
 *
 * @creation  2018-04-20
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @creation  2019-03-04
 */
namespace OP;

/** IF_FORM
 *
 * @creation  2018-04-20
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
interface IF_FORM
{
	/** Set configuration.
	 *
	 * @addition 2018-04-20
	 * @param    array|null  $config
	 * @return   array       $config
	 */
	public function Config($config);

	/** Token validation.
	 *
	 * @addition 2019-03-08
	 * @return   boolean    True is token is match.
	 */
	public function Token();

	/** Start form. Output open FORM tag.
	 *
	 * @addition 2018-04-20
	 */
	public function Start();

	/** Finish form. Output close FORM tag.
	 *
	 * @addition 2018-04-20
	 */
	public function Finish();

	/** Display input label.
	 *
	 * @addition 2018-04-20
	 * @param	 string		 $name
	 */
	public function Label($name);

	/** Display input tag.
	 *
	 * @addition 2018-04-20
	 * @param	 string		 $name
	 */
	public function Input($name);

	/** Display submitted value.
	 *
	 * @addition 2018-04-20
	 * @param	 string		 $name
	 */
	public function Value($name);

	/** Display error message.
	 *
	 * @addition 2018-04-20
	 * @param	 string		 $name
	 */
	public function Error($name);

	/** Clear input value.
	 *
	 * @addition 2019-03-08
	 * @param    string $input_name
	 */
	public function Clear($input_name='');

	/** Overwrite input attributes.
	 *
	 * @addition 2018-06-29
	 * @param	 array		 $input
	 */
	public function SetInput($input);

	/** Overwrite input options.
	 *
	 * @addition 2018-06-29
	 * @param	 array		 $option
	 */
	public function SetOption($input_name, $option);

	/** Get submitted value.
	 *
	 * @addition 2018-06-29
	 * @param	 string			 $name
	 * @param	 string|array	 $value
	 */
	public function GetValue($input_name);

	/** Validate input value.
	 *
	 * @addition 2018-06-29
	 * @param    string  $input_name
	 * @return   array   $validate
	 */
	public function Validate($input_name='');

	/** Is validation result.
	 *
	 * <pre>
	 * Return value is null are not match token.
	 * Return value is bool are not match validate.
	 * </pre>
	 *
	 * @addition 2019-03-15
	 * @return   null|boolean
	 */
	public function isValidate();
}
