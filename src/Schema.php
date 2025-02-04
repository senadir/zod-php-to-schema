<?php
declare(strict_types=1);

namespace Zod2Schema\Zod2Schema;

/**
 * Base Schema class for Zod-like schema definitions
 *
 * @package ZodPHPSchema
 */
abstract class Schema {
	/**
	 * Global flag to control whether fields are required by default.
	 *
	 * @var bool
	 */
	protected static $require_all_fields = false;

	/**
	 * The data type of the schema (e.g., string, number).
	 *
	 * @var string
	 */
	protected $type;

	/**
	 * An array of validators and options applied to the schema.
	 *
	 * @var array
	 */
	protected $validators = array();

	/**
	 * Convert the schema definition to a JSON Schema array.
	 *
	 * @return array The JSON Schema representation.
	 */
	abstract public function to_json_schema(): array;

	/**
	 * Constructor.
	 *
	 * @param bool $is_required Whether the schema is required by default.
	 */
	public function __construct( bool $is_required = true ) {
		$this->optional = ! $is_required;
	}

	/**
	 * Mark this schema as optional.
	 *
	 * @return self
	 */
	public function optional(): self {
		$this->validators['optional'] = true;
		return $this;
	}

	/**
	 * Add a custom validation rule.
	 *
	 * @param string $name  The name of the validation rule.
	 * @param mixed  $value The value of the validation rule.
	 * @return $this
	 */
	public function add_validator( string $name, $value ) {
		$this->validators[ $name ] = $value;
		return $this;
	}

	/**
	 * Set whether all fields should be required by default.
	 *
	 * @param bool $required Whether to require all fields.
	 */
	public static function set_require_all_fields( bool $required ): void {
		self::$require_all_fields = $required;
	}

	/**
	 * Get whether all fields should be required by default.
	 *
	 * @return bool
	 */
	public static function should_require_all_fields(): bool {
		return self::$require_all_fields;
	}

	/**
	 * Check if the schema is marked as optional.
	 *
	 * @return bool
	 */
	public function is_optional(): bool {
		return isset( $this->validators['optional'] ) && true === $this->validators['optional'];
	}

	/**
	 * Get the base schema without any optional handling.
	 *
	 * @return array
	 */
	protected function get_base_schema(): array {
		$schema = array( 'type' => $this->type );
		foreach ( $this->validators as $key => $value ) {
			if ( 'optional' !== $key ) {
				$schema[ $key ] = $value;
			}
		}
		return $schema;
	}

	/**
	 * Check if the schema is marked as required.
	 *
	 * @return bool
	 */
	public function is_required(): bool {
		return $this->is_optional() === false;
	}
}
