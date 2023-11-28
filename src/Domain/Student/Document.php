<?php

namespace SophieCalixto\App\Domain\Student;


class Document
{
    private string $document;

    public function __construct(string $document)
    {
        $options = [
            "options" => [
                "regexp" => "/\d{3}\.\d{3}\.\d{3}\-\d{2}/"
            ]
        ];

        if(!filter_var($document, FILTER_VALIDATE_REGEXP, $options)) {
            throw new \InvalidArgumentException("Invalid Document!");
        }
        $this->document = $document;
    }

    public function __toString() : string
    {
        return $this->document;
    }
}