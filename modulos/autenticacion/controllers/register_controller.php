<?php
require_once '../../../includes/config.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $usuario = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';
    $rol = $_POST['rol'] ?? 'estudiante'; 

    if (empty($nombre) || empty($usuario) || empty($password)) {
        $_SESSION['error_register'] = "Todos los campos son obligatorios.";
        header("Location: ../views/register.php");
        exit();
    }

    // 1. Verificar si el usuario ya existe (usando PDO)
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE usuario = :usuario");
    $stmt->bindParam(':usuario', $usuario);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) { // PDO usa rowCount() para el número de filas afectadas/encontradas
        $_SESSION['error_register'] = "El nombre de usuario ya está en uso.";
        header("Location: ../views/register.php");
        exit();
    }

    // 2. Hashear la contraseña
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    
    // 3. Insertar el nuevo usuario (usando PDO)
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellido, usuario, password_hash, rol) VALUES (:nombre, '', :usuario, :password_hash, :rol)");
    
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->bindParam(':password_hash', $password_hash);
    $stmt->bindParam(':rol', $rol);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "¡Registro exitoso! Ya puedes iniciar sesión.";
        header("Location: ../views/login.php");
        exit();
    } else {
        // En PDO, capturamos el error de esta manera, aunque try/catch en la conexión es mejor
        $_SESSION['error_register'] = "Error al crear la cuenta. Inténtalo de nuevo.";
        header("Location: ../views/register.php");
        exit();
    }
}

header("Location: ../views/register.php");
exit();
?>