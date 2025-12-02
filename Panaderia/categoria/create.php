<?php
require_once '../includes/header.php';
require_once '../config/database.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    
    if (empty($nombre)) {
        $error = 'El nombre de la categoría es obligatorio.';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO categoria (nombre, descripcion) VALUES (?, ?)");
            $stmt->execute([$nombre, $descripcion]);
            header('Location: index.php?msg=created');
            exit;
        } catch(PDOException $e) {
            $error = 'Error al crear la categoría: ' . $e->getMessage();
        }
    }
}
?>

<h1>Nueva Categoría</h1>

<?php if ($error): ?>
    <div class="alert alert-error"><?php echo $error; ?></div>
<?php endif; ?>

<form method="POST">
    <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>">
    </div>
    
    <div class="form-group">
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" rows="4"><?php echo htmlspecialchars($_POST['descripcion'] ?? ''); ?></textarea>
    </div>
    
    <div class="form-group">
        <button type="submit" class="btn btn-success">Crear Categoría</button>
        <a href="index.php" class="btn">Cancelar</a>
    </div>
</form>

<?php require_once '../includes/footer.php'; ?>