<?php
require_once '../includes/header.php';
require_once '../config/database.php';

$message = '';
if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'created') {
        $message = '<div class="alert alert-success">Producto creado exitosamente.</div>';
    } elseif ($_GET['msg'] === 'updated') {
        $message = '<div class="alert alert-success">Producto actualizado exitosamente.</div>';
    } elseif ($_GET['msg'] === 'deleted') {
        $message = '<div class="alert alert-success">Producto eliminado exitosamente.</div>';
    }
}

try {
    $stmt = $pdo->query("
        SELECT p.*, c.nombre as categoria_nombre 
        FROM producto p 
        LEFT JOIN categoria c ON p.id_categoria = c.id_categoria 
        ORDER BY p.nombre
    ");
    $productos = $stmt->fetchAll();
} catch(PDOException $e) {
    $message = '<div class="alert alert-error">Error al cargar los productos: ' . $e->getMessage() . '</div>';
    $productos = [];
}
?>

<h1>Gestión de Productos</h1>

<?php echo $message; ?>

<div style="margin-bottom: 20px;">
    <a href="create.php" class="btn btn-success">Nuevo Producto</a>
    <a href="/Panaderia/dashboard.php" class="btn">Volver al Dashboard</a>
</div>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Unidad</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($productos)): ?>
            <tr>
                <td colspan="8" style="text-align: center;">No hay productos registrados</td>
            </tr>
        <?php else: ?>
            <?php foreach ($productos as $producto): ?>
                <tr>
                    <td><?php echo htmlspecialchars($producto['id_producto']); ?></td>
                    <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($producto['categoria_nombre'] ?? 'Sin categoría'); ?></td>
                    <td>$<?php echo number_format($producto['precio'], 2); ?></td>
                    <td style="color: <?php echo $producto['stock_actual'] <= $producto['stock_minimo'] ? '#dc3545' : '#28a745'; ?>">
                        <?php echo number_format($producto['stock_actual'], 2); ?>
                    </td>
                    <td><?php echo htmlspecialchars($producto['unidad_medida']); ?></td>
                    <td>
                        <span style="color: <?php echo $producto['activo'] ? '#28a745' : '#dc3545'; ?>">
                            <?php echo $producto['activo'] ? 'Activo' : 'Inactivo'; ?>
                        </span>
                    </td>
                    <td>
                        <a href="edit.php?id=<?php echo $producto['id_producto']; ?>" class="btn" style="font-size: 12px; padding: 5px 10px;">Editar</a>
                        <a href="delete.php?id=<?php echo $producto['id_producto']; ?>" class="btn btn-danger" style="font-size: 12px; padding: 5px 10px;" onclick="return confirm('¿Está seguro de eliminar este producto?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?php require_once '../includes/footer.php'; ?>