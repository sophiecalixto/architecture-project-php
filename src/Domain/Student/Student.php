<?php

namespace SophieCalixto\App\Domain\Student;

class Student
{
    private string $name;
    private Document $document;
    private Email $email;
    private array $phones;
    private string $password;

    public static function withNameDocumentEmailAndPhones($name, $document, $email, array $phones) : self
    {
        $student = new Student($name, new Document($document), new Email($email));
        $student->phones = $phones;
        return $student;
    }

    public static function withNameDocumentEmailAndPassword($name, $document, $email, $password) : self
    {
        $student = new Student($name, new Document($document), new Email($email));
        $student->password = $password;
        return $student;
    }

    public function __construct(string $name, Document $document, Email $email)
    {
        $this->name = $name;
        $this->document = $document;
        $this->email = $email;
    }

    public function addPhone(string $country_number, string $ddd, string $number) : self
    {
        $this->phones[] = new Phone($country_number, $ddd, $number);
        return $this;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function document() : Document
    {
        return $this->document;
    }

    public function email() : Email
    {
        return $this->email;
    }

    /** @return Phone[] */
    public function phones() : array
    {
        return $this->phones;
    }

    public function password(): string
    {
        return $this->password;
    }
}
