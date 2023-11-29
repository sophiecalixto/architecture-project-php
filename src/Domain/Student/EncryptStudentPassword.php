<?php

namespace SophieCalixto\App\Domain\Student;

interface EncryptStudentPassword
{
    public static function encrypt(string $password) : string;

    public static function compare(string $encryptedPass, string $pass) : bool;
}