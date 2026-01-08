<?php require_once '../../../includes/config.php'; ?>
<?php
// Obtener el token de la URL. Si no existe, se considera nulo.
$token = $_GET['token'] ?? '';

// 1. Validar el token y la caducidad en la BD
// Se busca un usuario con el token proporcionado que no haya expirado (reset_expires > NOW())
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE reset_token = :token AND reset_expires > NOW()");
$stmt->bindParam(':token', $token);
$stmt->execute();
$user = $stmt->fetch();

// 2. Si el token no es válido o ha expirado, denegar el acceso.
if (!$user) {
    $_SESSION['error_login'] = "El enlace de restablecimiento es inválido o ha expirado. Solicita uno nuevo.";
    // Redirigir al login
    header("Location: login.php");
    exit();
}

// 3. El token es válido. Guardamos el ID del usuario en sesión temporalmente
// para que el reset_controller pueda identificarlo y actualizar la contraseña.
$_SESSION['reset_user_id'] = $user['id'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Contraseña</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow" style="max-width: 400px; width: 100%;">
            <h3 class="card-title text-center mb-4">Establecer Nueva Contraseña</h3>
            
            <?php if (isset($_SESSION['reset_error'])): ?>
                <div class="alert alert-danger" role="alert"><?= $_SESSION['reset_error']; unset($_SESSION['reset_error']); ?></div>
            <?php endif; ?>

            <form action="../controllers/reset_controller.php" method="POST">
                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>"> 
                
                <div class="mb-3">
                    <label for="password" class="form-label">Nueva Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="password_confirm" class="form-label">Confirmar Contraseña</label>
                    <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
                </div>
                
                <button type="submit" class="btn btn-success w-100">Cambiar Contraseña</button>
            </form>
            
            <p class="text-center mt-3 mb-0 small"><a href="login.php">Cancelar y volver al Login</a></p>
        </div>
    </div>
    <script src="<?= BASE_URL ?>assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>