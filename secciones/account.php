
<?php
require_once '../config/conexion.php';
session_start();
if ($_GET['a']) {
    $id_agency = $_GET['a'];
}
if ($_SESSION['yt_id_agency']) {
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
    <link rel="icon" href="../assets/img/icon/yamevIcon.png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YameviTravel - Cuenta</title>
    <?php include('include/estilos_agencies.php')?>
</head>
<body> 
    <button  id="btnToTop" title="Go to top"><i class="fas fa-angle-up"></i></button> 
    <div class="backgound_img" data-background="../../assets/img/hero/h1_hero.jpg">
        <?php 
            include('include/navigation_agencies.php');
        ?>
        <input type="hidden" class="" value="<?php echo $_SESSION['yt_id_agency']?>" id="inp_agency"> 

        <div class="container container_pages pb-4">
           
            <div class="alert  alert-dismissible fade show" id="alert_msg_account" role="alert">
                <div id="text_alert_msg_account" class="mb-0">
                    
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-2 text-center">
                    <div class="content-img-profile">
                        <img class="w-100" src="" id="img_agency" alt="">
                    </div>
                    <hr>
                    <div class="form-group">
                        <a href="#" class="btn btn-sm btn-yamevi_2 p-2" data='taco' title='Presiona para actualizar imagen' id='add_img' data-toggle='modal' data-target='#exampleModal'>Actualizar Imagen</a>
                    </div>
                </div>
                <div class="col-lg-5 col-md-6">
                    <h4 class="pb-2">Mis Datos</h4>
                    <form id="agencyDataForm">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Nombre de Agencia</label>
                            <input type="text" class="form-control form-control-sm" id="inp_name_agencie" placeholder="Ingrese el Nombre de la Agencia" disabled>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Nombre de Contacto</label>
                                    <input type="text" class="form-control form-control-sm" id="inp_name_contac" placeholder="Ingrese el Nombre del Contacto" disabled>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Apellido Paterno</label>
                                    <input type="text" class="form-control form-control-sm" id="inp_lastname_contac" placeholder="Ingrese el Apellido paterno del Contacto" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Correo de Contacto</label>
                                    <input type="email" class="form-control form-control-sm" id="inp_email_contact" placeholder="Ingrese el Email de Contacto" disabled>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Correo de Pagos</label>
                                    <input type="email" class="form-control form-control-sm" id="inp_email_pay" placeholder="Ingrese el Email de Pagos" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Teléfono</label>
                            <input type="text" class="form-control form-control-sm" id="inp_phone_agencie" placeholder="Ingrese el Teléfono de Contacto" disabled>
                        </div>
                        <!-- <div class="form-group">
                            <button type="submit" id="saveButtonData" class="btn btn-yamevi btn-sm text-center p-2">Actualizar Datos</button>
                        </div> -->
                    </form>
                </div>
                <div class="col-lg-3 col-md-4">
                    <h4 class="pb-2">Credenciales</h4>
                    <form id="agencyCredentialsForm">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Nombre de Usuario</label>
                            <input type="text" class="form-control form-control-sm" id="inp_name_user" placeholder="Ingrese el Nuevo Usuario" >
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Contraseña <small>(Actualizar)</small></label>
                            <input type="password" class="form-control form-control-sm" autocomplete="off" id="inp_password_agencie" placeholder="Ingrese la Nueva Contraseña">
                            <div class="invalid-feedback">
                                La contraseña debe ser superior a 6 caracteres
                            </div>
                            <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                <input type="checkbox" class="custom-control-input" id="checked_pass_agency">
                                <label class="custom-control-label" for="checked_pass_agency"><small>Deseo actualizar mi contraseña</small></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" id="saveButtonCreden" class="btn btn-yamevi btn-sm text-center p-2">Actualizar Credenciales</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar Imagen</h5>
                    <button type="button" class="close" id="cancelButtonModal"  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert  alert-dismissible fade show" id="alert_msg" role="alert">
                        <div id="text_alert_msg" class="mb-0">
                            
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="agencieFormModal">
                        <div class="form-group">
                            <input type="hidden" id="name_agenci_img" >
                            <input type="hidden" id="id_agencie_img" name="id_agencie_img" placeholder="ID" class="form-control" >
                        </div>
                        <div class="form-group pb-2 elimined border-bottom">
                            <div class="row">
                                <div class="col-lg-10 col-md-8 pr-0">
                                    <input type="text" class="form-control" id="name_img"  disabled>
                                    <small id="name_img" class="form-text text-muted">El nombre de la imagen actual de la agencia.</small>
                                </div>
                                <div class="col-lg-2 col-md-4">
                                    <a href="#" id="deleteImg" class="btn btn-danger btn-block"><i class="fas fa-trash-alt"></i></a>
                                </div>
                            </div>
                            <div class="w-100 text-center">
                                <img  class="w-50 p-3 " alt="" id="img_ame">
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="name_age_img">
                        </div>
                        <div class="form-group mb-4">
                            <input id="file_agency" type ="file" name="imagen" class="form-control-sm" placeholder="Titulo" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" id="saveButtonImg" class="btn btn-success btn-block text-center">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
    <?php include('include/footer_agencies.php')?>
    <?php include('include/scrips_agencies.php')?>
    <script src="../assets/js/account.js"></script>
</html>