<?php
class Validator
{
    protected $data;
    protected $rules;
    protected $errors = [];

    public function __construct($data, $rules)
    {
        $this->data = $data;
        $this->rules = $rules;
    }

    public static function make($data, $rules)
    {
        return new self($data, $rules);
    }

    public function fails()
    {
        $this->validate();
        return !empty($this->errors);
    }

    public function messages()
    {
        return $this->errors;
    }

    protected function validate()
    {
        foreach ($this->rules as $field => $rules) {
            $rules = explode('|', $rules);
            foreach ($rules as $rule) {
                if (strpos($rule, ':')) {
                    list($rule, $param) = explode(':', $rule);
                } else {
                    $param = null;
                }
                $method = "validate" . ucfirst($rule);
                if (method_exists($this, $method)) {
                    $this->$method($field, $param);
                }
            }
        }
    }

    protected function validateRequired($field)
    {
        if (empty($this->data[$field])) {
            $this->errors[$field][] = "The $field field is required.";
        }
    }

    protected function validateMax($field, $param)
    {
        if (strlen($this->data[$field]) > $param) {
            $this->errors[$field][] = "The $field field may not be greater than $param characters.";
        }
    }

    protected function validateRegex($field, $param)
    {
        if (!preg_match($param, $this->data[$field])) {
            $this->errors[$field][] = "The $field field format is invalid.";
        }
    }

    protected function validateMin($field, $param)
    {
        if (strlen($this->data[$field]) < $param) {
            $this->errors[$field][] = "The $field field must be at least $param characters.";
        }
    }

    protected function validateCaptcha($field)
    {
        $secretKey = 'YOUR_SECRET_KEY'; // replace with your actual secret key
        $response = $this->data[$field];
        $remoteIp = $_SERVER['REMOTE_ADDR'];

        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = [
            'secret' => $secretKey,
            'response' => $response,
            'remoteip' => $remoteIp
        ];

        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            ]
        ];
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $resultJson = json_decode($result);

        if (!$resultJson->success) {
            $this->errors[$field][] = "The $field field is invalid.";
        }
    }

    protected function validateFileSize($field, $param)
    {
        if (isset($this->data[$field]) && $this->data[$field]['size'] > $param) {
            $this->errors[$field][] = "The $field file size may not be greater than " . ($param / 1024) . " KB.";
        }
    }

    protected function validateFileType($field, $param)
    {
        if (isset($this->data[$field])) {
            $fileType = pathinfo($this->data[$field]['name'], PATHINFO_EXTENSION);
            $allowedTypes = explode(',', $param);
            if (!in_array($fileType, $allowedTypes)) {
                $this->errors[$field][] = "The $field file type must be one of the following: " . implode(', ', $allowedTypes) . ".";
            }
        }
    }
}