<?php

require 'vendor/autoload.php';
require 'src/Infrastructure/Database/pdo_connection.php';

use SophieCalixto\App\Domain\Student\Document;
use SophieCalixto\App\Domain\Student\Student;
use SophieCalixto\App\Infrastructure\Student\EncryptStudentPasswordServiceWithPhp;
use SophieCalixto\App\Infrastructure\Student\PDOStudentRepository;

$pdo = pdo_connection::pdo();
$repository = new PDOStudentRepository($pdo);
$repository->updateByDocument(new Document(strval($_POST['document'])),
    Student::withNameDocumentEmailAndPassword(
        $_POST['name'],
        $_POST['document'],
        $_POST['email'],
        EncryptStudentPasswordServiceWithPhp::encrypt($_POST['password'])
    )->addPhone(
        strval($_POST['country_code']),
        strval($_POST['ddd']),
        strval($_POST['number'])
    )
);

header('Location: /students.php', true, 302);