<?php
require_once '../../../includes/config.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $password = $_POST['password'] ?? '';

    // 1. Prepara la consulta usando PDO
    $stmt = $conn->prepare("SELECT id, usuario, password_hash, rol FROM usuarios WHERE usuario = :usuario");
    
    // 2. Vincula el parámetro
    $stmt->bindParam(':usuario', $usuario);
    $stmt->execute();
    
    // 3. Obtiene el resultado (PDO::FETCH_ASSOC ya está configurado por defecto)
    $user = $stmt->fetch();

    if ($user) { // PDO fetch devuelve el array asociativo o false si no hay resultados
        
        // 4. Verifica la contraseña encriptada
        if (password_verify($password, $user['password_hash'])) {
            
            // Autenticación exitosa: Inicia sesión
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_usuario'] = $user['usuario'];
            $_SESSION['user_rol'] = $user['rol'];
            
            header("Location: ../views/dashboard.php");
            exit();

        } else {
            $_SESSION['error_login'] = "Contraseña incorrecta.";
        }
    } else {
        $_SESSION['error_login'] = "Usuario no encontrado.";
    }

    // Redirige de vuelta al login
    header("Location: ../views/login.php");
    exit();
}

header("Location: ../views/login.php");
exit();
?>