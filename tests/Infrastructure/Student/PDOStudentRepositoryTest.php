<?php

namespace SophieCalixto\App\Tests\Infrastructure\Student;

use PDO;
use PHPUnit\Framework\TestCase;
use SophieCalixto\App\Domain\Student\Phone;
use SophieCalixto\App\Infrastructure\Student\EncryptStudentPasswordServiceWithPhp;
use SophieCalixto\App\Infrastructure\Student\PDOStudentRepository;
use SophieCalixto\App\Domain\Student\Document;
use SophieCalixto\App\Domain\Student\Student;

class PDOStudentRepositoryTest extends TestCase
{
    private PDO $pdo;
    private PDOStudentRepository $repository;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');

        // Create the student table
        $this->pdo->exec('CREATE TABLE student (id INTEGER PRIMARY KEY, document TEXT, name TEXT, email TEXT, password TEXT)');

        // Create the phone table with a foreign key constraint
        $this->pdo->exec('CREATE TABLE phone (
            id INTEGER PRIMARY KEY,
            student_id TEXT,
            country_code TEXT,
            ddd TEXT,
            number TEXT,
            FOREIGN KEY (student_id) REFERENCES student(id)
        )');

        $this->repository = new PDOStudentRepository($this->pdo);
    }

    /**
     * @throws \Exception
     */
    public function testAddStudent(): void
    {
        $student = Student::withNameDocumentEmailAndPassword('John Doe', '123.321.321-31', 'john.doe@example.com', EncryptStudentPasswordServiceWithPhp::encrypt('123456'))
            ->addPhone('+55', '11', '999999999');

        $result = $this->repository->add($student);

        $this->assertTrue($result);
        // Additional assertions if needed
    }

    public function testGetByDocument(): void
    {
        // Add a sample student to the database
        $student = Student::withNameDocumentEmailAndPassword('John Doe', '123.321.321-31', 'john.doe@example.com', EncryptStudentPasswordServiceWithPhp::encrypt('123456'))
            ->addPhone('+55', '11', '999999999');
        $this->repository->add($student);

        // Retrieve the student using getByDocument
        $retrievedStudent = $this->repository->getByDocument(new Document('123.321.321-31'));

        $this->assertInstanceOf(Student::class, $retrievedStudent);
        $this->assertEquals('123.321.321-31', $retrievedStudent->document());
        // Additional assertions if needed
    }

    // Add more test methods for other repository functions

    public function testChangePassword()
    {
        // Add a sample student to the database
        $student = Student::withNameDocumentEmailAndPassword('John Doe', '453.543.342-42', 'john.doe@example.com', EncryptStudentPasswordServiceWithPhp::encrypt('123456'))
            ->addPhone('+55', '11', '999999999');
        $this->repository->add($student);

        // Retrieve the student using getByDocument
        $retrievedStudent = $this->repository->getAllInfoByDocument(new Document('453.543.342-42'));

        // Change the password
        $this->repository->changePassword($retrievedStudent, '123456', '654321');

        // Retrieve the student again
        $retrievedStudent = $this->repository->getAllInfoByDocument(new Document('453.543.342-42'));

        // Assert that the password has changed
        $this->assertTrue(password_verify('654321', $retrievedStudent->password()));
    }

    protected function tearDown(): void
    {
        $this->pdo = null;
    }
}
