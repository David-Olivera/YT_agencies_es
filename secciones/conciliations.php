
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
    <title>YameviTravel - Conciliaciones</title>
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
            <h4 class="pb-2">Conciliaciones</h4>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="conciliation-tab" data-toggle="tab" href="#conciliation" role="tab" aria-controls="conciliation" aria-selected="true">Conciliados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="noconciliation-tab" data-toggle="tab" href="#noconciliation" role="tab" aria-controls="noconciliation" aria-selected="false">No Conciliados</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active pt-3" id="conciliation" role="tabpanel" aria-labelledby="conciliation-tab">

                    </div>
                    <div class="tab-pane fade pt-3" id="noconciliation" role="tabpanel" aria-labelledby="noconciliation-tab">
                        <div class='row'>
                            <div class='col-lg-6'>
                                <label for=''><small>Busqueda por ID de reservación</small></label>
                                <div class='form-row'>
                                    <div class='form-group' id='content_invoice'>
                                        <div class='input-group'>                    
                                            <input type='text' class='form-control form-control-sm  mr-2'  id='inp_code_invoice' placeholder='Escribe el ID'>
                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <a href='#' class='btn btn-yamevi_2 btn-sm'>Buscar</a>
                                    </div> 
                                </div>
                            </div>
                            <div class='col-lg-6 text-right'>
                                
                                <div class='form-group'> 
                                    <div id="conciliacion_multi_select">
                                        <label for=''><small>Selecciona las reservaciones que quieres conciliar en un mismo doc</small></label><br>
                                        <div class="row">
                                            <div class="col-lg-10">     
                                                <a href="#"  class='btn btn-yamevi btn-sm' id='verDiasSeleccionados'>Conciliar seleccionados <i class='fas fa-file-upload'></i>  </a>        
                                            </div>
                                            <div class="col-lg-2">
                                                <a href="#" class="btn btn-secondary btn-sm" id="cancel_multi_concilia">Cancelar</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="conciliacion_multi">
                                        <label for=''><small>Conciliación multiple (CM)</small></label><br>
                                        <a href="#"  class='btn btn-yamevi_2 btn-sm' id='btn_select_reservs'><i class="fas fa-paste"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="no_conciliations">
                        </div>
                    </div>
                </div>
            </div>
        </div>
     </div>
</body>
    <?php include('include/footer_agencies.php')?>
    <?php include('include/scrips_agencies.php')?>
</html>