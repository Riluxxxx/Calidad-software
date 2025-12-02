<?php
require_once 'includes/header.php';
require_once 'config/database.php';

// Get statistics
try {
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM categoria");
    $total_categorias = $stmt->fetch()['total'];
    
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM producto");
    $total_productos = $stmt->fetch()['total'];
    
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM producto WHERE activo = 1");
    $productos_activos = $stmt->fetch()['total'];
    
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM producto WHERE stock_actual <= stock_minimo AND activo = 1");
    $productos_bajo_stock = $stmt->fetch()['total'];
} catch(PDOException $e) {
    $total_categorias = 0;
    $total_productos = 0;
    $productos_activos = 0;
    $productos_bajo_stock = 0;
}
?>

<h1>Dashboard</h1>

<div class="dashboard-cards">
    <div class="card">
        <h3>Total Categorías</h3>
        <p><?php echo $total_categorias; ?></p>
    </div>
    
    <div class="card">
        <h3>Total Productos</h3>
        <p><?php echo $total_productos; ?></p>
    </div>
    
    <div class="card">
        <h3>Productos Activos</h3>
        <p><?php echo $productos_activos; ?></p>
    </div>
    
    <div class="card">
        <h3>Productos Bajo Stock</h3>
        <p style="color: #dc3545;"><?php echo $productos_bajo_stock; ?></p>
    </div>
</div>

<div style="margin-top: 40px;">
    <h2>Acceso Rápido</h2>
    <div style="margin-top: 20px;">
        <a href="/Panaderia/categoria/index.php" class="btn">Gestionar Categorías</a>
        <a href="/Panaderia/producto/index.php" class="btn" style="margin-left: 10px;">Gestionar Productos</a>
        <a href="/Panaderia/categoria/create.php" class="btn btn-success" style="margin-left: 10px;">Nueva Categoría</a>
        <a href="/Panaderia/producto/create.php" class="btn btn-success" style="margin-left: 10px;">Nuevo Producto</a>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>