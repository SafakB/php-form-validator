# PHP Validator Class

This is a simple PHP validation class that can be used to validate form inputs without relying on any frameworks like Laravel. The class supports basic validation rules and integrates Google reCAPTCHA validation.

## Features

- Required fields
- Maximum length validation
- Regular expression validation
- Minimum length validation
- Google reCAPTCHA validation

## Installation

Simply include the `Validator.php` file in your project.

```php
require_once 'Validator.php';
```

## Sample POST data
```php
$POST = [
    'name' => 'John Doe',
    'website_name' => 'Example Website',
    'website_id' => '123',
    'date' => '2023-05-15 14:30',
    'phone' => '123-456-7890',
    'area_code' => '123',
    'g-recaptcha-response' => 'RECAPTCHA_RESPONSE',
    'message' => 'Hello, this is a message'
];
```

## Usage
### Define validation rules
```php
$validator = Validator::make($POST, [
    'name' => 'required|max:70',
    'website_name' => 'required|max:70',
    'website_id' => 'required',
    'date' => 'required',
    'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
    'area_code' => 'required',
    'g-recaptcha-response' => 'required|captcha',
    'message' => 'required',
]);

// Check if validation fails
if ($validator->fails()) {
    echo json_encode([
        'info' => $validator->messages(),
        'error' => true
    ]);
} else {
    echo json_encode([
        'info' => 'Validation passed',
        'error' => false
    ]);
}
```

## Features

- `required`: The field must not be empty.
- `max:X`: The field must not be longer than X characters.
- `regex`:/pattern/: The field must match the given regular expression.
- `min:X`: The field must be at least X characters long.
- `captcha`: The field must be a valid Google reCAPTCHA response.

## Google reCAPTCHA Integration

To use Google reCAPTCHA, you need to have a reCAPTCHA secret key. Replace `YOUR_SECRET_KEY` in the `validateCaptcha` method with your actual secret key.

## Contributing

Feel free to contribute to this project by opening issues or submitting pull requests. Please ensure that your code follows the coding standards and includes appropriate tests.

## License

This project is licensed under the MIT License.

Feel free to adjust the `README.md` file as needed for your specific use case or project guidelines.