
<!DOCTYPE html>
<html lang="es">

<head>
    <?php
    require_once("includes/head.php");
    ?>
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <link href="assets/css/desarrollo.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
</head>

<body>
    <?php
    require_once("includes/header.php"); 
    ?>
    <div class="error-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="error-text">

                        <div class="im-sheep">
                            <div class="top">
                                <div class="body"></div>
                                <div class="head">
                                    <div class="im-eye one"></div>
                                    <div class="im-eye two"></div>
                                    <div class="im-ear one"></div>
                                    <div class="im-ear two"></div>
                                </div>
                            </div>
                            <div class="im-legs">
                                <div class="im-leg"></div>
                                <div class="im-leg"></div>
                                <div class="im-leg"></div>
                                <div class="im-leg"></div>
                            </div>
                        </div>
                        <h4>¡Lo sentimos!</h4>
                        <p>Este apartado de la web todavía está en desarrollo</p>
                        <a href="?controller=home&accion=index" class="btn btn-primary btn-round">Ir a inicio</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<footer>
    <?php require_once("includes/footer.php"); 
    ?>
</footer>

</html>