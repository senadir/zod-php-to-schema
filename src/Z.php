<?php
/**
 * Zod PHP to Schema - Main Factory Class
 *
 * This file contains the main factory class for creating schema objects.
 * It provides static methods to create various types of schemas for validation.
 *
 * @package ZodPHPSchema
 * @license MIT
 */

declare(strict_types=1);
namespace Nadir\Zod2Schema;

/**
 * Schema builder class for creating JSON Schema definitions.
 */
class Z {
	/**
	 * Create a string schema.
	 *
	 * @return StringSchema
	 */
	public static function string() {
		return new StringSchema();
	}

	/**
	 * Create a number schema.
	 *
	 * @return NumberSchema
	 */
	public static function number() {
		return new NumberSchema();
	}

	/**
	 * Create a boolean schema.
	 *
	 * @return BooleanSchema
	 */
	public static function boolean() {
		return new BooleanSchema();
	}

	/**
	 * Create an array schema.
	 *
	 * @param Schema $items_schema Schema for the array items.
	 * @return ArraySchema
	 */
	public static function array( Schema $items_schema ) {
		return new ArraySchema( $items_schema );
	}

	/**
	 * Create an object schema.
	 *
	 * @param array $shape Associative array defining object properties.
	 * @return ObjectSchema
	 */
	public static function object( array $shape ) {
		return new ObjectSchema( $shape );
	}

	/**
	 * Create a union schema.
	 *
	 * @param Schema[] $schemas Array of schemas to unite.
	 * @return UnionSchema
	 */
	public static function union( array $schemas ) {
		return new UnionSchema( $schemas );
	}

	/**
	 * Create a literal schema.
	 *
	 * @param mixed $value The literal value.
	 * @return LiteralSchema
	 */
	public static function literal( $value ) {
		return new LiteralSchema( $value );
	}

	// Additional methods as needed...
}
