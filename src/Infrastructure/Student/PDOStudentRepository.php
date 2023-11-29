<?php

namespace SophieCalixto\App\Infrastructure\Student;

use PDO;
use SophieCalixto\App\Domain\Student\Document;
use SophieCalixto\App\Domain\Student\Email;
use SophieCalixto\App\Domain\Student\Phone;
use SophieCalixto\App\Domain\Student\Student;
use SophieCalixto\App\Domain\Student\StudentRepository;

class PDOStudentRepository implements StudentRepository
{
    private PDO $PDO;

    public function __construct(PDO $PDO)
    {
        $this->PDO = $PDO;
    }

    /**
     * @throws \Exception
     */
    public function add(Student $student): bool
    {
        $sql = $this->PDO->prepare("INSERT INTO student VALUES (:name, :document, :email)");
        if(!$sql->execute(
            [
                "name" => $student->name(),
                "document" => $student->document(),
                "email" => $student->email()
            ]
        )) {
            throw new \Exception("Error when adding student");
        }

        /** @var Phone $phone */
        foreach($student->phones() as $phone) {
            $sql = $this->PDO->prepare("INSERT INTO phone VALUES (:country_code, :ddd, :number)");
            if(!$sql->execute([
                "country_code" => $phone->countryCode(),
                "ddd" => $phone->ddd(),
                "number" => $phone->number()
            ]))
            {
                throw new \Exception("Error when adding phone");
            }
        }

        return true;
    }

    public function getByDocument(Document $document): Student|\Exception
    {
        try {
            $sql = $this->PDO->query("SELECT * FROM student WHERE document = $document");
            $studentData = $sql->fetch(PDO::FETCH_ASSOC);
        } catch(\PDOException $e) {
            throw new \PDOException($e);
        }

        return Student::withNameDocumentAndEmail($studentData["name"], $studentData["document"], $studentData["email"]);
    }

    public function getByEmail(Email $email): Student|\Exception
    {
        try {
            $sql = $this->PDO->query("SELECT * FROM student WHERE email = $email");
            $studentData = $sql->fetch(PDO::FETCH_ASSOC);
        } catch(\PDOException $e) {
            throw new \PDOException($e);
        }

        return Student::withNameDocumentAndEmail($studentData["name"], $studentData["document"], $studentData["email"]);
    }

    public function getAll(): array|\Exception
    {
        try {
            $sql = $this->PDO->query("SELECT * FROM student");
            $students = [];
            $studentData = $sql->fetch(PDO::FETCH_ASSOC);
            foreach ($studentData as $student) {
                $student[] = Student::withNameDocumentAndEmail($student["name"], $student["document"], $student["email"]);
            }
        } catch(\PDOException $e) {
            throw new \PDOException($e);
        }

        return $students;
    }

    public function removeByDocument(Document $document): bool|\Exception
    {
        try {
            $sql = $this->PDO->query("DELETE FROM student WHERE document = $document");
            $studentData = $sql->fetch(PDO::FETCH_ASSOC);
        } catch(\PDOException $e) {
            throw new \PDOException($e);
        }

        return true;
    }

    public function getAllPhones(Document $document): array|\Exception
    {
        try {
            $sql = $this->PDO->query("SELECT * FROM phone WHERE document = $document");
            $phoneList = [];
            $phoneData = $sql->fetch(PDO::FETCH_ASSOC);
            foreach ($phoneData as $phone) {
                $phoneList[] = Student::withNameDocumentAndEmail($phone["country_code"], $phone["ddd"], $phone["number"]);
            }
        } catch(\PDOException $e) {
            throw new \PDOException($e);
        }

        return $phoneList;
    }
}