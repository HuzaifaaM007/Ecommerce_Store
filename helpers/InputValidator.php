<?php

namespace helpers\InputValidator;


use traits\Logger\Logger;

class InputValidator
{
    use Logger;

    private array $errors = [];

    function requiredFields(string $fieldName, $value): void
    {
        if (empty($value)) {
            $this->errors[$fieldName][] = "This field is required !!!";
            $this->logmessage("$fieldName : This field is required !!!");
        }
    }

    function emailValidator(string $email, $value): void
    {

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$email][] = "Invalid Email Format !!!";
            $this->logmessage("$email : Invalid Email Format !!!");
        }
    }

    function matchvalidator(string $field1, $value1, string $field2, $value2): void
    {

        if ($value1 !== $value2) {
            $this->errors[$field1][] = "Fields donot match !!!";
            $this->logmessage("$field1 : Fields donot match !!!");
        }
    }

    function isValidPassword(string $password)
    {
        if (preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $password)) {
            $this->logmessage("valid password type !!!");
            return preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $password);
        } else {
            $this->logmessage("Invalid password type include char, number, and alphabets !!!");
        }
    }
}