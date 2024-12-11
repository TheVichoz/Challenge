<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css"> 
</head>
<body>
    <h1>Bienvenido al Sistema</h1>
    <p>Usa los enlaces de abajo para navegar por las secciones:</p>

    <nav>
        <ul>
            <li><a href="views/register.php">Registro</a></li>
            <li><a href="views/login.php">Iniciar Sesión</a></li>
            <li><a href="views/dashboard.php">Dashboard</a></li>
        </ul>
    </nav>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Mi Sistema. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
