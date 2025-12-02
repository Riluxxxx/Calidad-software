<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    if (basename($_SERVER['PHP_SELF']) !== 'login.php') {
        header('Location: /Panaderia/auth/login.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bread and Friend - Sistema de Inventario</title>
    <link rel="stylesheet" href="/Panaderia/css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Bread and Friend - Sistema de Inventario</h1>
        </div>
    </header>
    
    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
    <nav class="nav">
        <div class="container">
            <ul>
                <li><a href="/Panaderia/dashboard.php">Dashboard</a></li>
                <li><a href="/Panaderia/categoria/index.php">Categorías</a></li>
                <li><a href="/Panaderia/producto/index.php">Productos</a></li>
                <li><a href="/Panaderia/auth/logout.php">Cerrar Sesión</a></li>
            </ul>
        </div>
    </nav>
    <?php endif; ?>
    
    <div class="container">