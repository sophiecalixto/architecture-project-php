<?php

require 'vendor/autoload.php';
require 'src/Infrastructure/Database/pdo_connection.php';

use SophieCalixto\App\Domain\Student\Document;
use SophieCalixto\App\Infrastructure\Student\PDOStudentRepository;

$pdo = pdo_connection::pdo();
$repository = new PDOStudentRepository($pdo);
$repository->removeByDocument(new Document($_POST['document']));

header('Location: /students.php', true, 302);