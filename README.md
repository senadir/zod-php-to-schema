# Zod PHP to JSON Schema

Convert Zod-like PHP schema definitions to JSON Schema. This package provides a fluent API for defining schemas in PHP and converting them to JSON Schema format.

## Installation

```bash
composer require nadir/zod-php-to-schema
```

## Usage

```php
use Zod2Schema\Zod2Schema\Z;
use Zod2Schema\Zod2Schema\Schema;

// By default, fields are not required
$userSchema = Z::object([
    'name' => Z::string()->min(2),
    'age' => Z::number()->min(0)->max(120),
    'email' => Z::string()->email(),
    'tags' => Z::array(Z::string())
])->to_json_schema();

echo json_encode($userSchema, JSON_PRETTY_PRINT);
```

Which will output:

```json
{   
    "type": "object",
    "properties": {
        "name": {
            "type": "string",
            "minLength": 2
        },
        "age": {
            "type": "number",
            "minimum": 0,
            "maximum": 120
        },
        "email": {
            "type": "string",
            "format": "email"
        },
        "tags": {
            "type": "array",
            "items": {
                "type": "string"
            }
        }
    }
}
```

You can also enable required fields globally:

```php
use Zod2Schema\Zod2Schema\Z;
use Zod2Schema\Zod2Schema\Schema;

// Enable required fields globally
Schema::set_require_all_fields(true);

// Now all fields will be required by default, but you can mark specific fields as optional
$userSchemaWithOptional = Z::object([
    'name' => Z::string()->min(2),           // required
    'age' => Z::number()->optional(),        // optional
    'email' => Z::string()->email(),         // required
    'tags' => Z::array(Z::string())->optional() // optional
])->to_json_schema();

echo json_encode($userSchemaWithOptional, JSON_PRETTY_PRINT);
```

Which will output:

```json
{
    "type": "object",
    "properties": {
        "name": {
            "type": "string",
            "minLength": 2
        },
        "age": {
            "type": "number",
            "minimum": 0,
            "maximum": 120
        },
        "email": {
            "type": "string",
            "format": "email"
        },
        "tags": {
            "type": "array",
            "items": {
                "type": "string"
            }
        }
    },
    "required": ["name", "email"]
}
```

You can also define a union type:

```php
// Define a union type
$statusSchema = Z::union([
    Z::literal('active'),
    Z::literal('inactive'),
    Z::literal('pending')
])->to_json_schema();

echo json_encode($statusSchema, JSON_PRETTY_PRINT);
```

Which will output:

```json
{
    "anyOf": [
        {
            "type": "string",
            "const": "active"
        },
        {
            "type": "string",
            "const": "inactive"
        },
        {
            "type": "string",
            "const": "pending"
        }
    ]
}
```

## Required Fields

By default, fields are not marked as required in the generated JSON Schema. You can enable required fields globally using:

```php
Schema::set_require_all_fields(true);
```

When enabled:
- All fields are required by default
- Use `optional()` to mark specific fields as optional
- This applies to nested objects as well
- The setting can be toggled on/off as needed

Example with optional fields:
```php
Schema::set_require_all_fields(true);

$schema = Z::object([
    'id' => Z::number(),          // required
    'name' => Z::string(),        // required
    'nickname' => Z::string()->optional(), // optional
    'contact' => Z::object([
        'email' => Z::string()->email(),   // required
        'phone' => Z::string()->optional() // optional
    ])
])->to_json_schema();
```

## Available Schema Types

- `Z::string()` - String schema with various string-specific validations
- `Z::number()` - Number schema with numeric validations
- `Z::boolean()` - Boolean schema
- `Z::array()` - Array schema with item type definitions
- `Z::object()` - Object schema with property definitions
- `Z::literal()` - Literal value schema
- `Z::union()` - Union type schema

### String Schema Methods

- `min(int $length)` - Minimum string length
- `max(int $length)` - Maximum string length
- `email()` - Email format validation
- `url()` - URL format validation
- `regex(string $pattern)` - Regular expression pattern
- `optional()` - Mark the field as optional

### Number Schema Methods

- `min(float $min)` - Minimum value
- `max(float $max)` - Maximum value
- `int()` - Integer validation
- `positive()` - Positive number validation
- `negative()` - Negative number validation
- `optional()` - Mark the field as optional

### Array Schema Methods

- `min(int $length)` - Minimum array length
- `max(int $length)` - Maximum array length
- `nonempty()` - Array must not be empty
- `optional()` - Mark the field as optional

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details. 