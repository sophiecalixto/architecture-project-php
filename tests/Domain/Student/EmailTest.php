<?php

namespace SophieCalixto\App\Tests\Domain\Student;

use PHPUnit\Framework\TestCase;
use SophieCalixto\App\Domain\Student\Email;

class EmailTest extends TestCase
{
    public function testEmailInInvalidFormatMustNotExist()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Email("abcd@abc.");
        new Email("ABC");
        new Email("ABC2@2");
    }

    public function testEmailCanBeRepresentedAsString()
    {
        $email = new Email("test@test.com");
        $this->assertSame("test@test.com", (string) $email);

        // In this test, we assert that the string always represents the same object. That is, we confirm that this is a ValueObject.
    }
}