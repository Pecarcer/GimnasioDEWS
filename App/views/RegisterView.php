<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once 'includes/head.php';
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">

    <!-- Website CSS style -->
    <link rel="stylesheet" type="text/css" href="assets/css/register.css">

    <!-- Website Font style -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">

    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Passion+One' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

</head>

<body>
    <div class="container">
        <div class="row main">
            <div class="panel-heading">
                <div class="panel-title text-center">
                    <h1 class="title">Gimnasio Onasio</h1>
                    <hr />
                </div>
            </div>
            <div class="main-login main-center">
                <?php


                if (isset($errores) && count($errores) > 0) {
                    foreach ($errores as $error)
                        echo '<div class="alert alert-danger">' . $error . '</div>';
                } else if (isset($errores)) {
                    echo '<div class="alert alert-success"> Usuario añadido correctamente, ahora espera a que un administrador te valide.</div>';
                }


                ?>
                <form class="form-horizontal" method="post" action="?controller=user&accion=adduser" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="name" class="cols-sm-2 control-label">Nombre</label>
                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" name="nombre" placeholder="Tu nombre" value="<?php if (isset($nombre)) {
                                                                                                                            echo $nombre;
                                                                                                                        } ?>" required />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="cols-sm-2 control-label">Apellidos</label>
                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" name="apellidos" placeholder="Tus apellidos" value="<?php if (isset($apellidos)) {
                                                                                                                                echo $apellidos;
                                                                                                                            } ?>" required />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="cols-sm-2 control-label">DNI</label>
                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="far fa-address-card" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" name="nif" placeholder="Tu NIF" value="<?php if (isset($nif)) {
                                                                                                                    echo $nif;
                                                                                                                } ?>" required />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="cols-sm-2 control-label">Imagen</label>
                        <div class="cols-sm-10">

                            <input type="file" class="form-control-file" name="imagen" value="<?php if (isset($imagen)) {
                                                                                                    echo $imagen;
                                                                                                } ?>" required />

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="cols-sm-2 control-label">Correo</label>
                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" name="email" placeholder="Tu correo" value="<?php if (isset($email)) {
                                                                                                                        echo $email;
                                                                                                                    } ?>" required />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="cols-sm-2 control-label">Telefono</label>
                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-mobile fa" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" name="telefono" placeholder="Tu telefono" value="<?php if (isset($telefono)) {
                                                                                                                                echo $telefono;
                                                                                                                            } ?>" required />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="cols-sm-2 control-label">Direccion</label>
                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-map fa" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" name="direccion" placeholder="Tu dirección" value="<?php if (isset($direccion)) {
                                                                                                                                echo $direccion;
                                                                                                                            } ?>" required />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="username" class="cols-sm-2 control-label">Usuario</label>
                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="far fa-user-circle" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" name="login" placeholder="Tu nombre de usuario" value="<?php if (isset($login)) {
                                                                                                                                    echo $login;
                                                                                                                                } ?>" required />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="cols-sm-2 control-label">Contraseña</label>
                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                                <input type="password" class="form-control" name="password" placeholder="Tu contraseña" required />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirm" class="cols-sm-2 control-label">Confirma Contraseña</label>
                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                                <input type="password" class="form-control" name="confirmaPass" placeholder="Confirma tu contraseña" required />
                            </div>
                        </div>
                    </div>

                    <div class="form-group ">
                        <button type="submit" class="btn btn-primary btn-lg btn-block login-button">Registrarme</button>
                    </div>
                    <div class="login-register">
                        <a href="index.php">Ya tengo cuenta</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="assets/js/bootstrap.js"></script>
</body>

</html>