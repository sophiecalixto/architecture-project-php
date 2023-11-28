<?php

namespace SophieCalixto\App;

use http\Exception\InvalidArgumentException;

class Document
{
    private string $document;

    public function __construct(string $document)
    {
        $regex = "/^[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2}$/";
        if(!preg_match($document, $regex)) {
            throw new InvalidArgumentException("Invalid Document!");
        }
        $this->document = $document;
    }

    public function toString() : string
    {
        return $this->document;
    }
}