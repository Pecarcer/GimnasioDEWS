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

            <div class="row">
                <div class="col">
                </div>
                <div class="col">
                    <h2 class="mb-5 font-weight-bold">Admin. Actividades</h2>
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

                            <a class="dropdown-item" href="?controller=admin&accion=modificarActividad&regsxpag=2"> <i class="icon-fixed-width icon-th"></i> 2</a>
                            <a class="dropdown-item" href="?controller=admin&accion=modificarActividad&regsxpag=4"> <i class="icon-fixed-width icon-th"> </i> 4</a>
                            <a class="dropdown-item" href="?controller=admin&accion=modificarActividad&regsxpag=8"> <i class="icon-fixed-width icon-th"></i> 8</a>
                            <a class="dropdown-item" href="?controller=admin&accion=modificarActividad&regsxpag=10"><i class="icon-fixed-width icon-th"></i> 10</a>

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
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Aforo Max.</th>

                                    <!-- Añadimos una columna para las operaciones que podremos realizar con cada registro -->
                                    <th colspan=2></th>
                                </tr>
                                <!--Los datos a listar están almacenados en $parametros["datos"]-->
                                <?php foreach ($datos as $d) { ?>
                                    <!--Mostramos cada registro en una fila de la tabla-->
                                    <tr>
                                        <td><?= $d["id"] ?></td>
                                        <td><?= $d["nombre"] ?></td>
                                        <td><?= $d["descripcion"] ?></td>
                                        <td><?= $d["aforo"] ?></td>

                                        <!-- Enviamos mediante GET el id del registro que deseamos editar o eliminar: -->

                                        <td><a href="?controller=admin&accion=actualizarActividad&id=<?= $d['id'] ?>"><i class="far fa-edit green-text"></i> </a></td>
                                        <!--editar-->

                                        <td><a href="?controller=admin&accion=delact&id=<?= $d['id'] ?>"><i class="fas fa-trash-alt"></i></a></td>
                                        <!--eliminar-->
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
                                            <li class="page-item"><a class="page-link" href="?controller=admin&accion=modificarActividad&pagina=<?php echo $pagina - 1; ?>&regsxpag=<?= $regsxpag ?>"> &laquo;</a></li>
                                        <?php
                                        }
                                        //Mostramos como activos el botón de la página actual
                                        for ($i = 1; $i <= $numpaginas; $i++) {
                                            if ($pagina == $i) {
                                                echo '<li class="page-item active"> 
                                        <a class="page-link" href="?controller=admin&accion=modificarActividad&pagina=' . $i . '&regsxpag=' . $regsxpag . '">' . $i . '</a></li>';
                                            } else {
                                                echo '<li class="page-item"> 
                                        <a class="page-link" href="?controller=admin&accion=modificarActividad&pagina=' . $i . '&regsxpag=' . $regsxpag . '">' . $i . '</a></li>';
                                            }
                                        }
                                        //Comprobamos si estamos en la última página. Si es así, deshabilitamos el botón 'siguiente'
                                        if ($pagina == $numpaginas) { ?>
                                            <li class="page-item disabled"><a class="page-link" href="#">&raquo;</a></li>
                                        <?php } else { ?>
                                            <li class="page-item"><a class="page-link" href="?controller=admin&accion=modificarActividad&pagina=<?php echo $pagina + 1; ?>&regsxpag=<?= $regsxpag ?>"> &raquo; </a></li>
                                        <?php } ?>
                                    </ul>
                                </nav>
                            <?php }
                            ?>

                        </div>
                    </div>
                    <br>
                    <hr>


                    <p class="text-center">
                    <h3 class="mb-5 font-weight-bold text-center "> <?php if (isset($edact)) {
                                                                        if ($edact != null) {
                                                                            echo "Modificar Actividad";
                                                                        } else {
                                                                            echo "Añadir Actividad";
                                                                        }
                                                                    } else {
                                                                        echo "Añadir Actividad";
                                                                    } ?> </h3>
                    </p>

                    <?php
                    if (isset($edact)) {

                        if ($edact != null) {
                    ?>
                            <form action="?controller=admin&accion=actualizarActividad&id=<?= $edact['id'] ?>" method="POST" enctype="multipart/form-data">
                            <?php

                        } else {
                            ?>
                                <form action="?controller=admin&accion=addact" method="POST" enctype="multipart/form-data">
                                <?php
                            }
                        } else {
                                ?>
                                <form action="?controller=admin&accion=addact" method="POST" enctype="multipart/form-data">
                                <?php
                            }
                                ?>


                                <div class="form-group">
                                    <label for="nombre" class="cols-sm-2 control-label">Nombre</label>
                                    <div class="cols-sm-10">
                                        <div class="input-group">

                                            <input type="text" class="form-control" name="nombre" value="<?php if (isset($edact) || !$edact == null) {
                                                                                                                if (isset($nombre)) {
                                                                                                                    echo $nombre;
                                                                                                                }
                                                                                                            } ?>" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="apellidos" class="cols-sm-2 control-label">Aforo</label>
                                    <div class="cols-sm-10">
                                        <div class="input-group">

                                            <input type="text" class="form-control" name="aforo" value="<?php if (isset($edact) || !$edact == null) {
                                                                                                            if (isset($aforo)) {
                                                                                                                echo $aforo;
                                                                                                            }
                                                                                                        } ?>" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="nif" class="cols-sm-2 control-label">Descripcion</label>
                                    <div class="cols-sm-10">
                                        <div class="input-group">

                                            <input type="text" class="form-control" name="descripcion" value="<?php if (isset($edact) || !$edact == null) {
                                                                                                                    if (isset($descripcion)) {
                                                                                                                        echo $descripcion;
                                                                                                                    }
                                                                                                                } ?>" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <input type="submit" class="btn btn-primary" value="Aceptar">
                                    <input type="button" onclick='location.href="?controller=admin&accion=modificarActividad"' value="Vaciar Campos" class="btn btn-primary">
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