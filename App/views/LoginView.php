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
				<h4 class="card-header">Login</h4>
				<div class="card-body">
					<?php
					if (isset($loginIncorrecto) && !empty($loginIncorrecto)) {
					?>
						<div class="alert alert-danger"> <?= $loginIncorrecto ?></div>
					<?php
					} ?>
					<form data-toggle="validator" role="form" method="post" action="?controller=index&accion=login">
						<input type="hidden" class="hide" id="csrf_token" name="csrf_token" value="C8nPqbqTxzcML7Hw0jLRu41ry5b9a10a0e2bc2">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Usuario</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fa fa-envelope-open-o" aria-hidden="true"></i></span>
										</div>
										<input type="text" class="form-control" name="usuario" placeholder="Introduce tu nick" value="<?php if (isset($_COOKIE["usuario"])) {
																																			echo $_COOKIE["usuario"];
																																		} ?>" required>
									</div>
									<div class="help-block with-errors text-danger"></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Contraseña</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fa fa-unlock" aria-hidden="true"></i></span>
										</div>
										<input type="password" name="password" class="form-control" placeholder="Introduce tu contraseña" value="<?php if (isset($_COOKIE['password'])) {
																																						echo $_COOKIE['password'];
																																					} ?>" required>
									</div>
									<div class="help-block with-errors text-danger"></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="checkbox checkbox-primary">
								<input id="checkbox_recuerdame" type="checkbox" name="recuerdame" <?php if (isset($_COOKIE['recuerdame']) && $_COOKIE['recuerdame'] == "on") {
																										echo "checked";
																									} ?>>
								<label for="checkbox_recuerdame"> Recuérdame</label>
							</div>

							<div class="checkbox checkbox-primary">
								<input id="checkbox_mantener_sesion" type="checkbox" name="mantenerSesion" <?php if (isset($_COOKIE['mantenerSesion']) && $_COOKIE['mantenerSesion'] != true) {
																												echo " checked";
																											} ?>>
								<label for="checkbox_mantener_sesion"> Mantener sesión abierta</label>
							</div>
						</div>
						<div class="g-recaptcha separar" data-sitekey="6Ld7NhwaAAAAAF_XxeXT6_uZ9SecOeV5ke9DBo9-"></div><br>
						<div class="row">
							<div class="col-md-12">
								<input type="hidden" name="redirect" value="">
								<input type="submit" class="btn btn-primary btn-lg btn-block" value="Login" name="submit">
							</div>
						</div>
					</form>
					<div class="clear"></div>
					<i class="fa fa-user fa-fw"></i> ¿No tienes cuenta aún? <a href="?controller=index&accion=register">Regístrate</a><br>
					<i class="fa fa-undo fa-fw"></i> ¿Se te olvidó tu contraseña? <a href="?controller=index&accion=recuperarContrasena">Recupérala</a>
				</div>
			</div>
		</div>
	</div>
</body>

</html>