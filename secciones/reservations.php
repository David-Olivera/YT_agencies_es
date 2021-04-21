
<?php
require_once '../config/conexion.php';
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="../assets/img/icon/yamevIcon.png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YameviTravel - Mis Reservas</title>
    <?php include('include/estilos_agencies.php')?>
</head>
<body id="body"> 
    <button  id="btnToTop" title="Go to top"><i class="fas fa-angle-up"></i></button> 
    <div class="backgound_img" data-background="../../assets/img/hero/h1_hero.jpg">
        <input type="hidden" class="" value="<?php echo $_SESSION['id_agency']?>" id="inp_agency"> 
        <input type="hidden" class="" value="<?php echo $_SESSION['todaysale']?>" id="inp_todaysale_edit">  
        <div class="content_home_0" data-background="../../assets/img/hero/h1_hero.jpg">
            <?php include('include/navigation_Agencies.php');?>
        </div>
        <div class="container container_pages">
            <h4 class="pb-2">Mis Reservaciones</h4>
            <div>
                <label for="datepicker_star"><small>Busqueda por rango de fechas</small></label>
                <div class="form-row">
                    <div class="form-group" id="content_date_star">
                        <div class="input-group">
                            <input type="text" id="datepicker_star_ser" name="datepicker_star_ser" autocomplete="off" placeholder="Selecciona una fecha inicio" class="form-control form-control-sm" aria-describedby="date">
                            <div class="input-group-append mr-2">
                                <span class="input-group-text" id="date"><i class="far fa-calendar-alt"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group pb-2" id="content_date_end">
                        <div class="input-group">
                            <input type="text" id="datepicker_end_ser" name="datepicker_end_ser" autocomplete="off" placeholder="Selecciona una fecha final" class="form-control form-control-sm" aria-describedby="date">
                            <div class="input-group-append mr-2">
                                <span class="input-group-text" id="date"><i class="far fa-calendar-minus"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <a href="#" class="btn btn-yamevi_2 btn-sm" id="btn_search_reservations">Buscar</a>
                    </div> 
                </div>
            </div>
            <div id="content_reservations">
            </div>
        </div>
    </div>
    <!-- Modal Success -->
    <div id="myModal"  class="modal fade"  data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <div class="icon-box">
                        <i class="material-icons">&#xe85d;</i>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body text-center">
                    <h4>Una duda!</h4>
                    <p>¿Deseas visualizar tu ticket con el costo total del servicio o en $0.00?</p>
                    <input type="hidden" name="" id="id_res_pdf">
                    <select class="custom-select custom-select-sm " id="select_price_pdf" name="select_price_pdf">
                        <option value="3">Seleccione una respuesta</option>
                        <option value="1">En $0.00</option>
                        <option value="0">Con el costo del servicio</option>
                    </select>
                    <div id="content_btn_pdf" class="pt-2">
                    </div>
                </div>
            </div>
        </div>
    </div>     
</body>
    <?php include('include/footer_agencies.php')?>
    <?php include('include/scrips_agencies.php')?>
</html>