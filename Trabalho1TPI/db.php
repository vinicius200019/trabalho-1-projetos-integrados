<?php
// db.php - conexão simples com MySQL usando PDO
$host = 'localhost';
$db   = 'tpi2_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];
try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
     echo 'Conexão falhou: ' . $e->getMessage();
     exit;
}
?>