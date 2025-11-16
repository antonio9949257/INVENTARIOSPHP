<?php
session_start();

// Definir la URL base del proyecto. Asegúrate de que termine con una barra '/'.
define('BASE_URL', '/');

// Redirige si el usuario no está logueado
if (!isset($_SESSION['usuario']) || !isset($_SESSION['rol'])) {
    header("Location: " . BASE_URL . "index.php");
    exit();
}

$nomUsu = htmlspecialchars($_SESSION['usuario']);
$rolUsu = htmlspecialchars($_SESSION['rol']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FarmaCorp - <?php echo isset($page_title) ? htmlspecialchars($page_title) : 'Inicio'; ?></title>
    <link href="<?php echo BASE_URL; ?>adi_bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #0a58ca; /* Azul más oscuro */
            --success-color: #157347; /* Verde más oscuro */
            --warning-color: #ffb000; /* Amarillo/Naranja más oscuro */
            --info-color: #087990; /* Cian más oscuro */
            --dark-color: #212529;
            --light-color: #f8f9fa;
            --body-bg: #f0f2f5;
        }
        body {
            background-color: var(--body-bg);
            color: var(--dark-color);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .navbar-custom-dark {
            background: linear-gradient(to right, #004085, #003366); /* Degradado más oscuro */
        }
        .navbar-nav .nav-link {
            font-size: 1.1rem; /* Letras más grandes */
            padding-left: 1rem !important;
            padding-right: 1rem !important; /* Más espaciado entre elementos */
        }
        .navbar-nav .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1); /* Efecto hover sutil */
            border-radius: 0.25rem;
        }
        .navbar-nav .nav-item:last-child .nav-link { /* Ajuste para el icono de logout */
            padding-right: 0.5rem !important;
            padding-left: 0.5rem !important;
        }
        .navbar-nav .nav-item:last-child .nav-link i {
            font-size: 1.2rem; /* Icono de logout un poco más grande */
        }
        .navbar-collapse {
            justify-content: center; /* Centrar los elementos del menú */
        }
        .navbar {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .content-wrapper {
            flex: 1;
        }
        .footer {
            background-color: var(--dark-color);
            color: var(--light-color);
            padding: 20px 0;
        }
        /* Estilos para las páginas de tablas */
        .table-container {
            background-color: white;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        /* Estilos para Home.php */
        .welcome-header {
            background: linear-gradient(to right, var(--primary-color), #0056b3);
            color: var(--light-color);
            border-radius: 0.5rem;
        }
        .stat-card {
            border: none;
            border-radius: 0.5rem;
            padding: 1.5rem;
            color: white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.2s ease-in-out;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-card-body {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .stat-card-icon {
            font-size: 3rem;
            opacity: 0.7;
        }
        .stat-card-content {
            text-align: right;
        }
        .stat-card-title {
            font-size: 1rem;
            margin-bottom: 0.25rem;
        }
        .stat-card-number {
            font-size: 2.5rem;
            font-weight: bold;
        }
        .card-link {
            text-decoration: none;
            color: var(--dark-color);
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            display: block;
            height: 100%;
        }
        .card-link .card {
            transition: border-color 0.2s ease-in-out;
        }
        .card-link:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.15);
        }
        .card-link:hover .card {
            border-color: var(--primary-color);
        }
        .card-link .card i {
            color: var(--primary-color);
        }
        .home-banner {
            max-height: 250px;
            width: 100%;
            object-fit: cover;
            object-position: center;
            border: 1px solid #ddd; /* Borde para el carrusel */
            border-radius: 0.5rem; /* Bordes redondeados */
        }
        .main-logo {
            border: 1px solid #ddd; /* Borde para el logo principal */
            border-radius: 0.5rem; /* Bordes redondeados */
            padding: 5px; /* Pequeño padding para que el borde no pegue al logo */
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom-dark">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item">
            <a class="navbar-brand px-3" href="<?php echo BASE_URL; ?>Home.php">FarmaCorp</a>
        </li>
        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>categorias/">Categorías</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>proveedores/">Proveedores</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>productos/">Productos</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>movimientos/">Movimientos</a></li>
        <?php if ($rolUsu == 'gerente'): ?>
        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>usuarios/">Usuarios</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>chat_asistente.php" title="Asistente IA"><i class="fas fa-comments"></i> Asistente IA</a></li>
        <?php endif; ?>
        <li class="nav-item"><a class="nav-link text-danger" href="<?php echo BASE_URL; ?>logout.php" title="Cerrar Sesión"><i class="fas fa-sign-out-alt"></i></a></li>
      </ul>
    </div>
  </div>
</nav>

<main class="content-wrapper">