<?php
require_once 'conexion.php';
echo " Conexión exitosa a la BD: " . $dbname;

$stmt = $pdo->query("SHOW TABLES");
echo "<br>Tablas encontradas:<br>";
while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
    echo "- " . $row[0] . "<br>";
}
?>