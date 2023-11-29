<?php

namespace SophieCalixto\App\Domain\Student;

interface SendStudentEmail
{
    public static function sendEmail(Student $student, string $message) : bool|\Exception;
}