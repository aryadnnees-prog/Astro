<?php
require_once 'config/conexion.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';
    
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ?");
    $stmt->execute([$usuario]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['usuario_nombre'] = $user['nombre'];
        $_SESSION['rol'] = $user['rol'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Librería Astro - Login</title>
<style>
body{font-family:Arial;background:linear-gradient(135deg,#667eea,#764ba2);height:100vh;display:flex;align-items:center;justify-content:center;margin:0}
.box{background:#fff;padding:40px;border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,.2);width:350px}
h1{text-align:center;color:#333}
input{width:100%;padding:12px;margin:8px 0;border:1px solid #ddd;border-radius:6px;box-sizing:border-box}
button{width:100%;padding:12px;background:#667eea;color:#fff;border:0;border-radius:6px;cursor:pointer;font-size:16px}
.error{color:red;text-align:center}
</style>
</head>
<body>
<div class="box">
  <h1>🌟 Librería Astro</h1>
  <?php if($error) echo "<p class='error'>$error</p>"; ?>
  <form method="POST">
    <input type="text" name="usuario" placeholder="Usuario" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <button type="submit">Ingresar</button>
  </form>
</div>
</body>
</html>