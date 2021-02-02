<!DOCTYPE html>
<html lang="es">

<head>
    <?php
    require_once("includes/head.php");
    ?>
    <link href="assets/css/adminUser.css" rel="stylesheet" />
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <!-- cosas del snippet -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- cosas del snippet -->

</head>

<body>
    <?php
    require_once("includes/header.php");
    ?>
    <?php
    if (isset($errores) && count($errores) > 0) {
        foreach ($errores as $error)
            echo '   <p class="text-center">
            <h3 class="mb-5 font-weight-bold text-center "><div class="alert alert-danger">' . $error . '</div> </h3>
            </p>';
    } else if (isset($errores)) {
        echo '    <p class="text-center">
        <h3 class="mb-5 font-weight-bold text-center "><div class="alert alert-success"> Perfil actualizado correctamente :) </div> </h3>
        </p>';
    }
    ?>
    <div class="container bootstrap snippet">
        <div class="row">
            <div class="col-sm-10">
                <h1> Usuario <?php echo $_SESSION["usuario"] ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <!--left col-->
                <form class="form-vertical" method="post" action="?controller=home&accion=editarPerfil" enctype="multipart/form-data">

                    <div class="text-center">
                        <img src="assets/img/avatarUsers/<?php echo $_SESSION["img"] ?>" class="avatar img-circle img-thumbnail" alt="avatar">
                        <h6>Selecciona otra foto si quieres cambiarla</h6>
                        <input type="file" class="text-center center-block file-upload" name="imagen">
                    </div>
                    <br>
            </div>
            <!--/col-3-->
            <div class="col-sm-8">
                <div class="form-group">
                    <label for="name" class="cols-sm-2 control-label">Nombre</label>
                    <div class="cols-sm-10">
                        <div class="input-group">

                            <input type="text" class="form-control" name="nombre" value="<?php echo $_SESSION["nombre"]; ?>" required />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="cols-sm-2 control-label">Apellidos</label>
                    <div class="cols-sm-10">
                        <div class="input-group">

                            <input type="text" class="form-control" name="apellidos" value="<?php echo $_SESSION["apellidos"]; ?>" required />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="cols-sm-2 control-label">DNI</label>
                    <div class="cols-sm-10">
                        <div class="input-group">

                            <input type="text" class="form-control" name="nif" value="<?php echo $_SESSION["nif"]; ?>" required />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="cols-sm-2 control-label">Correo</label>
                    <div class="cols-sm-10">
                        <div class="input-group">

                            <input type="text" class="form-control" name="email" value="<?php echo $_SESSION["email"]; ?>" required />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="cols-sm-2 control-label">Telefono</label>
                    <div class="cols-sm-10">
                        <div class="input-group">

                            <input type="text" class="form-control" name="telefono" value="<?php echo $_SESSION["telefono"]; ?>" required />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="cols-sm-2 control-label">Direccion</label>
                    <div class="cols-sm-10">
                        <div class="input-group">

                            <input type="text" class="form-control" name="direccion" value="<?php echo $_SESSION["direccion"]; ?>" required />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="cols-sm-2 control-label">Usuario</label>
                    <div class="cols-sm-10">
                        <div class="input-group">

                            <input type="text" class="form-control" name="login" value="<?php echo $_SESSION["usuario"]; ?>" required />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="cols-sm-2 control-label">Contraseña</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <input type="password" class="form-control" name="password" placeholder="Nueva contraseña" />
                        </div>
                    </div>
                </div>
                <br><br>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Actualizar datos</button>
                </div>
                </form>
                <!--/tab-pane-->
            </div>
            <!--/tab-content-->
        </div>
        <!--/col-9-->
    </div>
    <!--/row-->
</body>
<footer>
    <?php require_once("includes/footer.php"); //Carga el footer.php
    ?>
</footer>

</html>