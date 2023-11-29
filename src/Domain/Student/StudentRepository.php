<?php

namespace SophieCalixto\App\Domain\Student;

interface StudentRepository
{
    public function add(Student $student) : bool;

    public function getByDocument(Document $document) : Student|\Exception;

    public function getByEmail(Email $email) : Student|\Exception;

    /**
     * @return array|\Exception
     */
    public function getAll() : array|\Exception;

    public function removeByDocument(Document $document) : bool|\Exception;
}