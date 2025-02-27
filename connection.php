<?php
$config = require 'config.php';
$config = $config['connection'];

$host = $config['host'];
$db = $config['db'];
$user = $config['user'];
$pass = $config['pass'];

$dsn = "mysql:host=$host;dbname=$db";

try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    die('Подключение не удалось: ' . $e->getMessage());
}
