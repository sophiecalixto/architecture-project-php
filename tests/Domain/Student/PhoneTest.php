<?php

namespace SophieCalixto\App\Tests\Domain\Student;

use PHPUnit\Framework\TestCase;
use SophieCalixto\App\Domain\Student\Phone;

class PhoneTest extends TestCase
{
    public function testPhoneInInvalidFormatMustNotExist()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Phone('ABC', 'EFG', 'HIJ');
        new Phone("1233", "123", "1234");
        new Phone("xx", "xxxxx", "xxxx");
    }

    public function testPhoneCanBeRepresentedAsString()
    {
        $phone = new Phone("+55", "11", "999999999");
        $this->assertSame("+55 (11) 999999999", (string) $phone);

        // In this test, we assert that the string always represents the same object. That is, we confirm that this is a ValueObject.
    }
}
