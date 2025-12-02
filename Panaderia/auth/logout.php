<?php
session_start();
session_destroy();
header('Location: /Panaderia/auth/login.php');
exit;
?>