<?php
declare(strict_types=1);
namespace Nadir\Zod2Schema;

/**
 * Represents a JSON Schema number definition.
 */
class NumberSchema extends Schema {
	/**
	 * NumberSchema constructor.
	 */
	public function __construct() {
		$this->type = 'number';
	}

	/**
	 * Specify that the number should be an integer.
	 *
	 * @return $this
	 */
	public function int() {
		$this->type = 'integer';
		return $this;
	}

	/**
	 * Set the minimum value.
	 *
	 * @param float|int $value Minimum value.
	 * @return $this
	 */
	public function min( $value ) {
		$this->validators['minimum'] = $value;
		return $this;
	}

	/**
	 * Set the maximum value.
	 *
	 * @param float|int $value Maximum value.
	 * @return $this
	 */
	public function max( $value ) {
		$this->validators['maximum'] = $value;
		return $this;
	}

	/**
	 * Specify that the number must be greater than a value (exclusive).
	 *
	 * @param float|int $value The value to compare.
	 * @return $this
	 */
	public function greaterThan( $value ) {
		$this->validators['exclusiveMinimum'] = $value;
		return $this;
	}

	/**
	 * Specify that the number must be less than a value (exclusive).
	 *
	 * @param float|int $value The value to compare.
	 * @return $this
	 */
	public function lessThan( $value ) {
		$this->validators['exclusiveMaximum'] = $value;
		return $this;
	}

	/**
	 * Specify that the number must be positive.
	 *
	 * @return $this
	 */
	public function positive() {
		$this->validators['exclusiveMinimum'] = 0;
		return $this;
	}

	/**
	 * Specify that the number must be negative.
	 *
	 * @return $this
	 */
	public function negative() {
		$this->validators['exclusiveMaximum'] = 0;
		return $this;
	}

	/**
	 * Specify that the number must be a multiple of a given value.
	 *
	 * @param float|int $value The multiple.
	 * @return $this
	 */
	public function multipleOf( $value ) {
		$this->validators['multipleOf'] = $value;
		return $this;
	}

	/**
	 * Convert the schema definition to a JSON Schema array.
	 *
	 * @return array The JSON Schema representation.
	 */
	public function to_json_schema(): array {
		$schema = array( 'type' => $this->type ) + $this->validators;

		if ( isset( $this->validators['optional'] ) ) {
			unset( $schema['optional'] );

		}

		return $schema;
	}
}
