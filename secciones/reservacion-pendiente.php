
<?php
require_once '../config/conexion.php';
session_start();

$todaysale = 0;
if (isset($_SESSION['yt_id_agency'])) {
    if (isset($_SESSION['yt_todaysale'])) {
        $todaysale = $_SESSION['yt_todaysale'];
    }
    //sino, calculamos el tiempo transcurrido
    $fechaGuardada = $_SESSION["ultimoAcceso"];
    $ahora = date("Y-n-j H:i:s");
    $tiempo_transcurrido = (strtotime($ahora)-strtotime($fechaGuardada));

    //comparamos el tiempo transcurrido
    if($tiempo_transcurrido >= 600) {
        ?>
        <script type="text/javascript">
        alert('Su sesion a sido cerrada por inactivididad, favor de iniciar sesión nuevamente');
        window.location.href='../helpers/logout_a.php';
        </script>
        <?php
    }else {
        $_SESSION["ultimoAcceso"] = $ahora;
    }
}else{
    header('location: ../helpers/logout_a.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="../assets/img/yamevIcon.png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YameviTravel - Completado</title>
    <?php include('include/estilos_agencies.php')?>
</head>
<body> 
    <div class="backgound_img" data-background="../assets/img/hero/h1_hero.jpg">
        <?php include('include/navigation_agencies.php');?>
        <div class="container container_pages">
            <h3 class="text-danger">Gracias por elegir Yamevi Travel</h3>
            <br>
            <p>Su pago se encuentra en proceso, tan pronto como sea completado deberá recibir la información para tomar su servicio.</p>
            <a href="reservations.php" class="btn btn-sm btn-yamevi" data-animation="fadeInLeft" data-delay=".8s">Mis Reservaciones</a>
        </div>
    </div>
    
</body>
    <?php include('include/footer_agencies.php')?>
    <?php include('include/scrips_agencies.php')?>
</html>