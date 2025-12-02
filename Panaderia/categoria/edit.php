<?php
require_once '../includes/header.php';
require_once '../config/database.php';

$error = '';
$categoria = null;

$id = $_GET['id'] ?? 0;

if (!$id) {
    header('Location: index.php');
    exit;
}

// Get category data
try {
    $stmt = $pdo->prepare("SELECT * FROM categoria WHERE id_categoria = ?");
    $stmt->execute([$id]);
    $categoria = $stmt->fetch();
    
    if (!$categoria) {
        header('Location: index.php');
        exit;
    }
} catch(PDOException $e) {
    $error = 'Error al cargar la categoría: ' . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    
    if (empty($nombre)) {
        $error = 'El nombre de la categoría es obligatorio.';
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE categoria SET nombre = ?, descripcion = ? WHERE id_categoria = ?");
            $stmt->execute([$nombre, $descripcion, $id]);
            header('Location: index.php?msg=updated');
            exit;
        } catch(PDOException $e) {
            $error = 'Error al actualizar la categoría: ' . $e->getMessage();
        }
    }
}
?>

<h1>Editar Categoría</h1>

<?php if ($error): ?>
    <div class="alert alert-error"><?php echo $error; ?></div>
<?php endif; ?>

<?php if ($categoria): ?>
<form method="POST">
    <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required value="<?php echo htmlspecialchars($_POST['nombre'] ?? $categoria['nombre']); ?>">
    </div>
    
    <div class="form-group">
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" rows="4"><?php echo htmlspecialchars($_POST['descripcion'] ?? $categoria['descripcion']); ?></textarea>
    </div>
    
    <div class="form-group">
        <button type="submit" class="btn btn-success">Actualizar Categoría</button>
        <a href="index.php" class="btn">Cancelar</a>
    </div>
</form>
<?php endif; ?>

<?php require_once '../includes/footer.php'; ?>