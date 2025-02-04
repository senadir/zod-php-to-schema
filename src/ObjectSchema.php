<?php
declare(strict_types=1);

namespace Zod2Schema\Zod2Schema;

/**
 * Represents a JSON Schema object definition.
 */
class ObjectSchema extends Schema {
	/**
	 * Original schema objects for each property.
	 *
	 * @var array
	 */
	protected $property_schemas = array();

	/**
	 * ObjectSchema constructor.
	 *
	 * @param array $shape Associative array defining properties.
	 */
	public function __construct( array $shape ) {
		$this->type = 'object';

		foreach ( $shape as $key => $schema ) {
			$this->property_schemas[ $key ] = $schema;
		}
	}

	/**
	 * Set additional properties.
	 *
	 * @param bool $allow Whether to allow additional properties.
	 * @return $this
	 */
	public function additionalProperties( bool $allow ) {
		$this->validators['additionalProperties'] = $allow;
		return $this;
	}

	/**
	 * Set pattern properties.
	 *
	 * @param string $pattern Regex pattern for property names.
	 * @param Schema $schema  Schema for matching properties.
	 * @return $this
	 */
	public function patternProperties( string $pattern, Schema $schema ) {
		$this->validators['patternProperties'][ $pattern ] = $schema->to_json_schema();
		return $this;
	}

	/**
	 * Convert the schema definition to a JSON Schema array.
	 *
	 * @return array The JSON Schema representation.
	 */
	public function to_json_schema(): array {
		$schema = $this->get_base_schema();

		// Convert property schemas to JSON Schema.
		$properties = array();
		foreach ( $this->property_schemas as $key => $property_schema ) {
			// For nested schemas, we need to use to_json_schema() to get their full structure.
			$properties[ $key ] = $property_schema instanceof ObjectSchema || $property_schema instanceof ArraySchema
				? $property_schema->to_json_schema()
				: $property_schema->get_base_schema();
		}
		$schema['properties'] = $properties;

		// Add required fields only if the global flag is set.
		if ( self::should_require_all_fields() ) {
			// Only include non-optional fields in required array.
			$required = array();
			foreach ( $this->property_schemas as $key => $property_schema ) {
				if ( ! $property_schema->is_optional() ) {
					$required[] = $key;
				}
			}
			if ( ! empty( $required ) ) {
				$schema['required'] = $required;
			}
		}

		return $schema;
	}
}
