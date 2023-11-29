<?php

class pdo_connection
{
    public static function pdo(): PDO
    {
        $envContents = file_get_contents(__DIR__ . '/../../../.env');
        $envArray = parse_ini_string($envContents, false, INI_SCANNER_RAW);

        $host = $envArray["DB_HOST"];
        $port =  $envArray["DB_PORT"];
        $dbname =  $envArray["DB_NAME"];
        $user =  $envArray["DB_USER"];
        $password = $envArray["DB_PASSWORD"];

        return  $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password");
    }
}