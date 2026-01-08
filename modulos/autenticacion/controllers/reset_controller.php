<?php
require_once '../../../includes/config.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
    
    // 1. Re-verificar Token y obtener User ID
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE reset_token = :token AND reset_expires > NOW()");
    $stmt->bindParam(':token', $token);
    $stmt->execute();
    $user = $stmt->fetch();

    if (!$user) {
        $_SESSION['reset_error'] = "El enlace de restablecimiento es inválido o ha expirado. Por favor, solicita uno nuevo.";
        header("Location: ../views/reset_password.php?token=" . urlencode($token));
        exit();
    }
    
    // 2. Validar Contraseñas
    if (empty($password) || empty($password_confirm) || $password !== $password_confirm) {
        $_SESSION['reset_error'] = "Las contraseñas no coinciden o están vacías.";
        header("Location: ../views/reset_password.php?token=" . urlencode($token));
        exit();
    }
    
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $user_id = $user['id']; // Obtenemos el ID del usuario directamente de la BD

    // 3. Actualizar la contraseña Y BORRAR EL TOKEN (seguridad)
    $stmt = $conn->prepare("UPDATE usuarios SET password_hash = :password_hash, reset_token = NULL, reset_expires = NULL WHERE id = :id");
    
    $stmt->bindParam(':password_hash', $password_hash);
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT); 

    if ($stmt->execute()) {
        
        // Limpiar la sesión temporal que se usó en reset_password.php
        unset($_SESSION['reset_user_id']); 
        
        $_SESSION['success_message'] = "¡Contraseña actualizada con éxito! Ya puedes iniciar sesión.";
        header("Location: ../views/login.php");
        exit();
    } else {
        $_SESSION['reset_error'] = "Error al actualizar la contraseña.";
        header("Location: ../views/reset_password.php?token=" . urlencode($token));
        exit();
    }
}

header("Location: ../views/login.php");
exit();
?>