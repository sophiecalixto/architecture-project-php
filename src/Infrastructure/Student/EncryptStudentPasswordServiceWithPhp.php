<?php

namespace SophieCalixto\App\Infrastructure\Student;

use SophieCalixto\App\Domain\Student\EncryptStudentPassword;

class EncryptStudentPasswordServiceWithPhp implements EncryptStudentPassword
{
    public static function encrypt(string $password): string
    {
        return password_hash($password, PASSWORD_ARGON2ID);
    }

    public static function compare(string $encryptedPass, string $pass): bool
    {
        return password_verify($pass, $encryptedPass);
    }
}