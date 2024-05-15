# PHP Validator Class

This is a simple PHP validation class that can be used to validate form inputs without relying on any frameworks like Laravel. The class supports basic validation rules and integrates Google reCAPTCHA validation.

## Features

- Required fields
- Minimum length validation
- Maximum length validation
- Regular expression validation
- Google reCAPTCHA validation
- File Extension Type
- File Size
- Date format
- DateTime format

## 🎯 Roadmap

- E-mail format validation
- Multiple Selectbox minimum and maximum
- Cloudflare Turnstile
- CSRF Token

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
    'date' => '2023-05-15',
    'datetime' => '2023-05-15 14:30:00',
    'phone' => '123-456-7890',
    'area_code' => '123',
    'g-recaptcha-response' => 'RECAPTCHA_RESPONSE',
    'message' => 'Hello, this is a message',
    'file' => [
        'name' => 'example.jpg',
        'type' => 'image/jpeg',
        'tmp_name' => '/tmp/phpYzdqkD',
        'error' => 0,
        'size' => 204800 // 200 KB
    ]
];
```

## Usage
### Define validation rules
```php
$validator = Validator::make($POST, [
    'name' => 'required|max:70',
    'website_name' => 'required|max:70',
    'website_id' => 'required',
    'date' => 'required|dateFormat:Y-m-d',
    'datetime' => 'required|datetimeFormat:Y-m-d H:i:s',
    'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
    'area_code' => 'required',
    'g-recaptcha-response' => 'required|captcha',
    'message' => 'required',
    'file' => 'required|fileSize:204800|fileType:jpg,png,pdf',
]);
```

### Validate 
```php
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
- `fileSize:[Byte]` : File size must be less than X
- `fileType:[Ext1,Ext2]` : The file format must be in the following formats Ext1,Ext2
- `dateFormat:[FORMAT]` : The field does not match the format [FORMAT]
- `datetimeFormat:[FORMAT]` : The field does not match the format [FORMAT]

## Google reCAPTCHA Integration

To use Google reCAPTCHA, you need to have a reCAPTCHA secret key. Replace `YOUR_SECRET_KEY` in the `validateCaptcha` method with your actual secret key.

## Contributing

Feel free to contribute to this project by opening issues or submitting pull requests. Please ensure that your code follows the coding standards and includes appropriate tests.

## License

This project is licensed under the MIT License.

Feel free to adjust the `README.md` file as needed for your specific use case or project guidelines.