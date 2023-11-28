<?php

namespace SophieCalixto\App;

class Student
{
    private string $name;
    private Document $document;
    private Email $email;
    private array $phones;

    public static function withNameDocumentAndEmail($name, $document, $email) : self
    {
        return new Student($name, new Document($document), new Email($email));
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
}