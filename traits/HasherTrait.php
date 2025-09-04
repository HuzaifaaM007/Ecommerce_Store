<?php

namespace traits\HasherTrait;

use traits\Logger\Logger;

trait HasherTrait
{
    use Logger;

    function hashPassword(string $password): string
    {
        $hash_Password = password_hash($password, PASSWORD_BCRYPT);
        $this->logmessage("Password hashed correctly ...");
        return $hash_Password;
    }

    function verify_Password(string $password, string $stored_Password): bool
    {
        $validity = password_verify($password, $stored_Password);
        $this->logmessage($validity ? "Password Matched ...":"Password is not valid !!!");
        return $validity;
    }
}
