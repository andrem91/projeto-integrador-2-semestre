<?php

$host = "www.thyagoquintas.com.br";
$db = "Alpha";
$charset = "utf8mb4";
$user = "alpha";
$pass = "alpha";

$dsn = "mysql:host=$host;dbname=$db;$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
