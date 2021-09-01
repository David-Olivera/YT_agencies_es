
<?php
require_once '../config/conexion.php';
session_start();

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
    <title>YameviTravel - Usuarios</title>
    <?php include('include/estilos_agencies.php')?>
    <input type="hidden" class="" value="<?php echo $_SESSION['yt_id_agency']?>" id="inp_agency"> 
</head>
<body> 
    <button  id="btnToTop" title="Go to top"><i class="fas fa-angle-up"></i></button>   
    <div class="backgound_img" data-background="../../assets/img/hero/h1_hero.jpg">
        <div class="content_home_0" data-background="../../assets/img/hero/h1_hero.jpg">
            <?php include('include/navigation_agencies.php');?>
        </div>
        <div class="container container_pages">
            <div class="alert  alert-dismissible fade show" id="alert_msg" role="alert">
                <div id="text_alert_msg" class="mb-0">
                    
                </div>
                <button type="button" class="close" id="btn_close_msg" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <h4 class="pb-3">Usuarios</h4>
            <div id="content_user_agency">
            </div> 
        </div>   
    </div>
    <div class="modal fade " tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" id="modal_add_user" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header background_yamevi">
                    <h5 class="modal-title">Usuario</h5>
                    <button type="button" id="close_modal_user" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form id="formNewUser">
                        <div class="">
                            <input type="hidden" class="form-control form-control-sm" autocomplete="off" id="inp_id_user"  placeholder="Ingresa la contraseña de usuario">
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Nombre de Contacto</label>
                                    <input type="text" class="form-control form-control-sm" id="inp_user_name" placeholder="Ingrese el nombre del usuario" >
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Apellido Paterno</label>
                                    <input type="text" class="form-control form-control-sm" id="inp_user_lastname" placeholder="Ingrese el apellido del usuario" >
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="inp_user_email">Correo Electrónico</label>
                                    <input type="email" class="form-control form-control-sm" id="inp_user_email" placeholder="Ingresa el email del usuario">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Teléfono Usuario</label>
                                    <input type="text" class="form-control form-control-sm" id="inp_user_phone" placeholder="Ingrese el teléfono del usuario" >
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inp_user_username">Nombre de Usuario</label>
                            <input type="text" class="form-control form-control-sm" id="inp_user_username"  placeholder="Ingresa el nombre de usuario">
                        </div>
                        <div class="form-group">
                            <label for="inp_user_username">Contraseña</label>
                            <input type="password" class="form-control form-control-sm" autocomplete="off" id="inp_user_password"  placeholder="Ingresa la contraseña de usuario">
                            <div class="invalid-feedback">
                            La contraseña debe ser mayor de 8 digitos
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="inp_user_username">Confirme Contraseña</label>
                            <input type="password" class="form-control form-control-sm" autocomplete="off" id="inp_user_password_confirm"  placeholder="Confirme la contraseña de usuario">
                            <div class="invalid-feedback">
                            La contraseña debe ser mayor de 8 digitos
                            </div>
                        </div>
                        <div class="form-group pt-3">
                            <a  id="btn_new_user" class="btn btn-block btn-yamevi_2">Agregar Usuario</a>
                            <a  id="btn_edit_user_d" class="btn btn-block btn-yamevi_2">Editar Usuario</a>
                            <div id="btn_load">
                                <div class=" btn_load btn_load_black btn-block mt-0" >
                                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                </div>                       
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal Error -->
    <div id="myModaldelete" data-backdrop="static" data-keyboard="false" class="modal fade">
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">
                <div class="modal-header justify-content-center" id="header_error">
                    <div class="icon-box">
                        <i class="material-icons">&#xef66;</i>
                    </div>
                    <button type="button" class="close" id="close_alert_edit" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body text-center">
                    <div class="form-group">
                        <input type="hidden" class="form-control form-control-sm" autocomplete="off" id="inp_id_user_delete"  placeholder="ID">
                    </div>
                    <h5 class="pt-1">¿Esta seguro que desea eliminar al usuario?</h5>	
                    <h4 class="text-danger" id="name_user_delete"></h4>
                    <button class="btn btn-success" id="delete_user" data-dismiss="modal" ><span>Eliminar</span> <i class="material-icons">&#xe14c;</i></button>
                </div>
            </div>
        </div>
    </div>   
</body>
    <?php include('include/footer_agencies.php')?>
    <?php include('include/scrips_agencies.php')?>
    <script src="../assets/js/users.js"></script>
</html>