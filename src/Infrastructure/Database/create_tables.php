<?php

$envContents = file_get_contents(__DIR__ . '/../../../.env');
$envArray = parse_ini_string($envContents, false, INI_SCANNER_RAW);

$host = $envArray["DB_HOST"];
$port =  $envArray["DB_PORT"];
$dbname =  $envArray["DB_NAME"];
$user =  $envArray["DB_USER"];
$password = $envArray["DB_PASSWORD"];


try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Table student
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS student (
            id SERIAL PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            document VARCHAR(20) NOT NULL UNIQUE,
            email VARCHAR(255) NOT NULL
        )
    ");

    // Table phone
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS phone (
            id SERIAL PRIMARY KEY,
            student_id INT REFERENCES student(id) ON DELETE CASCADE,
            country_code VARCHAR(5) NOT NULL,
            ddd VARCHAR(5) NOT NULL,
            number VARCHAR(20) NOT NULL
        )
    ");

    echo "Sucess.\n";
} catch (PDOException $e) {
    var_dump($host, $port, $dbname, $user, $password);
    die("ERROR: " . $e->getMessage());
}