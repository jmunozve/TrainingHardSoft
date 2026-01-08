<?php require_once '../../../includes/config.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow" style="max-width: 400px; width: 100%;">
            <h3 class="card-title text-center mb-4">TRAINIG HARDSOFT</h3>
            
            <?php 
            // Manejo de mensajes de éxito/error (tanto de login como de registro)
            if (isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success" role="alert"><?= $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['error_login'])): ?>
                <div class="alert alert-danger" role="alert"><?= $_SESSION['error_login']; unset($_SESSION['error_login']); ?></div>
            <?php endif; ?>

            <form action="../controllers/login_controller.php" method="POST" autocomplete="off">
                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuario</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" required autocomplete="username">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required autocomplete="current-password">
                </div>
                <button type="submit" class="btn btn-primary w-100">Acceder</button>
            </form>
            
            <div class="text-center mt-3 small">
                <a href="forgot_password.php" class="d-block">¿Olvidaste tu Contraseña?</a>
                <p class="mt-2 mb-0">¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
            </div>
        </div>
    </div>
<script src="<?= BASE_URL ?>assets/js/bootstrap.bundle.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const usuarioInput = document.getElementById('usuario');
        const passwordInput = document.getElementById('password');

        // Ejecuta la limpieza con un pequeño retraso
        // Esto le da tiempo al navegador para inyectar los datos de autocompletado.
        setTimeout(function() {
            if (usuarioInput) {
                usuarioInput.value = '';
            }
            if (passwordInput) {
                passwordInput.value = '';
            }
            
            // Opcional: Enfoca el campo de usuario después de limpiarlo
            if (usuarioInput) {
                usuarioInput.focus();
            }
        }, 100); // 100 milisegundos de retraso
    });
    </script>
</body>
</html>