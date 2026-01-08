<?php
require_once '../../../includes/config.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $usuario = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';
    $rol = $_POST['rol'] ?? 'estudiante'; // Por defecto

    // Validación simple
    if (empty($nombre) || empty($usuario) || empty($password)) {
        $_SESSION['error_register'] = "Todos los campos son obligatorios.";
        header("Location: ../views/register.php");
        exit();
    }

    // 1. Verificar si el usuario ya existe
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        $_SESSION['error_register'] = "El nombre de usuario ya está en uso.";
        header("Location: ../views/register.php");
        exit();
    }

    // 2. Hashear la contraseña
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    
    // 3. Insertar el nuevo usuario
    // Nota: El campo 'apellido' no se pide, se pasa una cadena vacía.
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellido, usuario, password_hash, rol) VALUES (?, '', ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $usuario, $password_hash, $rol);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "¡Registro exitoso! Ya puedes iniciar sesión.";
        header("Location: ../views/login.php");
        exit();
    } else {
        $_SESSION['error_register'] = "Error al crear la cuenta: " . $conn->error;
        header("Location: ../views/register.php");
        exit();
    }
}

// Redirigir si se accede directamente
header("Location: ../views/register.php");
exit();
?>