<?php
session_start();


$login_page = 'index.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_input = $_POST['usuario'] ?? '';
    $clave_input = $_POST['clave'] ?? '';


    $conexion = mysqli_connect("localhost", "root", "2147", "bdprueba");

    if (mysqli_connect_errno()) {

        error_log("Failed to connect to MySQL: " . mysqli_connect_error());
        $_SESSION['error_message'] = "Error de conexión a la base de datos.";
        header("Location: " . $login_page);
        exit();
    }


    $stmt = mysqli_prepare($conexion, "SELECT id, clave, rol FROM usuarios WHERE usuario = ?");
    mysqli_stmt_bind_param($stmt, "s", $usuario_input);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) == 1) {
        mysqli_stmt_bind_result($stmt, $id_db, $hashed_password_db, $rol_db);
        mysqli_stmt_fetch($stmt);


        if (password_verify($clave_input, $hashed_password_db)) {

            $_SESSION['usuario'] = $usuario_input;
            $_SESSION['rol'] = $rol_db; 
            $_SESSION['id_usuario'] = $id_db; 
            header("Location: Home.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Usuario o contraseña incorrectos.";
            header("Location: " . $login_page);
            exit();
        }
    } else {
        $_SESSION['error_message'] = "Usuario o contraseña incorrectos.";
        header("Location: " . $login_page);
        exit();
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
} else {
    header("Location: " . $login_page);
    exit();
}
?>