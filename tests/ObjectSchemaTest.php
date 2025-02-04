<?php
declare(strict_types=1);

namespace Nadir\Zod2Schema\Tests;

use Nadir\Zod2Schema\Z;
use Nadir\Zod2Schema\Schema;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for the ObjectSchema class.
 */
class ObjectSchemaTest extends TestCase {
	/**
	 * Set up the test environment.
	 */
	protected function setUp(): void {
		parent::setUp();
		// Reset the flag before each test.
		Schema::set_require_all_fields( false );
	}

	/**
	 * Test basic object schema without required fields.
	 */
	public function testBasicObjectSchemaWithoutRequired() {
		$schema = Z::object(
			array(
				'name' => Z::string(),
				'age'  => Z::number(),
			)
		)->to_json_schema();

		$this->assertEquals(
			array(
				'type'       => 'object',
				'properties' => array(
					'name' => array( 'type' => 'string' ),
					'age'  => array( 'type' => 'number' ),
				),
			),
			$schema
		);
	}

	/**
	 * Test basic object schema with required fields.
	 */
	public function testBasicObjectSchemaWithRequired() {
		Schema::set_require_all_fields( true );

		$schema = Z::object(
			array(
				'name' => Z::string(),
				'age'  => Z::number(),
			)
		)->to_json_schema();

		$this->assertEquals(
			array(
				'type'       => 'object',
				'properties' => array(
					'name' => array( 'type' => 'string' ),
					'age'  => array( 'type' => 'number' ),
				),
				'required'   => array( 'name', 'age' ),
			),
			$schema
		);
	}

	/**
	 * Test object schema with optional fields.
	 */
	public function testObjectSchemaWithOptionalFields() {
		Schema::set_require_all_fields( true );

		$schema = Z::object(
			array(
				'name'  => Z::string(),
				'age'   => Z::number()->optional(),
				'email' => Z::string()->email(),
			)
		)->to_json_schema();

		$this->assertEquals(
			array(
				'type'       => 'object',
				'properties' => array(
					'name'  => array( 'type' => 'string' ),
					'age'   => array( 'type' => 'number' ),
					'email' => array(
						'type'   => 'string',
						'format' => 'email',
					),
				),
				'required'   => array( 'name', 'email' ),
			),
			$schema
		);
	}

	/**
	 * Test nested object schema without required fields.
	 */
	public function testNestedObjectSchemaWithoutRequired() {
		$schema = Z::object(
			array(
				'user' => Z::object(
					array(
						'name'    => Z::string(),
						'contact' => Z::object(
							array(
								'email' => Z::string()->email(),
								'phone' => Z::string(),
							)
						),
					)
				),
			)
		)->to_json_schema();

		$this->assertEquals(
			array(
				'type'       => 'object',
				'properties' => array(
					'user' => array(
						'type'       => 'object',
						'properties' => array(
							'name'    => array( 'type' => 'string' ),
							'contact' => array(
								'type'       => 'object',
								'properties' => array(
									'email' => array(
										'type'   => 'string',
										'format' => 'email',
									),
									'phone' => array(
										'type' => 'string',
									),
								),
							),
						),
					),
				),
			),
			$schema
		);
	}

	/**
	 * Test nested object schema with required fields.
	 */
	public function testNestedObjectSchemaWithRequired() {
		Schema::set_require_all_fields( true );

		$schema = Z::object(
			array(
				'user' => Z::object(
					array(
						'name'    => Z::string(),
						'contact' => Z::object(
							array(
								'email' => Z::string()->email(),
								'phone' => Z::string()->optional(),
							)
						),
					)
				),
			)
		)->to_json_schema();

		$this->assertEquals(
			array(
				'type'       => 'object',
				'properties' => array(
					'user' => array(
						'type'       => 'object',
						'properties' => array(
							'name'    => array( 'type' => 'string' ),
							'contact' => array(
								'type'       => 'object',
								'properties' => array(
									'email' => array(
										'type'   => 'string',
										'format' => 'email',
									),
									'phone' => array(
										'type' => 'string',
									),
								),
								'required'   => array( 'email' ),
							),
						),
						'required'   => array( 'name', 'contact' ),
					),
				),
				'required'   => array( 'user' ),
			),
			$schema
		);
	}

	/**
	 * Test object with array schema without required fields.
	 */
	public function testObjectWithArraySchemaWithoutRequired() {
		$schema = Z::object(
			array(
				'name' => Z::string(),
				'tags' => Z::array( Z::string() ),
			)
		)->to_json_schema();

		$this->assertEquals(
			array(
				'type'       => 'object',
				'properties' => array(
					'name' => array( 'type' => 'string' ),
					'tags' => array(
						'type'  => 'array',
						'items' => array( 'type' => 'string' ),
					),
				),
			),
			$schema
		);
	}

	/**
	 * Test object with array schema with required fields.
	 */
	public function testObjectWithArraySchemaWithRequired() {
		Schema::set_require_all_fields( true );

		$schema = Z::object(
			array(
				'name' => Z::string(),
				'tags' => Z::array( Z::string() )->optional(),
			)
		)->to_json_schema();

		$this->assertEquals(
			array(
				'type'       => 'object',
				'properties' => array(
					'name' => array( 'type' => 'string' ),
					'tags' => array(
						'type'  => 'array',
						'items' => array( 'type' => 'string' ),
					),
				),
				'required'   => array( 'name' ),
			),
			$schema
		);
	}
}
