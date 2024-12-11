<?php
// Incluir la configuración de la base de datos
include '../config.php';

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $full_name = trim($_POST['full_name']);
    $password = trim($_POST['password']);

    // Validaciones básicas
    if (strlen($full_name) < 5) {
        header("Location: ../views/register.php?error=El nombre completo debe tener al menos 5 caracteres.");
        exit();
    }

    if (strlen($password) < 8 || !preg_match('/[0-9]/', $password) || !preg_match('/[a-zA-Z]/', $password)) {
        header("Location: ../views/register.php?error=La contraseña debe tener al menos 8 caracteres, incluir un número y una letra.");
        exit();
    }

    // Verificar si el correo ya existe
    $checkEmail = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($checkEmail);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->close();
        header("Location: ../views/register.php?error=El correo ya está registrado.");
        exit();
    }
    $stmt->close();

    // Encriptar la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Preparar la consulta SQL para insertar el usuario
    $sql = "INSERT INTO users (email, full_name, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sss", $email, $full_name, $hashed_password);
        if ($stmt->execute()) {
            header("Location: ../views/register.php?success=¡Registro exitoso! Ahora puedes iniciar sesión.");
        } else {
            header("Location: ../views/register.php?error=Error al registrar el usuario. Intenta nuevamente.");
        }
        $stmt->close();
    } else {
        header("Location: ../views/register.php?error=Error en la preparación de la consulta.");
    }

    // Cerrar conexión
    $conn->close();
} else {
    header("Location: ../views/register.php?error=Método no permitido.");
    exit();
}
?>
