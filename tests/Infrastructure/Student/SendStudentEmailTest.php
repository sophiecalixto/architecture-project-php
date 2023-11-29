<?php

namespace SophieCalixto\App\Tests\Infrastructure\Student;

use PHPUnit\Framework\TestCase;
use SophieCalixto\App\Domain\Student\Student;
use SophieCalixto\App\Infrastructure\Student\EncryptStudentPasswordServiceWithPhp;
use SophieCalixto\App\Infrastructure\Student\SendStudentEmail;

class SendStudentEmailTest extends TestCase
{
    public function testSendEmail()
    {
        $student = Student::withNameDocumentEmailAndPassword('Sophie Calixto', '453.543.342-42', 'sophiecalixto2004@gmail.com', EncryptStudentPasswordServiceWithPhp::encrypt('123456'))
            ->addPhone('+55', '11', '999999999');
        SendStudentEmail::sendEmail($student, 'Hello, Sophie Calixto!');

        $this->assertTrue(true);
    }
}