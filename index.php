<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
	<link href="./adi_bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<style>
		body {
			background-color: #212529;
			color: #e0e0e0;
			display: flex;
			justify-content: center;
			align-items: center;
			min-height: 100vh;
			margin: 0;
		}
		.login-card {
			background: #2a2a2a;
			border: none;
			border-radius: 15px;
			box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
			padding: 40px;
			width: 100%;
			max-width: 400px;
		}
		.login-card h2 {
			color: #adb5bd; /* Light gray accent */
			text-align: center;
			margin-bottom: 30px;
			font-weight: 700;
		}
		.form-control {
			background-color: #343a40;
			border: 1px solid #495057;
			color: #e0e0e0;
		}
		.form-control:focus {
			background-color: #343a40;
			border-color: #adb5bd; /* Light gray accent */
			box-shadow: 0 0 0 0.25rem rgba(173, 181, 189, 0.25);
			color: #e0e0e0;
		}
		.btn-primary {
			background-color: #adb5bd; /* Light gray accent */
			border-color: #adb5bd; /* Light gray accent */
			font-weight: 600;
		}
		.btn-primary:hover {
			background-color: #6c757d;
			border-color: #6c757d;
		}
	</style>
</head>
<body>
	<div class="login-card">
		<h2>FORMULARIO DE LOGIN</h2>
		<?php
		if (isset($_SESSION['error_message'])) {
			echo '<div class="alert alert-danger text-center" role="alert">' . $_SESSION['error_message'] . '</div>';
			unset($_SESSION['error_message']); // Clear the message after displaying
		}
		?>
		<form action="Validar.php" method="POST">
			<div class="mb-3">
				<input type="text" class="form-control" placeholder="Usuario" name="usuario" required>
			</div>
			<div class="mb-3">
				<input type="password" class="form-control" placeholder="Contraseña" name="clave" required>
			</div>
			<div class="d-grid">
				<input type="submit" class="btn btn-primary" value="Ingresar">
			</div>
		</form>
	</div>

	<script src="./adi_bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>