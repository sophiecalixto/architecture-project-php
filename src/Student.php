<?php

namespace SophieCalixto\App;

class Student
{
    private string $name;
    private Document $document;
    private Email $email;
    public function __construct(string $name, Document $document, Email $email)
    {

        $this->name = $name;
        $this->document = $document;
        $this->email = $email;
    }
}