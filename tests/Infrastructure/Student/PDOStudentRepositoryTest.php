<?php

namespace SophieCalixto\App\Tests\Infrastructure\Student;

use PDO;
use PHPUnit\Framework\TestCase;
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
        $this->pdo->exec('CREATE TABLE student (id INTEGER PRIMARY KEY, document TEXT, name TEXT, email TEXT)');

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
        $student = Student::withNameDocumentAndEmail('John Doe', '123.321.321-31', 'john.doe@example.com')
            ->addPhone('+55', '11', '999999999');

        $result = $this->repository->add($student);

        $this->assertTrue($result);
        // Additional assertions if needed
    }

    public function testGetByDocument(): void
    {
        // Add a sample student to the database
        $sampleStudent = Student::withNameDocumentAndEmail('Jane Doe', '123.321.321-31', 'jane.doe@example.com')
            ->addPhone('+55', '11', '999999999');
        $this->repository->add($sampleStudent);

        // Retrieve the student using getByDocument
        $retrievedStudent = $this->repository->getByDocument(new Document('123.321.321-31'));

        $this->assertInstanceOf(Student::class, $retrievedStudent);
        $this->assertEquals('123.321.321-31', $retrievedStudent->document());
        // Additional assertions if needed
    }

    // Add more test methods for other repository functions

    protected function tearDown(): void
    {
        $this->pdo = null;
    }
}
