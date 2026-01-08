<?php
// Configuración de errores
ini_set('display_errors', 1);
error_reporting(E_ALL);

// ===================================
// 1. CONSTANTES DE APLICACIÓN Y RUTAS
// ===================================

define('BASE_URL', '/training/');
define('APP_NAME', 'Sistema de Escuela');
define('APP_VERSION', '1.0.0');

define('PATH_ROOT', dirname(__DIR__) . '/');
define('PATH_LOGS', PATH_ROOT . 'logs/'); 


// ===================================
// 2. CONFIGURACIÓN DE LA BASE DE DATOS
// ===================================

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'db_training'); 

// 🚩 CAMBIO CRÍTICO: CONEXIÓN A PDO
try {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    // Crea la conexión PDO
    $conn = new PDO($dsn, DB_USER, DB_PASS);
    
    // Configura PDO para lanzar excepciones en caso de error (seguridad y depuración)
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Configura el modo de obtención por defecto para arrays asociativos
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
    
} catch (PDOException $e) {
    // Si la conexión falla, muestra un error y detiene el script
    die("Error de conexión a la base de datos (PDO): " . $e->getMessage());
}

// ===================================
// 3. SESIÓN Y PERMISOS
// ===================================

session_start();

if (!is_dir(PATH_LOGS)) {
    mkdir(PATH_LOGS, 0777, true);
}
?>