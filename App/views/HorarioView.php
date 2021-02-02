<!--
Será la plantilla de las vistas que incluyen el header, header y footer de include y el body individuales de las vistas.
-->
<!DOCTYPE html>
<html lang="es">

<head>
    <?php
    require_once("includes/head.php"); //Carga el head
    ?>
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" href="./assets/css/horario.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <?php
    require_once("includes/header.php"); //Carga el header.php 
    ?>

    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center mb30">
                    <h2>HORARIO SEMANAL</h2>
                </div>
                <div class="table-responsive">
                    <table class="timetable table table-striped ">
                        <thead class="green lighten-2">
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Lunes</th>
                                <th scope="col">Martes</th>
                                <th scope="col">Miércoles</th>
                                <th scope="col">Jueves</th>
                                <th scope="col">Viernes</th>
                                <th scope="col">Sábado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            foreach ($listaHoras as $d) { ?>
                                <!--Mostramos cada registro en una fila de la tabla-->
                                <tr>
                                    <th scope="col"><?= $d["hora_inicio"] . " - " . $d["hora_fin"]; ?></th>
                                    <!--la horita del día-->
                                    <td><?php foreach ($horario as $h) {
                                            if ($h["hora_inicio"] == $d["hora_inicio"] && $h["hora_fin"] == $d["hora_fin"] && $h["dia"] == "Lunes") {
                                                echo $h["nombre"];
                                            }
                                        } ?></td>
                                    <!--lunes-->

                                    <td><?php foreach ($horario as $h) {
                                            if ($h["hora_inicio"] == $d["hora_inicio"] && $h["hora_fin"] == $d["hora_fin"] && $h["dia"] == "Martes") {
                                                echo $h["nombre"];
                                            }
                                        } ?></td>
                                    <!--martes-->
                                    <td><?php foreach ($horario as $h) {
                                            if ($h["hora_inicio"] == $d["hora_inicio"] && $h["hora_fin"] == $d["hora_fin"] && $h["dia"] == "Miercoles") {
                                                echo $h["nombre"];
                                            }
                                        } ?></td>
                                    <!--miercoles-->
                                    <td><?php foreach ($horario as $h) {
                                            if ($h["hora_inicio"] == $d["hora_inicio"] && $h["hora_fin"] == $d["hora_fin"] && $h["dia"] == "Jueves") {
                                                echo $h["nombre"];
                                            }
                                        } ?></td>
                                    <!--jueves-->
                                    <td><?php foreach ($horario as $h) {
                                            if ($h["hora_inicio"] == $d["hora_inicio"] && $h["hora_fin"] == $d["hora_fin"] && $h["dia"] == "Viernes") {
                                                echo $h["nombre"];
                                            }
                                        } ?></td>
                                    <!--viernes-->
                                    <td><?php foreach ($horario as $h) {
                                            if ($h["hora_inicio"] == $d["hora_inicio"] && $h["hora_fin"] == $d["hora_fin"] && $h["dia"] == "Sábado") {
                                                echo $h["nombre"];
                                            }
                                        } ?></td>
                                    <!--sabado-->
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- timetable -->
            </div>
        </div>
    </div>
</body>
<footer>
    <?php require_once("includes/footer.php"); //Carga el footer.php
    ?>
</footer>

</html>