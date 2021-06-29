
<?php
require_once '../../YameviTravel/config/conexion.php';
session_start();

$todaysale = 0;
if (isset($_SESSION['yt_id_agency'])) {
    if (isset($_SESSION['yt_todaysale'])) {
        $todaysale = $_SESSION['yt_todaysale'];
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
        <?php include('include/navigation_Agencies.php');?>
        <div class="container container_pages">
            <h3 class="text-danger">RESERVACIÓN COMPLETADA</h3>
            <br>
            <p>Su reservación ha sido creada de forma exitosa, en los próximos minutos el cliente deberá recibir su carta de confirmación a la dirección de correo proporcionada en el proceso de reservación.<br><br> Si por alguna razón no encuentra su correo en la bandeja de entrada es importante verificar la bandeja de SPAM.</p>
            <a href="reservations.php" class="btn btn-sm btn-yamevi" data-animation="fadeInLeft" data-delay=".8s">Mis Reservaciones</a>
        </div>
    </div>
    
</body>
    <?php include('include/footer_agencies.php')?>
    <?php include('include/scrips_agencies.php')?>
</html>