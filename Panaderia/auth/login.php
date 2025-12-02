<?php
session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: /Panaderia/dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    

    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        header('Location: ../dashboard.php');
        exit;
    } else {
        $error = 'Usuario o contraseña incorrectos';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bread and Friend</title>
    <link rel="stylesheet" href="/Panaderia/css/style.css">
</head>
<body>
    <div class="login-form">
        <h2 style="text-align: center; margin-bottom: 30px;">Iniciar Sesión</h2>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn" style="width: 100%;">Ingresar</button>
            </div>
        </form>
        
        <p style="text-align: center; margin-top: 20px; color: #666;">
            Usuario: admin<br>
            Contraseña: admin123
        </p>
    </div>
</body>
</html>