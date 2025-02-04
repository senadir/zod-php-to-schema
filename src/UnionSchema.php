<?php
declare(strict_types=1);

namespace Zod2Schema\Zod2Schema;

/**
 * Represents a JSON Schema union definition.
 */
class UnionSchema extends Schema {
	/**
	 * Array of schema instances.
	 *
	 * @var Schema[]
	 */
	protected $schemas;

	/**
	 * UnionSchema constructor.
	 *
	 * @param Schema[] $schemas Array of schema instances.
	 */
	public function __construct( array $schemas ) {
		$this->schemas = $schemas;
	}

	/**
	 * Convert the schema definition to a JSON Schema array.
	 *
	 * @return array The JSON Schema representation.
	 */
	public function to_json_schema(): array {
		$schemas_array = array();
		foreach ( $this->schemas as $schema ) {
			$schemas_array[] = $schema->to_json_schema();
		}

		return array( 'anyOf' => $schemas_array );
	}
}
