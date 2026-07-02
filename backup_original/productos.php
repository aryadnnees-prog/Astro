<?php
require_once 'config/conexion.php';
if (!isset($_SESSION['usuario_id'])) { header("Location: index.php"); exit; }
$categorias = $pdo->query("SELECT * FROM categorias")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Productos - Librería Astro</title>
<style>
body{font-family:Arial;background:#f4f6f9;margin:0}
header{background:#2c3e50;color:#fff;padding:15px 30px}
.container{padding:30px}
table{width:100%;background:#fff;border-collapse:collapse;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,.08)}
th,td{padding:12px;text-align:left;border-bottom:1px solid #eee}
th{background:#34495e;color:#fff}
.btn{padding:8px 16px;border:0;border-radius:5px;cursor:pointer;color:#fff}
.btn-primary{background:#3498db}
.btn-danger{background:#e74c3c}
.modal{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);align-items:center;justify-content:center}
.modal-content{background:#fff;padding:30px;border-radius:10px;width:400px}
.modal input,.modal select{width:100%;padding:10px;margin:8px 0;border:1px solid #ddd;border-radius:5px}
</style>
</head>
<body>
<header><h2>📚 Productos</h2><a href="dashboard.php" style="color:#fff">← Volver</a></header>
<div class="container">
  <button class="btn btn-primary" onclick="abrirModal()">+ Nuevo Producto</button>
  <br><br>
  <table>
    <thead><tr><th>ID</th><th>Nombre</th><th>Categoría</th><th>Precio</th><th>Acciones</th></tr></thead>
    <tbody id="tabla"></tbody>
  </table>
</div>

<div class="modal" id="modal">
  <div class="modal-content">
    <h3 id="tituloModal">Nuevo Producto</h3>
    <input type="hidden" id="prod_id">
    <input type="text" id="prod_nombre" placeholder="Nombre">
    <select id="prod_categoria">
      <?php foreach($categorias as $c): ?>
        <option value="<?= $c['id'] ?>"><?= $c['nombre'] ?></option>
      <?php endforeach; ?>
    </select>
    <input type="number" id="prod_precio" placeholder="Precio" step="0.01">
    <input type="text" id="prod_imagen" placeholder="URL imagen (opcional)">
    <button class="btn btn-primary" onclick="guardar()">Guardar</button>
    <button class="btn btn-danger" onclick="cerrarModal()">Cancelar</button>
  </div>
</div>

<script>
function cargar(){
  fetch('api/productos.php').then(r=>r.json()).then(data=>{
    document.getElementById('tabla').innerHTML = data.map(p=>`
      <tr>
        <td>${p.id}</td><td>${p.nombre}</td><td>${p.categoria||'-'}</td>
        <td>$ ${parseFloat(p.precio).toFixed(2)}</td>
        <td>
          <button class="btn btn-primary" onclick='editar(${JSON.stringify(p)})'>Editar</button>
          <button class="btn btn-danger" onclick="eliminar(${p.id})">Eliminar</button>
        </td>
      </tr>`).join('');
  });
}
function abrirModal(){document.getElementById('modal').style.display='flex'}
function cerrarModal(){document.getElementById('modal').style.display='none'}
function editar(p){
  document.getElementById('prod_id').value=p.id;
  document.getElementById('prod_nombre').value=p.nombre;
  document.getElementById('prod_categoria').value=p.categoria_id;
  document.getElementById('prod_precio').value=p.precio;
  document.getElementById('prod_imagen').value=p.imagen||'';
  document.getElementById('tituloModal').innerText='Editar Producto';
  abrirModal();
}
function guardar(){
  const data={
    id:document.getElementById('prod_id').value,
    nombre:document.getElementById('prod_nombre').value,
    categoria_id:document.getElementById('prod_categoria').value,
    precio:document.getElementById('prod_precio').value,
    imagen:document.getElementById('prod_imagen').value
  };
  const method = data.id ? 'PUT' : 'POST';
  fetch('api/productos.php', {method, body:JSON.stringify(data)}).then(()=>{cargar();cerrarModal()});
}
function eliminar(id){
  if(confirm('¿Eliminar?')) fetch('api/productos.php?action=delete&id='+id,{method:'DELETE'}).then(()=>cargar());
}
cargar();
</script>
</body>
</html>