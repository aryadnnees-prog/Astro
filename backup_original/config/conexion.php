<?php
require_once 'conexion.php';
$host = "localhost";
$user = "root";
$pass = "";  // Por defecto XAMPP no tiene contraseña
$dbname = "libreria_astro";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>