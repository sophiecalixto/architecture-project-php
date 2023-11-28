<?php

namespace SophieCalixto\App\Tests\Domain\Student;

use PHPUnit\Framework\TestCase;
use SophieCalixto\App\Domain\Student\Document;

class DocumentTest extends TestCase
{
    public function testDocumentInInvalidFormatMustNotExist()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Document("123123123123");
        new Document("ABCDEFGHIJK");
        new Document("101101101-1011");
    }

    public function testDocumentCanBeRepresentedAsString()
    {
        $document = new Document("222.222.222-22");
        $this->assertSame("222.222.222-22", (string) $document);

        // In this test, we assert that the string always represents the same object. That is, we confirm that this is a ValueObject.
    }
}