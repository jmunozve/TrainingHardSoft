<?php require_once '../../../includes/config.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow" style="max-width: 450px; width: 100%;">
            <h3 class="card-title text-center mb-4">Registro</h3>
            
            <?php if (isset($_SESSION['error_register'])): ?>
                <div class="alert alert-danger" role="alert"><?= $_SESSION['error_register']; unset($_SESSION['error_register']); ?></div>
            <?php endif; ?>

            <form action="../controllers/register_controller.php" method="POST">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuario</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="rol" class="form-label">Rol (Estudiante por defecto)</label>
                    <select class="form-select" id="rol" name="rol" required>
                        <option value="estudiante" selected>Estudiante</option>
                        <option value="profesor">Profesor</option>
                        </select>
                </div>
                <button type="submit" class="btn btn-success w-100">Crear Cuenta</button>
            </form>
            
            <p class="text-center mt-3 mb-0 small"><a href="login.php">Volver al Inicio de Sesión</a></p>
        </div>
    </div>
    <script src="<?= BASE_URL ?>assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>