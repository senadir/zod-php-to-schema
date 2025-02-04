<?php
declare(strict_types=1);

namespace Nadir\Zod2Schema;

/**
 * Represents a JSON Schema array definition.
 */
class ArraySchema extends Schema {
	/**
	 * Schema for the items in the array.
	 *
	 * @var Schema
	 */
	protected $items_schema;

	/**
	 * ArraySchema constructor.
	 *
	 * @param Schema $items_schema Schema of array items.
	 */
	public function __construct( Schema $items_schema ) {
		$this->type         = 'array';
		$this->items_schema = $items_schema;
	}

	/**
	 * Set the minimum number of items.
	 *
	 * @param int $count Minimum items.
	 * @return $this
	 */
	public function min( int $count ) {
		$this->validators['minItems'] = $count;
		return $this;
	}

	/**
	 * Set the maximum number of items.
	 *
	 * @param int $count Maximum items.
	 * @return $this
	 */
	public function max( int $count ) {
		$this->validators['maxItems'] = $count;
		return $this;
	}

	/**
	 * Specify that the array must not be empty.
	 *
	 * @return $this
	 */
	public function nonempty() {
		$this->validators['minItems'] = max( $this->validators['minItems'] ?? 0, 1 );
		return $this;
	}

	/**
	 * Specify that all items in the array must be unique.
	 *
	 * @return $this
	 */
	public function unique() {
		$this->validators['uniqueItems'] = true;
		return $this;
	}

	/**
	 * Convert the schema definition to a JSON Schema array.
	 *
	 * @return array The JSON Schema representation.
	 */
	public function to_json_schema(): array {
		$schema          = $this->get_base_schema();
		$schema['items'] = $this->items_schema->to_json_schema();
		return $schema;
	}
}
