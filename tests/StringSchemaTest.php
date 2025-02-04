<?php
declare(strict_types=1);

namespace Zod2Schema\Zod2Schema\Tests;

use Zod2Schema\Zod2Schema\Z;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for the StringSchema class.
 */
class StringSchemaTest extends TestCase {
	/**
	 * Test basic string schema.
	 */
	public function testBasicStringSchema() {
		$schema = Z::string()->to_json_schema();

		$this->assertEquals(
			array(
				'type' => 'string',
			),
			$schema
		);
	}

	/**
	 * Test string schema with min and max length.
	 */
	public function testStringSchemaWithMinMax() {
		$schema = Z::string()
			->min( 3 )
			->max( 10 )
			->to_json_schema();

		$this->assertEquals(
			array(
				'type'      => 'string',
				'minLength' => 3,
				'maxLength' => 10,
			),
			$schema
		);
	}

	/**
	 * Test email string schema.
	 */
	public function testEmailStringSchema() {
		$schema = Z::string()
			->email()
			->to_json_schema();

		$this->assertEquals(
			array(
				'type'   => 'string',
				'format' => 'email',
			),
			$schema
		);
	}
}
