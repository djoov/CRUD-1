<?php
$host     = 'localhost';
$port     = '5432'; // customize with your port
$dbname   = 'postgres'; // customize with database name
$user     = 'postgres'; //Your postgres username
$password = 'your_postgres_password'; 

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Koneksi ke database gagal: " . $e->getMessage());
}
?>
