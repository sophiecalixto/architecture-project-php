<?php

namespace SophieCalixto\App\Infrastructure\Student;

use Exception;
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
     * @throws Exception
     */
    public function add(Student $student): bool
    {
        try {
            $this->PDO->beginTransaction();

            $sql = $this->PDO->prepare("INSERT INTO student (name, document, email) VALUES (:name, :document, :email)");
            $sql->execute([
                "name" => $student->name(),
                "document" => $student->document(),
                "email" => $student->email()
            ]);

            $studentId = $this->PDO->lastInsertId();

            $sqlPhone = $this->PDO->prepare("INSERT INTO phone (student_id, country_code, ddd, number) VALUES (:student_id, :country_code, :ddd, :number)");

            foreach ($student->phones() as $phone) {
                $sqlPhone->execute([
                    "student_id" => $studentId,
                    "country_code" => $phone->countryCode(),
                    "ddd" => $phone->ddd(),
                    "number" => $phone->number()
                ]);
            }

            $this->PDO->commit();
            return true;
        } catch (Exception $e) {
            $this->PDO->rollBack();
            throw new Exception("Error when adding student: " . $e->getMessage());
        }
    }

    public function getByDocument(Document $document): Student|Exception
    {
        try {
            $sql = $this->PDO->prepare("
                SELECT s.id, s.name, s.document, s.email, p.country_code, p.ddd, p.number
                FROM student s
                LEFT JOIN phone p ON s.id = p.student_id
                WHERE s.document = :document
            ");
            $sql->bindParam(":document", $document);
            $sql->execute();
            $studentData = $sql->fetchAll(PDO::FETCH_ASSOC);

            if (empty($studentData)) {
                return null;
            }

            $phones = [];
            foreach ($studentData as $row) {
                $phones[] = new Phone($row["country_code"], $row["ddd"], $row["number"]);
            }

            return Student::withNameDocumentEmailAndPhones($studentData[0]["name"], $studentData[0]["document"], $studentData[0]["email"], $phones);
        } catch (\PDOException $e) {
            throw new \PDOException("Error when getting student by document: " . $e->getMessage());
        }
    }

    public function getByEmail(Email $email): Student|Exception
    {
        try {
            $sql = $this->PDO->prepare("
                SELECT s.id, s.name, s.document, s.email, p.country_code, p.ddd, p.number
                FROM student s
                LEFT JOIN phone p ON s.id = p.student_id
                WHERE s.email = :email
            ");
            $sql->bindParam(":email", $email);
            $sql->execute();
            $studentData = $sql->fetchAll(PDO::FETCH_ASSOC);

            if (empty($studentData)) {
                return null;
            }

            $phones = [];
            foreach ($studentData as $row) {
                $phones[] = new Phone($row["country_code"], $row["ddd"], $row["number"]);
            }

            return Student::withNameDocumentEmailAndPhones($studentData[0]["name"], $studentData[0]["document"], $studentData[0]["email"], $phones);
        } catch (\PDOException $e) {
            throw new \PDOException("Error when getting student by email: " . $e->getMessage());
        }
    }

    public function getAll(): array
    {
        try {
            $sql = $this->PDO->query("
                SELECT s.id, s.name, s.document, s.email, p.country_code, p.ddd, p.number
                FROM student s
                LEFT JOIN phone p ON s.id = p.student_id
            ");
            $students = [];
            $currentStudentId = null;
            $phones = [];

            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                if ($currentStudentId !== $row["document"]) {
                    if ($currentStudentId !== null) {
                        $students[] = Student::withNameDocumentEmailAndPhones($row["name"], $row["document"], $row["email"], $phones);
                    }

                    $currentStudentId = $row["document"];
                    $phones = [];
                }

                $phones[] = new Phone($row["country_code"], $row["ddd"], $row["number"]);
            }

            if ($currentStudentId !== null) {
                $students[] = Student::withNameDocumentEmailAndPhones($row["name"], $row["document"], $row["email"], $phones);
            }

            return $students;
        } catch (\PDOException $e) {
            throw new \PDOException("Error when getting all students: " . $e->getMessage());
        }
    }

    public function removeByDocument(Document $document): bool
    {
        try {
            $this->PDO->beginTransaction();

            $sql = $this->PDO->prepare("DELETE FROM student WHERE document = :document");
            $sql->bindParam(":document", $document);
            $sql->execute();

            $this->PDO->commit();
            return true;
        } catch (\PDOException $e) {
            $this->PDO->rollBack();
            throw new \PDOException("Error when removing student by document: " . $e->getMessage());
        }
    }

    public function getAllPhones(Document $document): array
    {
        try {
            $sql = $this->PDO->prepare("SELECT country_code, ddd, number FROM phone WHERE document = :document");
            $sql->bindParam(":document", $document);
            $sql->execute();
            $phoneList = [];

            while ($phoneData = $sql->fetch(PDO::FETCH_ASSOC)) {
                $phoneList[] = new Phone($phoneData["country_code"], $phoneData["ddd"], $phoneData["number"]);
            }

            return $phoneList;
        } catch (\PDOException $e) {
            throw new \PDOException("Error when getting all phones by document: " . $e->getMessage());
        }
    }
}
