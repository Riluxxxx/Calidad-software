<?php
require_once '../includes/header.php';
require_once '../config/database.php';

$message = '';
if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'created') {
        $message = '<div class="alert alert-success">Categoría creada exitosamente.</div>';
    } elseif ($_GET['msg'] === 'updated') {
        $message = '<div class="alert alert-success">Categoría actualizada exitosamente.</div>';
    } elseif ($_GET['msg'] === 'deleted') {
        $message = '<div class="alert alert-success">Categoría eliminada exitosamente.</div>';
    }
}

try {
    $stmt = $pdo->query("SELECT * FROM categoria ORDER BY nombre");
    $categorias = $stmt->fetchAll();
} catch(PDOException $e) {
    $message = '<div class="alert alert-error">Error al cargar las categorías: ' . $e->getMessage() . '</div>';
    $categorias = [];
}
?>

<h1>Gestión de Categorías</h1>

<?php echo $message; ?>

<div style="margin-bottom: 20px;">
    <a href="create.php" class="btn btn-success">Nueva Categoría</a>
    <a href="/Panaderia/dashboard.php" class="btn">Volver al Dashboard</a>
</div>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($categorias)): ?>
            <tr>
                <td colspan="4" style="text-align: center;">No hay categorías registradas</td>
            </tr>
        <?php else: ?>
            <?php foreach ($categorias as $categoria): ?>
                <tr>
                    <td><?php echo htmlspecialchars($categoria['id_categoria']); ?></td>
                    <td><?php echo htmlspecialchars($categoria['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($categoria['descripcion']); ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $categoria['id_categoria']; ?>" class="btn" style="font-size: 12px; padding: 5px 10px;">Editar</a>
                        <a href="delete.php?id=<?php echo $categoria['id_categoria']; ?>" class="btn btn-danger" style="font-size: 12px; padding: 5px 10px;" onclick="return confirm('¿Está seguro de eliminar esta categoría?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?php require_once '../includes/footer.php'; ?>