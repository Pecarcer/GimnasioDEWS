<!------ ESTA ES LA VISTA DEL LOGIN, QUE APARECE LA PRIMERA ---------->
<html>

<head>
	<?php
	require_once "includes/recaptchalib.php";
	require_once 'includes/head.php';
	?>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
	<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<link rel="stylesheet" href="./assets/css/login.css">
	<script src="https://www.google.com/recaptcha/api.js?hl=es" async defer></script>
</head>

<body>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
	<div class="container h-100">
		<div class="row h-100 justify-content-center align-items-center">
			<div class="card">
				<h4 class="card-header">Recuperar Contraseña</h4>
				<div class="card-body">
					<?php
					if (isset($errores) && !empty($errores)) {

						echo '<div class="alert alert-danger">' . $errores . '</div>';
					} else if (isset($errores)) {
						echo '<div class="alert alert-success"> Se le ha enviado un mensaje a su cuenta de correo con una nueva contraseña. </div>';
					}
					?>
					<form data-toggle="validator" role="form" method="post" action="?controller=index&accion=enviarRecuperacionContrasena">

						<div class="row pl-4 pr-4">

							<div class="form-group">
								<label>Introduce tu correo</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="fa fa-envelope-open-o" aria-hidden="true"></i></span>
									</div>
									<input type="text" class="form-control" name="email" required>
								</div>
								<br>
								<div class="form-group">
									<input type="submit" name="submit" value="Recuperar" class="btn btn-primary btn-lg btn-block login-button">
									<input type="button" onclick='location.href="?controller=index&accion=index"' value="Volver" class="btn btn-primary btn-lg btn-block login-button">

								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>

</html>