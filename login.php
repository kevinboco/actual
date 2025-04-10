<?php
session_start();
require_once 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

    // Consulta para obtener el usuario
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE correo = :correo");
    $stmt->execute(['correo' => $correo]);
    $usuario = $stmt->fetch();

    // Verificar si el usuario existe y si la contraseña es correcta
    if ($usuario && password_verify($contraseña, $usuario['contraseña'])) {
        $_SESSION['id_registrador'] = $usuario['id_registrador'];
        $_SESSION['nombre_usuario'] = $usuario['Nombre'];

        // Redirigir dependiendo del id_registrador
        if ($usuario['id_registrador'] == 3) {  // Si el id_registrador es 1
            header("Location: php/Upload.php"); // Ventana administrativa
        } else {
            header("Location: php/registro.php"); // Ventana de usuario regular
        }
        exit();
    } else {
        $error = "Correo electrónico o contraseña incorrectos";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="icon" type="image/x-icon" href="imagenes/favicon.ico">
    <style>
        body {
    font-family: Arial, sans-serif;
    background-image: url('imagenes/fondo2.jpg');
    background-size: cover;
    background-position: center; 
    background-repeat: no-repeat; 
    background-color: #f4f4f9;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    flex-direction: column;
}
form {

    background: white;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
        body { font-family: Arial, sans-serif; max-width: 500px; margin: 0 auto; padding: 20px; }
        form { display: flex; flex-direction: column; }
        div { margin-bottom: 10px; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], input[type="email"], input[type="password"], select { width: 100%; padding: 8px; }
        input[type="submit"] { background-color: #4CAF50; color: white; padding: 10px; border: none; cursor: pointer; }
        input[type="submit"]:hover { background-color: #45a049; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>

    <h2>Iniciar Sesión</h2>
    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
    <form method="post" action="">
        <div>
            <label for="correo">Correo electrónico:</label>
            <input type="email" id="correo" name="correo" required>
        </div>
        <div>
            <label for="contraseña">Contraseña:</label>
            <input type="password" id="contraseña" name="contraseña" required>
        </div>
        <div>
            <input type="submit" value="Iniciar Sesión">
        </div>
    </form>
    <p>¿No tienes una cuenta? <a href="signup.php">Regístrate aquí</a></p>
</body>
</html>