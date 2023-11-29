<?php
namespace SophieCalixto\App\TEsts\Infrastructure\Student;

use PDO;
use PHPUnit\Framework\TestCase;
use SophieCalixto\App\Infrastructure\Student\PDOStudentRepository;
use SophieCalixto\App\Domain\Student\Document;
use SophieCalixto\App\Domain\Student\Email;
use SophieCalixto\App\Domain\Student\Phone;
use SophieCalixto\App\Domain\Student\Student;

class PDOStudentRepositoryTest extends TestCase
{
    private PDO $pdo;
    private PDOStudentRepository $repository;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->exec('CREATE TABLE student (name TEXT, document TEXT, email TEXT)');
        $this->pdo->exec('CREATE TABLE phone (student_id INTEGER, country_code TEXT, ddd TEXT, number TEXT)');

        $this->repository = new PDOStudentRepository($this->pdo);
    }

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
            ->addPhone('1', '321', '6543210');
        $this->repository->add($sampleStudent);

        // Retrieve the student using getByDocument
        $retrievedStudent = $this->repository->getByDocument(new Document('123.321.321-31'));

        $this->assertInstanceOf(Student::class, $retrievedStudent);
        $this->assertEquals('Jane Doe', $retrievedStudent->name());
        // Additional assertions if needed
    }

    // Add more test methods for other repository functions

    protected function tearDown(): void
    {
        $this->pdo = null;
    }
}
