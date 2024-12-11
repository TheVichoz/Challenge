<?php
session_start();

// Tiempo
$timeout = 60;

// Tiempo de inactivi
if (isset($_SESSION['last_activity'])) {
    $elapsed_time = time() - $_SESSION['last_activity']; // Calcular tiempo transcurrido
    if ($elapsed_time > $timeout) {
        // Si ha pasado más de 1 minuto, destruir la sesión
        session_unset();
        session_destroy();
        header("Location: login.php?error=Tu sesión ha expirado. Por favor, inicia sesión nuevamente.");
        exit();
    }
}

// Actz la última actividad
$_SESSION['last_activity'] = time(); // actualiza el tiempo de última actividad

// Verificaarrr si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Codigo de navegacion
include 'navigation.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Dashboard</h1>

        <div class="card shadow p-4">
            <div class="card-body">
                <h2 class="card-title text-primary">Bienvenido, <?php echo $_SESSION['user_name']; ?>!</h2>
                <p class="card-text">Correo electrónico: <?php echo $_SESSION['user_email']; ?></p>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
