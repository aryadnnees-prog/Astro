<?php
require_once 'config/conexion.php';
if (!isset($_SESSION['usuario_id'])) { header("Location: index.php"); exit; }

// Estadísticas
$ventasHoy = $pdo->query("SELECT COALESCE(SUM(total),0) as t FROM ventas WHERE DATE(fecha)=CURDATE()")->fetch()['t'];
$totalProductos = $pdo->query("SELECT COUNT(*) as c FROM productos")->fetch()['c'];
$stockBajo = $pdo->query("SELECT COUNT(DISTINCT producto_id) as c FROM stock WHERE cantidad < 5")->fetch()['c'];
$pedidosPend = $pdo->query("SELECT COUNT(*) as c FROM pedidos_online WHERE estado='pendiente'")->fetch()['c'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Librería Astro - Panel</title>
<style>
*{box-sizing:border-box;margin:0;padding:0;font-family:Arial}
body{background:#f4f6f9}
nav{background:#2c3e50;color:#fff;padding:15px 30px;display:flex;justify-content:space-between;align-items:center}
nav a{color:#fff;text-decoration:none;margin:0 15px}
nav a:hover{color:#3498db}
.container{padding:30px}
.cards{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px;margin-bottom:30px}
.card{background:#fff;padding:25px;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,.08)}
.card h3{color:#666;font-size:14px;text-transform:uppercase}
.card .valor{font-size:32px;font-weight:bold;color:#2c3e50;margin-top:10px}
</style>
</head>
<body>
<nav>
  <div><strong>🌟 Librería Astro</strong></div>
  <div>
    <a href="dashboard.php">Inicio</a>
    <a href="productos.php">Productos</a>
    <a href="ventas.php">Ventas</a>
    <a href="stock.php">Stock</a>
    <a href="pedidos.php">Pedidos</a>
    <a href="tienda.php">Tienda</a>
    <a href="logout.php">Salir (<?= $_SESSION['usuario_nombre'] ?>)</a>
  </div>
</nav>
<div class="container">
  <h2>Bienvenido, <?= $_SESSION['usuario_nombre'] ?></h2>
  <div class="cards">
    <div class="card"><h3>Ventas del día</h3><div class="valor">$ <?= number_format($ventasHoy,2) ?></div></div>
    <div class="card"><h3>Total productos</h3><div class="valor"><?= $totalProductos ?></div></div>
    <div class="card"><h3>Stock bajo</h3><div class="valor" style="color:#e74c3c"><?= $stockBajo ?></div></div>
    <div class="card"><h3>Pedidos pendientes</h3><div class="valor" style="color:#f39c12"><?= $pedidosPend ?></div></div>
  </div>
</div>
</body>
</html>