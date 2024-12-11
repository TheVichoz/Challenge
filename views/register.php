<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script>
        // Función para validar el formulario
        function validarFormulario(event) {
            // Obtener los valores de los campos
            const email = document.getElementById("email").value;
            const fullName = document.getElementById("full_name").value;
            const password = document.getElementById("password").value;

            // Validar email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert("Por favor, ingresa un correo electrónico válido.");
                event.preventDefault(); // Detener el envío del formulario
                return false;
            }

            // Validar nombre completo
            if (fullName.length < 5) {
                alert("El nombre completo debe tener al menos 5 caracteres.");
                event.preventDefault();
                return false;
            }

            // Validar contraseña
            const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
            if (!passwordRegex.test(password)) {
                alert("La contraseña debe tener al menos 8 caracteres, incluyendo una letra y un número.");
                event.preventDefault();
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <?php include 'navigation.php'; ?> <!-- Incluir el menú de navegación -->

    <div class="container mt-5">
        <h1 class="text-center mb-4">Registro de Usuario</h1>

        <!-- Mensajes de error o éxito -->
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($_GET['success']); ?>
            </div>
        <?php endif; ?>

        <form action="../controllers/registerController.php" method="POST" class="shadow p-4 rounded bg-light">
            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico:</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="full_name" class="form-label">Nombre completo:</label>
                <input type="text" name="full_name" id="full_name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Registrar</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
