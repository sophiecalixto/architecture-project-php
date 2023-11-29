<?php

namespace SophieCalixto\App\Infrastructure\Student;

use SophieCalixto\App\Domain\Student\EncryptStudentPassword;

class EncryptStudentPasswordService implements EncryptStudentPassword
{
    public static function encrypt(string $password): string
    {
        return md5($password);
    }

    public static function compare(string $encryptedPass, string $pass): bool
    {
        return md5($encryptedPass) == $pass;
    }
}