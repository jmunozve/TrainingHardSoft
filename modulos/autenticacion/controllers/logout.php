<?php
// Incluye la configuración, que tiene session_start() y BASE_URL
require_once '../../../includes/config.php';

// Destruye todas las variables de sesión
session_unset();
// Destruye la sesión
session_destroy();

// 🚩 CORRECCIÓN CRÍTICA DE RUTA 🚩
// Redirige al login usando la ruta absoluta definida en BASE_URL
// Esto asegura que la URL sea siempre correcta (ej: /modulos/autenticacion/views/login.php)
header("Location: " . BASE_URL . "modulos/autenticacion/views/login.php");
exit();
?>