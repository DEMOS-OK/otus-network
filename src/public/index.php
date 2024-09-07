<?php

$host = 'ha-network-postgres';
$dbname = 'network';
$user = 'postgres';
$password = 'password';

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);

    echo "Hello, world!";
} catch (PDOException $e) {
    echo 'Connection error: ' . $e->getMessage();
}