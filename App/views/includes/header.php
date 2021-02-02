
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!--<link href="assets/css/header.css" rel="stylesheet" />-->



<!------ Include the above in your HEAD tag ---------->

<div class="container">
    <div class="row-fluid">
        <div class="span12">
            <div class="span6">
                <h1 >Gimnasio Onasio</h1>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-default" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
            </button>

        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="?controller=home&accion=index"><span class="glyphicon glyphicon-home"></span> Inicio</a></li>
                <li><a href="?controller=home&accion=horario"><span class="glyphicon glyphicon-calendar"></span> Horario</a></li>
                <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-list-alt"></span> Reservas </b></a>
                    <ul class="dropdown-menu">
                        <li><a href="?controller=home&accion=desarrollo">Hacer una reserva</a></li>
                        <li><a href="?controller=home&accion=desarrollo">Ver Reservas</a></li>
                    </ul>
                </li>

                <?php if ($_SESSION["rol"] == 1) { ?>

                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-list-alt"></span> Administración</b></a>
                        <ul class="dropdown-menu">
                            <li><a href="?controller=admin&accion=administrarUsuarios">Usuarios</a></li> 
                            <li><a href="?controller=admin&accion=modificarActividad">Actividades</a></li>
                            <li><a href="?controller=home&accion=desarrollo">Horario</a></li>
                        </ul>
                    </li>
                <?php
                }
                ?>

            </ul>
            <ul class="nav navbar-nav navbar-right">

                <li class="dropdown"><a href="?controller=home&accion=desarrollo"><span class="glyphicon glyphicon-envelope"></span> Mensajes </a>

                </li>

                <li class="dropdown"><a><span class="glyphicon glyphicon-time"></span> Logueado desde <?php echo $_SESSION["horaInicio"] ?></span></a>
                    

                </li>


                <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span>

                        <?php if ($_SESSION["rol"] == 0) {
                            echo "Usuario";
                        } else {
                            echo "Admin";
                        }
                        echo " " . $_SESSION["usuario"];

                        ?>




                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="?controller=home&accion=miPerfil"><span class="glyphicon glyphicon-user"></span> Mi perfil</a></li>
                        <li class="divider"></li>
                        <li><a href="?controller=home&accion=cerrarSesion"><span class="glyphicon glyphicon-off"></span> Cerrar Sesión</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>
</div>