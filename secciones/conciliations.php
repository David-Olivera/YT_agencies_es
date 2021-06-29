
<?php
require_once '../../YameviTravel/config/conexion.php';
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
    <title>YameviTravel - Conciliaciones</title>
    <?php include('include/estilos_agencies.php')?>
</head>
<body id="body"> 
    <button  id="btnToTop" title="Go to top"><i class="fas fa-angle-up"></i></button> 
    <div class="backgound_img" data-background="../../assets/img/hero/h1_hero.jpg">
        <div class="content_home_0" data-background="../../assets/img/hero/h1_hero.jpg">
            <input type="hidden" class="" value="<?php echo $_SESSION['yt_id_agency']?>" id="inp_agency"> 
            <input type="hidden" class="" value="<?php echo $_SESSION['yt_todaysale']?>" id="inp_todaysale_edit"> 
            <?php include('include/navigation_agencies.php');?>
        </div>
        <div class="container container_pages">
            <h4 class="pb-2">Conciliaciones</h4>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="noconciliation-tab" data-toggle="tab" href="#noconciliation" role="tab" aria-controls="noconciliation" aria-selected="false">No Conciliados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " id="conciliation-tab" data-toggle="tab" href="#conciliation" role="tab" aria-controls="conciliation" aria-selected="true">Conciliados</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active pt-3" id="noconciliation" role="tabpanel" aria-labelledby="noconciliation-tab">
                        <div class='row'>
                            <div class='col-lg-6 col-md-6'>
                                <label for=''><small>Busqueda por ID de reservación</small></label>
                                <div class='form-row'>
                                    <div class='form-group' id='content_invoice'>
                                        <div class='input-group'>                    
                                            <input type='text' class='form-control form-control-sm  mr-2'  id='inp_code_invoice_nco' placeholder='Escribe el ID'>
                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <a href='#' id="search_code_invoice_nco" class='btn btn-yamevi_2 btn-sm'>Buscar</a>
                                    </div> 
                                </div>
                            </div>
                            <div class='col-lg-6 col-md-6 text-right'>
                                
                                <div class='form-group'> 
                                    <div id="conciliacion_multi_select">
                                        <label for=''><small>Selecciona las reservaciones que quieres conciliar en un mismo archivo (CM)</small></label><br>
                                        <div class="row">
                                            <div class="col-lg-10">     
                                                <button type="button" disabled="disabled" class='btn btn-yamevi btn-sm' data-toggle='modal' data-target='#upload_conliation_multi' id='IdsSeleccionados'>Conciliar seleccionados <i class='fas fa-file-upload'></i>  </button>     
                                            </div>
                                            <div class="col-lg-2">
                                                <a href="#" class="btn btn-secondary btn-sm btn_close_conci_multi" id="cancel_multi_concilia">Cancelar</a>
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
                    <div class="tab-pane fade  pt-3" id="conciliation" role="tabpanel" aria-labelledby="conciliation-tab">
                        <div class='row'>
                            <div class='col-lg-6 col-md-6'>
                                <label for=''><small>Busqueda por ID de reservación</small></label>
                                <div class='form-row'>
                                    <div class='form-group' id='content_invoice_co'>
                                        <div class='input-group'>                    
                                            <input type='text' class='form-control form-control-sm  mr-2'  id='inp_code_invoice_co' placeholder='Escribe el ID'>
                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <a href='#' id="search_code_invoice_co" class='btn btn-yamevi_2 btn-sm'>Buscar</a>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div id="si_conciliations">
                        </div>
                    </div>
                </div>
            </div>
        </div>
     </div>
     <div class="modal fade " tabindex="-1" role="dialog" id="upload_conliation" data-backdrop="static" data-keyboard="false"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Archivo de Conciliación</h5>
                    <button type="button" class="close btn_close_conci" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-3">
                    <div class="form-group">
                        <label id="label_conci_code"></label><br>
                        <p><small>Solo permite archivos en formato PDF, JPG, JPEG y PNG</small></p>
                        <div id="upload" class="form-control-sm">
                            <div class="fileContainer">
                                <input id="files_conciliation" type="file" name="myfiles[]" multiple="multiple" accept="application/pdf, image/jpeg, image/jpg, image/png" required />
                            </div>
                        </div>
                        <div class="custom-control custom-checkbox mr-sm-2 pt-3">
                            <input type="checkbox" class="custom-control-input" id="check_facture">
                            <label class="custom-control-label" for="check_facture"><small>¿Requiere Factura?</small></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control form-control-sm" autocomplete="off" id="inp_id_reservation"  placeholder="ID">
                        <input type="hidden" class="form-control form-control-sm" autocomplete="off" id="inp_type_conciliation"  placeholder="TYPE CONCILIATION">
                        <input type="hidden" class="form-control form-control-sm" autocomplete="off" id="inp_id_conciliation"  placeholder="CONCILIATION">
                        <input type="hidden" class="form-control form-control-sm" autocomplete="off" id="inp_code_conciliation"  placeholder="CODE">
                    </div>
                    <div class=" text-right">
                        <button type="button" disabled="disabled" id="btn_add_file" class="btn btn-primary">Agregar archivo</button>
                        <button type="button" class="btn btn-secondary btn_close_conci" data-dismiss="modal">Cancelar</button>
                    </div>
                    <div id="loadedfiles" class="pt-2">
                          
                    </div>
                    
                    <hr>
                    <div class="row ml-1 mr-1 mb-3" id="storaged_documents">
                         
                    </div>
                </div>
            </div>
        </div>
    </div>
     <div class="modal fade " tabindex="-1" role="dialog" id="upload_conliation_multi" data-backdrop="static" data-keyboard="false"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Archivo de Conciliación</h5>
                    <button type="button" class="close btn_close_conci_multi" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-3">
                    <div class="form-group">
                        <label for="">Seleccione el archivo</label><br>
                        <p><small>Solo permite archivos en formato PDF, JPG, JPEG y PNG</small></p>
                        <div id="upload" class="form-control-sm">
                            <div class="fileContainer">
                                <input id="files_conciliation_multi" type="file" name="myfiles[]" multiple="multiple" accept="application/pdf, image/jpeg, image/jpg, image/png" required />
                            </div>
                        </div>
                        <div class="custom-control custom-checkbox mr-sm-2 pt-3">
                            <input type="checkbox" class="custom-control-input" id="check_facture_multi">
                            <label class="custom-control-label" for="check_facture_multi"><small>¿Requiere Factura?</small></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Reservaciones Seleccionadas</label>
                        <p><small id="label_id_resercavions"></small></p>
                        <p class="font-italic"><small>Todos los archivos subidos por CM podra visualizarlos dando click en el boton de la columna de <strong>Archivo</strong></small></p>
                    </div>
                    <div class=" text-right">
                        <button type="button" disabled="disabled" id="btn_add_file_multi" class="btn btn-primary">Agregar archivo</button>
                        <button type="button" class="btn btn-secondary btn_close_conci_multi" data-dismiss="modal">Cancelar</button>
                    </div>
                    <div id="loadedfiles_multi" class="pt-2">
                          
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

    <!-- <input id="myfiles" type="file" name="myfiles[]" multiple="multiple" accept="application/pdf, image/jpeg, image/jpg, image/png" required /> -->
    <?php include('include/footer_agencies.php')?>
    <?php include('include/scrips_agencies.php')?>
    <script src="../assets/js/conciliations.js"></script>
</html>