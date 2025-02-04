<?php
declare(strict_types=1);

namespace Zod2Schema\Zod2Schema;

/**
 * Represents a JSON Schema string definition.
 */
class StringSchema extends Schema {
	/**
	 * StringSchema constructor.
	 */
	public function __construct() {
		$this->type = 'string';
	}

	/**
	 * Set the minimum length of the string.
	 *
	 * @param int $length Minimum length.
	 * @return $this
	 */
	public function min( int $length ) {
		$this->validators['minLength'] = $length;
		return $this;
	}

	/**
	 * Set the maximum length of the string.
	 *
	 * @param int $length Maximum length.
	 * @return $this
	 */
	public function max( int $length ) {
		$this->validators['maxLength'] = $length;
		return $this;
	}

	/**
	 * Specify that the string should match an email format.
	 *
	 * @return $this
	 */
	public function email() {
		$this->validators['format'] = 'email';
		return $this;
	}

	/**
	 * Specify exact length of the string.
	 *
	 * @param int $length Exact length.
	 * @return $this
	 */
	public function length( int $length ) {
		$this->validators['minLength'] = $length;
		$this->validators['maxLength'] = $length;
		return $this;
	}

	/**
	 * Set a regular expression pattern that the string must match.
	 *
	 * @param string $pattern The regex pattern.
	 * @return $this
	 */
	public function regex( string $pattern ) {
		$this->validators['pattern'] = $pattern;
		return $this;
	}

	/**
	 * Specify that the string should be a valid URL.
	 *
	 * @return $this
	 */
	public function url() {
		$this->validators['format'] = 'uri';
		return $this;
	}

	/**
	 * Specify that the string should be a valid UUID.
	 *
	 * @return $this
	 */
	public function uuid() {
		$this->validators['format'] = 'uuid';
		return $this;
	}

	/**
	 * Convert the schema definition to a JSON Schema array.
	 *
	 * @return array The JSON Schema representation.
	 */
	public function to_json_schema(): array {
		return $this->get_base_schema();
	}
}
