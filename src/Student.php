<?php

namespace SophieCalixto\App;

class Student
{
    private string $name;
    private Document $document;
    private Email $email;
    private array $phones;
    public function __construct(string $name, Document $document, Email $email, array $phones)
    {

        $this->name = $name;
        $this->document = $document;
        $this->email = $email;
    }

    public function addPhone(string $country_number, string $ddd, string $number) : void
    {
        $this->phones[] = new Phone($country_number, $ddd, $number);
    }
}