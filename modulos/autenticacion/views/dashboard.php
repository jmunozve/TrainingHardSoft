<?php require_once '../../../includes/config.php'; ?>
<?php
// 1. Verificar si el usuario está logeado
if (!isset($_SESSION['user_id'])) {
    // Si no está logeado, redirige al login
    $_SESSION['error_login'] = "Debes iniciar sesión para acceder a esta página.";
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-success">
            <h4 class="alert-heading">¡Bienvenido al Dashboard!</h4>
            <p>Has iniciado sesión exitosamente, **<?= $_SESSION['user_usuario'] ?>** (Rol: **<?= $_SESSION['user_rol'] ?>**).</p>
        </div>
        
        <p>Este es el contenido protegido de la aplicación.</p>

        <a href="<?= BASE_URL ?>modulos/autenticacion/controllers/logout.php" class="btn btn-danger">Cerrar Sesión</a>
    </div>
    <script src="<?= BASE_URL ?>assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>