<?php
session_start();

$usuario = $_POST['usuario'];
$clave = $_POST['clave'];

$conexion = mysqli_connect("localhost", "root", "2147", "bdprueba");
$consulta = "SELECT * FROM usuarios WHERE usuario='$usuario' AND clave='$clave'";
$resultado = mysqli_query($conexion, $consulta);

$filas = mysqli_num_rows($resultado);

if ($filas > 0) {
    $_SESSION['usuario'] = $usuario; 
    header("location:Home.php");
} else {
    echo "error de autentificacion";
}

mysqli_free_result($resultado);
mysqli_close($conexion);
?>