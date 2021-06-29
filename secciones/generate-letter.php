
<?php
require_once '../config/conexion.php';
session_start();

if ($_SESSION['yt_id_agency']) {
}else{
    header('location: ../helpers/logout_a.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="../assets/img/icon/yamevIcon.png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket - YameviTravel</title>
    <?php include('include/estilos_agencies.php')?>
</head>
<body id="body"> 
    <button  id="btnToTop" title="Go to top"><i class="fas fa-angle-up"></i></button> 
    <div class="backgound_img" data-background="../../assets/img/hero/h1_hero.jpg">
        <div class="content_home_0" data-background="../../assets/img/hero/h1_hero.jpg">
        <input type="hidden" class="" value="<?php echo $_SESSION['id_agency']?>" id="inp_agency"> 
        <input type="hidden" class="" value="<?php echo $_SESSION['todaysale']?>" id="inp_todaysale_edit"> 
            <?php include('include/navigation_Agencies.php');?>
        </div>
        <div class="container container_pages">
            <div id="btn_generate_pdf">
			<a href="#" id="printLetter" class="btn btn-yamevi">IMPRIMIR TICKET</a>
            </div>
            <div class="PDFLetter">   
               <?php
                    include('../model/traslados.php');
                    $reservacion = new Transfer;    
                    if (isset($_GET['letter']) && $_GET['letter'] != NULL) {
                        echo $reservacion->getLetterHtml($_GET['letter'], $_GET['total']);
                    }
               ?> 
            </div>
        </div>
        
     </div>
</body>
    <?php include('include/footer_agencies.php')?>
    <?php include('include/scrips_agencies.php')?>
    <script src="../assets/js/reservations.js"></script>
</html>