<?php
require_once '../includes/header.php';
require_once '../config/database.php';

$id = $_GET['id'] ?? 0;

if (!$id) {
    header('Location: index.php');
    exit;
}

$error = '';

// Check if category has products
try {
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM producto WHERE id_categoria = ?");
    $stmt->execute([$id]);
    $count = $stmt->fetch()['total'];
    
    if ($count > 0) {
        header('Location: index.php?error=has_products');
        exit;
    }
    
    // Delete category
    $stmt = $pdo->prepare("DELETE FROM categoria WHERE id_categoria = ?");
    $stmt->execute([$id]);
    
    header('Location: index.php?msg=deleted');
    exit;
    
} catch(PDOException $e) {
    header('Location: index.php?error=delete_failed');
    exit;
}
?>