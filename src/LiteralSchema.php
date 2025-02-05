<?php
declare(strict_types=1);

namespace Zod2Schema\Zod2Schema;

/**
 * Represents a JSON Schema literal definition.
 */
class LiteralSchema extends Schema {
	/**
	 * The literal value.
	 *
	 * @var mixed
	 */
	protected $value;

	/**
	 * LiteralSchema constructor.
	 *
	 * @param mixed $value The literal value.
	 */
	public function __construct( $value ) {
		$this->value = $value;
		$this->type  = gettype( $value );
	}

	/**
	 * Convert the schema definition to a JSON Schema array.
	 *
	 * @return array The JSON Schema representation.
	 */
	public function to_json_schema(): array {
		return array(
			'type'  => $this->type,
			'const' => $this->value,
		);
	}
}
