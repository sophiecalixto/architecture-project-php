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

    /**
     * @param Student $student
     * @param string $oldPassword
     * @param string $newPassword
     * @return bool|\Exception
     */
    public function changePassword(Student $student, string $oldPassword, string $newPassword) : bool|\Exception;

    public function getAllInfoByDocument(Document $document) : Student|\Exception;
}