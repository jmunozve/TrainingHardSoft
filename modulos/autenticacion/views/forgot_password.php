<?php require_once '../../../includes/config.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow" style="max-width: 400px; width: 100%;">
            <h3 class="card-title text-center mb-4">Recuperar Contraseña</h3>
            
            <?php 
            // 1. Manejo de mensajes (ej. error de campo vacío)
            if (isset($_SESSION['forgot_message']) && !isset($_GET['token_sent'])): ?>
                <div class="alert alert-info" role="alert"><?= $_SESSION['forgot_message']; unset($_SESSION['forgot_message']); ?></div>
            <?php endif; ?>

            <?php 
            // 2. Si el token_sent está en la URL, mostrar el mensaje de simulación
            if (isset($_GET['token_sent']) && isset($_GET['simulated_token'])): 
                $sim_token = htmlspecialchars($_GET['simulated_token']);
                ?>
                <div class="alert alert-info" role="alert">
                    <h5 class="alert-heading">¡Correo Enviado! (Simulación)</h5>
                    <p>
                        Se ha enviado un enlace para restablecer tu contraseña. Haz clic en el botón de abajo para simular la recepción del correo.
                    </p>
                    <hr>
                    <p class="mb-0">
                        **Token Generado:** <code class="small"><?= $sim_token ?></code>
                    </p>
                    <a href="reset_password.php?token=<?= $sim_token ?>" class="btn btn-primary btn-sm mt-2">Continuar al Cambio de Contraseña</a>
                </div>
            <?php endif; ?>

            <?php if (!isset($_GET['token_sent'])): ?>
                <p class="text-center text-muted small">Ingresa tu nombre de usuario para iniciar el proceso.</p>
                <form action="../controllers/forgot_controller.php" method="POST">
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuario</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" required>
                    </div>
                    <button type="submit" class="btn btn-warning w-100">Restablecer Contraseña</button>
                </form>
            <?php endif; ?>
            
            <p class="text-center mt-3 mb-0 small"><a href="login.php">Volver al Login</a></p>
        </div>
    </div>
    <script src="<?= BASE_URL ?>assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>