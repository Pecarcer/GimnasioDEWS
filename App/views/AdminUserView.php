
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


</head>

<body>
    <?php
    require_once("includes/header.php");  
    ?>
    <main class="mt-5">
        <div class="container">

            <!-- Heading -->
            <div class="row">

                <div class="col">
                </div>
                <div class="col">
                    <h2 class="mb-5 font-weight-bold">Administración Usuarios</h2>
                    <?php
                    if (isset($errores) && count($errores) > 0) {
                        foreach ($errores as $error)
                            echo '<div class="alert alert-danger">' . $error . '</div>';
                    } else if (isset($errores) && isset($inicio) && !$inicio) {
                        echo '<div class="alert alert-success"> Operación ejecutada correctamente :) </div>';
                    }
                    ?>
                </div>
                <div class="col">
                </div>

            </div>

            <div class="row">
                <div class="col">
                    <div class="nav navbar-nav navbar-right ">
                        <a class="dropdown-toggle " id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Nº Registros:</a>
                        <div class="dropdown-menu dropdown-primary position-absolute" aria-labelledby="navbarDropdownMenuLink">

                            <a class="dropdown-item" href="?controller=admin&accion=administrarUsuarios&regsxpag=2"> <i class="icon-fixed-width icon-th"></i> 2</a>
                            <a class="dropdown-item" href="?controller=admin&accion=administrarUsuarios&regsxpag=4"> <i class="icon-fixed-width icon-th"> </i> 4</a>
                            <a class="dropdown-item" href="?controller=admin&accion=administrarUsuarios&regsxpag=8"> <i class="icon-fixed-width icon-th"></i> 8</a>
                            <a class="dropdown-item" href="?controller=admin&accion=administrarUsuarios&regsxpag=10"><i class="icon-fixed-width icon-th"></i> 10</a>

                        </div>
                    </div>
                </div>
            </div>

            <!--Grid row-->
            <div class="row d-flex justify-content-center mb-12">

                <!--Grid column-->
                <div class="col-md-12">
                    <div class="row">
                        <div class="col">
                            <table class="table table-striped">
                                <tr>
                                    <th>Id</th>
                                    <th>Usuario</th>
                                    <th>Nombre</th>
                                    <th>Apellidos</th>
                                    <th>NIF</th>
                                    <th>Telefono</th>
                                    <th>Direccion</th>
                                    <th>Email</th>
                                    <th>Imagen</th>
                                    <th>Rol</th>
                                    <!-- Añadimos una columna para las operaciones que podremos realizar con cada registro -->
                                    <th colspan=3></th>
                                </tr>
                                <!--Los datos a listar están almacenados en $parametros["datos"]r-->
                                <?php foreach ($datos as $d) { ?>
                                    <!--Mostramos cada registro en una fila de la tabla-->
                                    <tr>
                                        <td><?= $d["id"] ?></td>
                                        <td><?= $d["login"] ?></td>
                                        <td><?= $d["nombre"] ?></td>
                                        <td><?= $d["apellidos"] ?></td>
                                        <td><?= $d["nif"] ?></td>
                                        <td><?= $d["telefono"] ?></td>
                                        <td><?= $d["direccion"] ?></td>
                                        <td><?= $d["email"] ?></td>
                                        <?php if ($d["imagen"] !== NULL) { ?>
                                            <td><img src="assets/img/avatarUsers/<?= $d['imagen'] ?>" width="40" /></td>
                                        <?php } else { ?>
                                            <td>----</td>
                                        <?php } ?>

                                        <?php if ($d["rol_id"] == 0) { ?>
                                            <td>Usuario</td>
                                        <?php } else { ?>
                                            <td>Admin</td>
                                        <?php } ?>


                                        
                                        <?php
                                        if ($d['id'] != $_SESSION["id"]) { ?>
                                            <?php
                                            if ($d["activado"] == 0) {
                                            ?>
                                                <td><a href="?controller=admin&accion=activarUsuarioTabla&id=<?= $d['id'] ?>"><i class="far fa-thumbs-up green-text"></i></a></td>

                                            <?php
                                            } else {
                                            ?>
                                                <td><a href="?controller=admin&accion=desactivarUsuarioTabla&id=<?= $d['id'] ?>"><i class="far fa-thumbs-down red-text"></i> </a></td>
                                            <?php
                                            }
                                            ?>

                                            <td><a href="?controller=admin&accion=modificarUsuarioSeleccionado&id=<?= $d['id'] ?>"><i class="far fa-edit green-text"></i> </a></td>


                                            <td><a href="?controller=admin&accion=deluser&id=<?= $d['id'] ?>"><i class="fas fa-trash-alt"></i></a></td>
                                        <?php }
                                        ?>

                                    </tr>
                                <?php } ?>
                            </table>

                            <?php //Sólo mostramos los enlaces a páginas si existen registros a mostrar
                            if ($totalregistros >= 1) {
                            ?>
                                <nav aria-label="Page navigation example" class="text-center">
                                    <ul class="pagination">

                                        <?php
                                        //Comprobamos si estamos en la primera página. Si es así, deshabilitamos el botón 'anterior'
                                        if ($pagina == 1) { ?>
                                            <li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li>
                                        <?php } else { ?>
                                            <li class="page-item"><a class="page-link" href="index.php?pagina=<?php echo $pagina - 1; ?>&regsxpag=<?= $regsxpag ?>"> &laquo;</a></li>
                                        <?php
                                        }
                                        //Mostramos como activos el botón de la página actual
                                        for ($i = 1; $i <= $numpaginas; $i++) {
                                            if ($pagina == $i) {
                                                echo '<li class="page-item active"> 
                                        <a class="page-link" href="?controller=admin&accion=administrarUsuarios&pagina=' . $i . '&regsxpag=' . $regsxpag . '">' . $i . '</a></li>';
                                            } else {
                                                echo '<li class="page-item"> 
                                        <a class="page-link" href="?controller=admin&accion=administrarUsuarios&pagina=' . $i . '&regsxpag=' . $regsxpag . '">' . $i . '</a></li>';
                                            }
                                        }
                                        //Comprobamos si estamos en la última página. Si es así, deshabilitamos el botón 'siguiente'
                                        if ($pagina == $numpaginas) : ?>
                                            <li class="page-item disabled"><a class="page-link" href="#">&raquo;</a></li>
                                        <?php else : ?>
                                            <li class="page-item"><a class="page-link" href="index.php?pagina=<?php echo $pagina + 1; ?>&regsxpag=<?= $regsxpag ?>"> &raquo; </a></li>
                                        <?php endif; ?>
                                    </ul>
                                </nav>
                            <?php }
                            ?>

                        </div>
                    </div>
                    <br>

                    <hr>


                    <p class="text-center">
                    <h3 class="mb-5 font-weight-bold text-center "> <?php if (isset($usuario)) {
                                                                        echo "Modificar Usuario";
                                                                    } else {
                                                                        echo "Añadir Usuario";
                                                                    } ?> </h3>
                    </p>



                    <?php
                    if (isset($usuario)) {
                    ?>
                        <form action="?controller=admin&accion=actuser&id=<?= $usuario['id'] ?>" method="POST" enctype="multipart/form-data">
                        <?php

                    } else {
                        ?>
                            <form action="?controller=admin&accion=adduser" method="POST" enctype="multipart/form-data">
                            <?php
                        }
                            ?>


                            <div class="form-group">
                                <label for="nombre" class="cols-sm-2 control-label">Nombre</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">

                                        <input type="text" class="form-control" name="nombre" value="<?php

                                                                                                        if (isset($usuario)) {
                                                                                                            echo $usuario["nombre"];
                                                                                                        } else if (isset($nombre)) {
                                                                                                            echo $nombre;
                                                                                                        } ?>" required />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="apellidos" class="cols-sm-2 control-label">Apellidos</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">

                                        <input type="text" class="form-control" name="apellidos" value="<?php
                                                                                                        if (isset($usuario)) {
                                                                                                            echo $usuario["apellidos"];
                                                                                                        } else if (isset($apellidos)) {
                                                                                                            echo $apellidos;
                                                                                                        } ?>" required />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="nif" class="cols-sm-2 control-label">DNI</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">

                                        <input type="text" class="form-control" name="nif" value="<?php
                                                                                                    if (isset($usuario)) {
                                                                                                        echo $usuario["nif"];
                                                                                                    } else if (isset($nif)) {
                                                                                                        echo $nif;
                                                                                                    } ?>" required />

                                    </div>
                                </div>
                            </div>


                            <?php if (isset($usuario)) {
                                echo "<label for=\"imagen\" class=\"cols-sm-2 control-label\">Nueva Imagen</label>";
                            } else {
                                echo "<label for=\"imagen\" class=\"cols-sm-2 control-label\">Imagen</label>";
                            } ?>




                            <div class="cols-sm-10 ">


                                <input type="file" class="form-control-file" name="imagen" />

                            </div> <br><br>


                            <div class="form-group">
                                <label for="email" class="cols-sm-2 control-label">Correo</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">

                                        <input type="text" class="form-control" name="email" value="<?php
                                                                                                    if (isset($usuario)) {
                                                                                                        echo $usuario["email"];
                                                                                                    } else if (isset($email)) {
                                                                                                        echo $email;
                                                                                                    } ?>" required />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="telefono" class="cols-sm-2 control-label">Telefono</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">

                                        <input type="text" class="form-control" name="telefono" value="<?php
                                                                                                        if (isset($usuario)) {
                                                                                                            echo $usuario["telefono"];
                                                                                                        } else if (isset($telefono)) {
                                                                                                            echo $telefono;
                                                                                                        } ?>" required />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="direccion" class="cols-sm-2 control-label">Direccion</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">

                                        <input type="text" class="form-control" name="direccion" value="<?php
                                                                                                        if (isset($usuario)) {
                                                                                                            echo $usuario["direccion"];
                                                                                                        } else if (isset($direccion)) {
                                                                                                            echo $direccion;
                                                                                                        } ?>" required />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="login" class="cols-sm-2 control-label">Usuario</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">

                                        <input type="text" class="form-control" name="login" value="<?php
                                                                                                    if (isset($usuario)) {
                                                                                                        echo $usuario["login"];
                                                                                                    } else if (isset($login)) {
                                                                                                        echo $login;
                                                                                                    } ?>" required />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">




                                <?php if (isset($usuario)) {
                                    echo "<label for=\"password\" class=\"cols-sm-2 control-label\">Nueva Contraseña</label>";
                                } else {
                                    echo "<label for=\"password\" class=\"cols-sm-2 control-label\">Contraseña</label>";
                                } ?>










                                <div class="cols-sm-10">
                                    <div class="input-group">

                                        <input type="password" class="form-control" name="password" value="" <?php if (isset($usuario)) {
                                                                                                                    echo "placeholder=\"Introduzca nueva contraseña si quiere cambiarla\"";
                                                                                                                } ?> />
                                    </div>
                                </div>
                            </div>


                            <div class="form-group ">
                                <input type="submit" class="btn btn-primary" value="Aceptar">
                                <input type="button" onclick='location.href="?controller=admin&accion=administrarUsuarios"' value="Vaciar Campos" class="btn btn-primary">
                            </div>
                            </form>

                            <div class="col-md-2">
                            </div>




                </div>
                <!--Grid column-->

            </div>
            <!--Grid row-->



        </div>

    </main>








</body>
<footer>
    <?php require_once("includes/footer.php"); //Carga el footer.php
    ?>
</footer>

</html>