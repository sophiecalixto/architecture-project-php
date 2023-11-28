<?php

namespace SophieCalixto\App;

use http\Exception\InvalidArgumentException;

class Email
{
    private string $email;
    public function __construct(string $email)
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Invalid Email!");
        }
        $this->email = $email;
    }
}