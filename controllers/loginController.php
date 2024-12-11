<?php
// Incluir la configuración de la base de datos
include '../config.php';

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Consultar si el correo existe en la base de datos
    $sql = "SELECT id, email, password, full_name, failed_attempts, lockout_time FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Verificar si el correo existe
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $dbEmail, $dbPassword, $full_name, $failed_attempts, $lockout_time);
        $stmt->fetch();

        // Verificar si la cuenta está bloqueada
        if ($lockout_time && strtotime($lockout_time) > time()) {
            $remaining_time = (strtotime($lockout_time) - time()) / 60; // Tiempo restante en minutos
            header("Location: ../views/login.php?error=Cuenta bloqueada. Intenta de nuevo en " . ceil($remaining_time) . " minutos.");
            exit();
        }

        // Verificar la contraseña
        if (password_verify($password, $dbPassword)) {
            // Restablecer intentos fallidos
            $resetAttempts = "UPDATE users SET failed_attempts = 0, lockout_time = NULL WHERE id = ?";
            $resetStmt = $conn->prepare($resetAttempts);
            $resetStmt->bind_param("i", $id);
            $resetStmt->execute();

            // Iniciar sesión
            session_start();
            $_SESSION['user_id'] = $id;
            $_SESSION['user_email'] = $dbEmail;
            $_SESSION['user_name'] = $full_name;

            // Redirigir al dashboard
            header("Location: ../views/dashboard.php");
            exit();
        } else {
            // Incrementar los intentos fallidos
            $failed_attempts++;
            $updateAttempts = "UPDATE users SET failed_attempts = ? WHERE id = ?";
            $updateStmt = $conn->prepare($updateAttempts);
            $updateStmt->bind_param("ii", $failed_attempts, $id);
            $updateStmt->execute();

            // Bloquear la cuenta si se superan los intentos
            if ($failed_attempts >= 3) {
                $lockout_time = date("Y-m-d H:i:s", strtotime("+2 hours"));
                $blockAccount = "UPDATE users SET lockout_time = ? WHERE id = ?";
                $blockStmt = $conn->prepare($blockAccount);
                $blockStmt->bind_param("si", $lockout_time, $id);
                $blockStmt->execute();

                header("Location: ../views/login.php?error=Has excedido el número de intentos. Tu cuenta está bloqueada por 2 horas.");
                exit();
            }

            header("Location: ../views/login.php?error=Contraseña incorrecta. Intentos restantes: " . (3 - $failed_attempts) . ".");
            exit();
        }
    } else {
        // Correo no encontrado
        header("Location: ../views/login.php?error=El correo electrónico no está registrado.");
        exit();
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();
} else {
    header("Location: ../views/login.php?error=Método no permitido.");
    exit();
}
?>
