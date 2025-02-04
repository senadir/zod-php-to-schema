<?php
declare(strict_types=1);
namespace Zod2Schema\Zod2Schema;

/**
 * Represents a JSON Schema boolean definition.
 */
class BooleanSchema extends Schema {
	/**
	 * BooleanSchema constructor.
	 */
	public function __construct() {
		$this->type = 'boolean';
	}

	/**
	 * Convert the schema definition to a JSON Schema array.
	 *
	 * @return array The JSON Schema representation.
	 */
	public function to_json_schema(): array {
		$schema = array( 'type' => $this->type );

		if ( isset( $this->validators['optional'] ) ) {
			unset( $this->validators['optional'] );
		}

		return $schema;
	}
}
