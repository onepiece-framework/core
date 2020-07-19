<?php
/** op-core:/IF_FORM.interface.php
 *
 * @created   2018-04-20
 * @version   1.0
 * @package   op-core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @created   2019-03-04
 */
namespace OP;

/** IF_FORM
 *
 * @created   2018-04-20
 * @version   1.0
 * @package   op-core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
interface IF_FORM
{
	/** Set configuration.
	 *
	 * @created   2018-04-20
	 * @param     array|null  $config
	 * @return    array       $config
	 */
	public function Config($config);

	/** Token validation.
	 *
	 * @created   2019-03-08
	 * @return    boolean    True is token is match.
	 */
	public function Token();

	/** Start form. Output open FORM tag.
	 *
	 * @created   2018-04-20
	 */
	public function Start();

	/** Finish form. Output close FORM tag.
	 *
	 * @created   2018-04-20
	 */
	public function Finish();

	/** Display input label.
	 *
	 * @created   2018-04-20
	 * @param     string    $name
	 */
	public function Label($name);

	/** Display input tag.
	 *
	 * @created   2018-04-20
	 * @param     string    $name
	 */
	public function Input($name);

	/** Display submitted value.
	 *
	 * @created   2018-04-20
	 * @param     string    $name
	 */
	public function Value($name);

	/** Display error message.
	 *
	 * @created   2018-04-20
	 * @param     string    $name
	 */
	public function Error($name);

	/** Clear input value.
	 *
	 * @created   2019-03-08
	 * @param     string    $input_name
	 */
	public function Clear($input_name='');

	/** Overwrite input attributes.
	 *
	 * @created   2018-06-29
	 * @param     array     $input
	 */
	public function SetInput($input);

	/** Overwrite input options.
	 *
	 * @created   2018-06-29
	 * @param     array     $option
	 */
	public function SetOption($input_name, $option);

	/** Get submitted value.
	 *
	 * @created   2018-06-29
	 * @param     string       $name
	 * @param     string|array $value
	 */
	public function GetValue($input_name);

	/** Validate input value.
	 *
	 * @created   2018-06-29
	 * @param     string    $input_name
	 * @return    array     $validate
	 */
	public function Validate($input_name='');

	/** Is validation result.
	 *
	 * <pre>
	 * Return value is null are not match token.
	 * Return value is bool are not match validate.
	 * </pre>
	 *
	 * @created   2019-03-15
	 * @return   null|boolean
	 */
	public function isValidate();
}
