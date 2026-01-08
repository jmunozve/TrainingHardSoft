<?php
require_once '../../../includes/config.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');

    if (empty($usuario)) {
        $_SESSION['forgot_message'] = "Debes ingresar un nombre de usuario.";
        header("Location: ../views/forgot_password.php");
        exit();
    }

    // 1. Verificar si el usuario existe
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE usuario = :usuario");
    $stmt->bindParam(':usuario', $usuario);
    $stmt->execute();
    $user = $stmt->fetch(); // Obtenemos el usuario

    if ($user) {
        
        // 2. Generar Token Único y Caducidad
        $token = bin2hex(random_bytes(32)); // Token de 64 caracteres
        $expires = date("Y-m-d H:i:s", time() + 3600); // Caduca en 1 hora
        $user_id = $user['id'];
        
        // 3. Almacenar el token y la caducidad en la BD (PDO)
        $stmt = $conn->prepare("UPDATE usuarios SET reset_token = :token, reset_expires = :expires WHERE id = :id");
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':expires', $expires);
        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        
        // 4. Mensaje de simulación y Redirección
        $_SESSION['forgot_message'] = "Hemos simulado el envío de un enlace para restablecer tu contraseña.";
        
        // 5. Redirige a la página de olvido con el token en la URL (para la simulación)
        header("Location: ../views/forgot_password.php?token_sent=true&simulated_token=" . $token);
        exit();

    } else {
        // Mensaje genérico por seguridad
        $_SESSION['forgot_message'] = "Si el usuario está registrado, hemos simulado el envío del enlace de restablecimiento.";
        header("Location: ../views/forgot_password.php");
        exit();
    }
}

header("Location: ../views/forgot_password.php");
exit();
?>