
<?php
require_once '../config/conexion.php';
session_start();
$id_res = $_GET['reservation'];
$coinv = $_GET['coinv'];
$type_service_get = $_GET['typeser'];
$reedit = 0;
if($_GET['reedit']) {
  $reedit =  $_GET['reedit'];
}
if ($id_res) {
}else{                 
 header('location: index.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="../assets/img/icon/yamevIcon.png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if($reedit == 0 || $reedit == '' || $reedit != 1){?>
    <title>Detalles - <?php echo $coinv  ?></title>
    <?php } ?>    
    <?php if($reedit == 1){?>
    <title>Editar - <?php echo $coinv  ?></title>
    <?php } ?>
    <?php include('include/estilos_agencies.php')?>
</head>
<body id="body"> 
    <button  id="btnToTop" title="Go to top"><i class="fas fa-angle-up"></i></button> 
    <div class="backgound_img" data-background="../../assets/img/hero/h1_hero.jpg">
        <div class="content_home_0" data-background="../../assets/img/hero/h1_hero.jpg">
        <input type="hidden" class="" value="<?php echo $_SESSION['id_agency']?>" id="inp_agency"> 
        <input type="hidden" class="" value="<?php echo $_SESSION['todaysale']?>" id="inp_todaysale_edit"> 
            <?php 
                include('include/navigation_Agencies.php');
                include('../model/reservaciones.php');
                $reservas_model = new Reservation();
            ?>
        </div>
        <div class="container container_pages">
            <h4 class="">Reservación - <?php echo $coinv ?> </h4>
            <p class="mb-0"> <i class="fas fa-exclamation-triangle text-warning"></i>  Recordatorio, al realizar cambios de Hotel, Traslado, Servicio o N. pasajeros se reflejara el nuevo precio al guardar los datos.</p>
            <?php if($reedit == 1 || $reedit == '' || $reedit != 0) { 
                $details_reservation = json_decode($reservas_model->getDetailsReservation($id_res)); 
                $type_currency = $details_reservation->type_currency == 'mx' ? 'MXN' : 'USD';
                switch ($details_reservation->type_transfer) {
                    case 'RED':
                      $trasnfer = 'Redondo';
                      break;
                    case 'SEN/AH':
                      $trasnfer = 'Sencillo Aeropuerto > Hotel';
                      break;
                    case 'SEN/HA':
                      $trasnfer = 'Sencillo Hotel > Aeropuerto';
                      break;
                    case 'REDHH':
                      $trasnfer = 'Redondo - Hotel > Hotel';
                      break;
                    case 'SEN/HH':
                      $trasnfer = 'Sencillo - Hotel > Hotel';
                      break;
                }
                switch ($details_reservation->method_payment) {
                    case 'oxxo':
                      $newnamepay = "OXXO";
                      break;
                    case 'transfer':
                      $newnamepay = "TRANSFERENCIA";
                      break;
                    case 'airport':
                      $newnamepay = "AEROPUERTO";
                      break;
                    case 'paypal':
                      $newnamepay = "PAYPAL";
                      break;
                    case 'card':
                      $newnamepay = "TARJETA";
                      break;
                    case 'deposit':
                      $newnamepay = "DEPOSITO";
                      break;
                }
                // AGENCIAS YAMEVI
                if ($details_reservation->code_client) { $code_client = $details_reservation->code_client; }else{$code_client = "";}
                if ($details_reservation->name_advisor) { $name_advisor = $details_reservation->name_advisor; }else{$name_advisor = "";}
                if ($details_reservation->of_the_agency) { $of_the_agency = $details_reservation->of_the_agency; }else{$of_the_agency = "";}

                // DETALLES VUELO
                if ($details_reservation->transfer_destiny) { $transfer_destiny = $details_reservation->transfer_destiny; }else{$transfer_destiny = "";}
                if ($details_reservation->destiny_interhotel) { $destiny_interhotel = $details_reservation->destiny_interhotel; }else{$destiny_interhotel = "";}
                if ($details_reservation->type_transfer) { $type_transfer = $details_reservation->type_transfer; }else{$type_transfer = "";}
                if ($details_reservation->type_service) { $type_service = $details_reservation->type_service; }else{$type_service = "";}
                if ($details_reservation->airline_in) { $airline_in = $details_reservation->airline_in; }else{$airline_in = "";}
                if ($details_reservation->no_fly) { $no_fly = $details_reservation->no_fly; }else{$no_fly = "";}
                if ($details_reservation->airline_out) { $airline_out = $details_reservation->airline_out; }else{$airline_out = "";}
                if ($details_reservation->no_flyout) { $no_flyout = $details_reservation->no_flyout; }else{$no_flyout = "";}
                if ($details_reservation->date_arrival) { $date_arrival = $details_reservation->date_arrival; }else{$date_arrival = "";}
                if ($details_reservation->date_exit) { $date_exit = $details_reservation->date_exit; }else{$date_exit = "";}

                // PICKUP INTERHOTEL
                $arrivalTimeArgs = explode(' ', $details_reservation->time_arrival);
                $arrivalTimeArgs = explode(':', $arrivalTimeArgs[0]);

                $arrivalTimeArgs_ex = explode(' ', $details_reservation->time_exit);
                $arrivalTimeArgs_ex = explode(':', $arrivalTimeArgs_ex[0]);

                // DATOS DEL PAGO Y ESTADO
                if ($details_reservation->date_register_reservation) { $date_register_reservation = $details_reservation->date_register_reservation; }else{$date_register_reservation = "";}
                if ($details_reservation->status_reservation) { $status_reservation = $details_reservation->status_reservation; }else{$status_reservation = "";}
                if ($details_reservation->agency_commision) { $agency_commision = $details_reservation->agency_commision; }else{$agency_commision = 0;}
                if ($details_reservation->total_cost_commision) { $total_cost_commision = $details_reservation->total_cost_commision; }else{$total_cost_commision = 0;}
                if ($details_reservation->total_cost) { $total_cost = $details_reservation->total_cost; }else{$total_cost = 0;}
                if ($details_reservation->method_payment == 'card' || $details_reservation->method_payment == 'paypal') {
                    $new_total_cost_commision = $total_cost + $agency_commision;
                }else{
                    $new_total_cost_commision= $total_cost;
                }

                // DETALLES CLIENTE
                if ($details_reservation->name_client) { $name_client = $details_reservation->name_client; }else{$name_client = "";}
                if ($details_reservation->last_name) { $last_name = $details_reservation->last_name; }else{$last_name = "";}
                if ($details_reservation->phone_client) { $phone_client = $details_reservation->phone_client; }else{$phone_client = "";}
                if ($details_reservation->email_client) { $email_client = $details_reservation->email_client; }else{$email_client = "";}
                if ($details_reservation->country_client) { $country_client = $details_reservation->country_client; }else{$country_client = "";}
                if ($details_reservation->comments_client) { $comments_client = $details_reservation->comments_client; }else{$comments_client = "";}

            ?>       

                <!-- FORM FINAL DE DETALLES CLIENTE/VUELO -->
                <div class="container">
                    <div class=" d-flex justify-content-center">
                        <div class="alert alert-dismissible w-100" id="alert-msg">
                                <p style="margin-bottom: 0;">
                                    <input id="text-msg" type="text" class="sinbordefond w-100" value="">
                                </p>   
                                <button type="button" class="close" id="alert-close">&times;</button>  
                        </div>
                    </div>
                </div>
                <div class="container" id="content_edit_reserva">
                    <div class="row ">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <input type="hidden" name="" id="inp_code_invoice_edit" value="<?php echo $coinv  ?>">
                            <div class=" mb-3">
                                <?php if($_SESSION['internal_yt'] == 1) {
	                                $today = date('Y-m-d');
                                    $date_today = date_create($today);
                                    $date_exit = date_create($details_reservation->date_exit);
                                    $date_differences = date_diff($date_today, $date_exit);
                                    $date_arrival = date_create($details_reservation->date_arrival);
                                    $date_differences_arrival = date_diff($date_today, $date_arrival);
                                    if ($date_differences_arrival->days >= 2) {
                                        // echo 'LA FECHA ENTRADA SI ES MAYOR A 2 DIAS <br>';
                                    }else { 
                                       // echo 'LA FECHA ENTRADA NO ES MAYOR A 2 DIAS <br> ';
                                    }
                                    if ($date_differences->days >= 2) {
                                        // echo 'LA FECHA SALIDA SI ES MAYOR A 2 DIAS';
                                    }else {
                                        // echo 'LA FECHA SALIDA NO ES MAYOR A 2 DIAS';
                                    }
                                    ?>
                                    <input type="hidden" class="" value="<?php echo $_SESSION['internal_yt']?>" id="inp_internal_yt"> 
                                <div id="code_booking">
                                    <div class="d-flex justify-content-center row" >
                                        <div class="col-xl-12 col-md-12 pt-4 content_type_info">
                                            <h6>DATOS DE CODIGO DE RESERVA EXTERNA / (Solo Yamevi)</h6>
                                        </div>
                                        <div class="col-xl-12 pt-3">
                                            <div class="form-row">
                                                <div class="form-group col-md-3">
                                                    <label for="">Localizador</label>
                                                    <input type="text" class="form-control form-control-sm" id="inp_reserv_edit" placeholder="ID de reserva externa" value='<?php echo $code_client?>'>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="">Asesor</label>
                                                    <input type="text" class="form-control form-control-sm" id="inp_asesor_edit" placeholder="Nombre de Asesor de Venta" value='<?php echo $name_advisor ?>'>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="">De la Agencia</label>
                                                    <input list="agencies" name="agencies" id="inp_agency_edit" type="text" class="form-control form-control-sm w-100" placeholder="Selaña la agencia" value='<?php echo $of_the_agency ?>'>
                                                    <datalist id="agencies">
                                                        <?php
                                                        $query = "SELECT * FROM agencies";
                                                        $result = mysqli_query($con,$query);
                                                        if ($result) {
                                                            while($row = mysqli_fetch_array($result)){
                                                                echo '<option value = "'.$row['id_agency'].'"> '.$row['name_agency'].'</option>';
                                                            }
                                                            
                                                        }else{
                                                            echo '<option value="">No hay agencias registradas</option>';
                                                        }
                                                        ?>
                                                    </datalist>
                                                    <!-- <small id="name_agency" class="form-text text-muted">
                                                        En caso de que la reserva sea realizada para una agencia
                                                    </small> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="d-flex justify-content-center row">
                                    <div class="col-xl-12 col-md-12 content_type_info">
                                        <h6>DATOS DE TRASLADO</h6>
                                    </div>
                                    <div class="col-xl-12 col-md-12 pt-3">
                                        <div class="form_details">
                                            <div class="form-row">
                                                <div class="form-group col-md-3">
                                                    <label for="">Hotel</label>
                                                    <input list="encodings" id="inp_hotel_edit" name="inp_hotel_edit" placeholder="Ingresa el hotel" class="form-control form-control-sm" value='<?php echo $transfer_destiny ?>'>
                                                    <datalist id="encodings">
                                                        <?php
                                                            $query = "SELECT * FROM hotels";
                                                            $result = mysqli_query($con,$query);
                                                            if ($result) {
                                                                while($row = mysqli_fetch_array($result)){
                                                                    echo '<option  value = "'.$row['name_hotel'].'"> </option>';
                                                                }
                                                                
                                                            }else{
                                                                echo '<option value="">No hay zonas registradas</option>';
                                                            }
                                                        ?>
                                                    </datalist>   
                                                </div>
                                                <?php if ($type_service_get == 'REDHH' ) { ?>
                                                <div class="form-group col-md-3">
                                                    <label for="">Hotel Interhotel</label>
                                                    <input list="encodings" id="inp_hotel_interhotel_edit" name="inp_hotel_interhotel_edit" placeholder="Ingresa el hotel" class="form-control form-control-sm" value='<?php echo $destiny_interhotel ?>'>
                                                    <datalist id="encodings">
                                                        <?php
                                                            $query = "SELECT * FROM hotels";
                                                            $result = mysqli_query($con,$query);
                                                            if ($result) {
                                                                while($row = mysqli_fetch_array($result)){
                                                                    echo '<option  value = "'.$row['name_hotel'].'"> </option>';
                                                                }
                                                                
                                                            }else{
                                                                echo '<option value="">No hay zonas registradas</option>';
                                                            }
                                                        ?>
                                                    </datalist>   
                                                </div>
                                                <?php } ?>
                                                <div class="form-group col-md-3">
                                                    <label for="">Traslado</label>
                                                    <select class="custom-select custom-select-sm " id="inp_traslado_up" name="inp_traslado_edit" >
                                                        <option value="">Seleccione tipo de traslado</option>
                                                        <?php if($type_transfer == 'RED') { ?> <option value="RED" selected="selected">Redondo</option> <?php }else{ ?> <option value="RED">Redondo</option> <?php }?>
                                                        <?php if($type_transfer == 'SEN/AH') { ?> <option value="SEN/AH" selected="selected">Aeropuerto - Hotel</option> <?php }else{ ?> <option value="SEN/AH">Aeropuerto - Hotel</option> <?php }?>
                                                        <?php if($type_transfer == 'SEN/HA') { ?> <option value="SEN/HA" selected="selected">Hotel - Aeropuerto</option> <?php }else{ ?> <option value="SEN/HA">Hotel - Aeropuerto</option> <?php }?>
                                                        <?php if($type_transfer == 'REDHH') { ?> <option value="REDHH" selected="selected">Redondo / Hotel - Hotel</option> <?php }else{ ?> <option value="REDHH">Redondo / Hotel - Hotel</option> <?php }?>
                                                        <?php if($type_transfer == 'SEN/HH') { ?> <option value="SEN/HH" selected="selected">Sencillo / Hotel - Hotel</option> <?php }else{ ?> <option value="SEN/HH">Sencillo / Hotel - Hotel</option> <?php }?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="">Servicio</label>
                                                    <select class="custom-select custom-select-sm " id="inp_servicio_edit" name="inp_servicio_edit">
                                                        <option value="">Seleccione tipo de servicio</option>
                                                        <?php if($type_transfer == 'RED' || $type_transfer == 'SEN/AH' || $type_transfer == 'SEN/HA') { ?>
                                                        <?php if($type_service == 'compartido') { ?> <option value="compartido" selected="selected">Compartido</option> <?php }else{ ?> <option value="compartido">Compartido</option> <?php }?>
                                                        <?php } ?>
                                                        <?php if($type_service == 'privado') { ?> <option value="privado" selected="selected">Privado</option> <?php }else{ ?> <option value="privado">Privado</option> <?php }?>
                                                        <?php if($type_service == 'lujo') { ?> <option value="lujo" selected="selected">Lujo</option> <?php }else{ ?> <option value="lujo">Lujo</option> <?php }?>  
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-1">
                                                    <label for="">Pasajeros</label>
                                                    <select class="custom-select custom-select-sm" id="inp_pasajeros_edit" name="inp_pasajeros_edit" placeholder="Seleccione núm. de pasajeros">
                                                        <?php
                                                            for($valor = 0; $valor <= 16; $valor++) {
                                                                echo "<option value='$valor'";
                                                                if ($details_reservation->number_adults == $valor) { echo ' selected="selected"';}
                                                                echo ">$valor</option>";
                                                        }?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-md-12 pt-4 content_type_info">
                                        <h6>DATOS DE VUELO Y/O PICKUP</h6>
                                    </div>
                                    <div class="col-xl-12 col-md-12 pt-3">
                                        <div class="form_details">
                                            
                                            <?php if ($type_service_get == 'RED' || $type_service_get == 'SEN/AH') { ?>
                                            <div class="form-row" id="inps_entrada_edit">
                                                <div class="form-group col-md-3">
                                                    <label id="label_date_star" for="datepicker_star">Llegada</label>
                                                    <div class="input-group">
                                                        <input type="text" id="datepicker_star_edit" name="datepicker_star_edit" autocomplete="off" placeholder="Selecciona una fecha" class="form-control form-control-sm"  aria-describedby="date" value='<?= $details_reservation->date_arrival; ?>'>
                                                        <div class="input-group-append mr-2">
                                                            <span class="input-group-text" id="date"><i class="far fa-calendar-alt"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="">Aerolina Llegada</label>
                                                    <input type="text" class="form-control form-control-sm" id="inp_airline_entry_edit" placeholder="Nombre de aerolina" value='<?php echo $airline_in ?>'>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="">Número de Vuelo</label>
                                                    <input type="text" class="form-control form-control-sm" id="inp_nofly_entry_edit" placeholder="Número de vuelo" value='<?php echo $no_fly ?>'>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <div class="row">
                                                        <div class="col-md-12">                                            
                                                            <label for="">Hora de Llegada</label>
                                                        </div>
                                                        <div class="form-group col-md-4 pr-1">
                                                            <select class="form-control form-control-sm" id="inp_hour_entry_edit">
                                                                
                                                                <?php for($i = 1; $i < 24; $i++) { ?>
                                                                <option value="<?= $i < 10 ? '0'.$i : $i; ?>" <?php if($i == $arrivalTimeArgs[0]){ ?> selected="selected" <?php } ?> ><?= $i < 10 ? '0'.$i : $i; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-1 p-1 text-center">
                                                            <span>:</span>
                                                        </div>
                                                        <div class="form-group col-md-4 pl-1">
                                                            <select class="form-control form-control-sm" id="inp_minute_entry_edit">
                                                                <?php for($i = 0; $i < 60; $i++) { ?>
                                                                    <option value="<?= $i < 10 ? '0'.$i : $i; ?>" <?php if($i == $arrivalTimeArgs[1]){ ?> selected="selected" <?php } ?> ><?= $i < 10 ? '0'.$i : $i; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-1 p-1 text-center">
                                                            <span>Hrs</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            
                                            <?php if ($type_service_get == 'RED' || $type_service_get == 'SEN/HA') { ?>
                                            <div class="form-row" id="inps_salida_edit">
                                                <div class="form-group col-md-3">
                                                    <div class="form-group pb-2" id="content_date_end">
                                                        <label for="datepicker_end">Salida</label>
                                                        <div class="input-group">
                                                            <input type="text" id="datepicker_end_edit" name="datepicker_end_edit" autocomplete="off" placeholder="Selecciona una fecha" class="form-control form-control-sm" aria-describedby="date" value='<?= $details_reservation->date_exit; ?>'>
                                                            <div class="input-group-append mr-2">
                                                                <span class="input-group-text" id="date"><i class="far fa-calendar-minus"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="">Aerolina Salida</label>
                                                    <input type="text" class="form-control form-control-sm" id="inp_airline_exit_edit" placeholder="Nombre de aerolina" value='<?php echo $airline_out ?>'>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="">Número de Vuelo</label>
                                                    <input type="text" class="form-control form-control-sm" id="inp_nofly_exit_edit" placeholder="Número de vuelo" value='<?php echo $no_flyout ?>'>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <div class="row">
                                                        <div class="col-md-12">                                            
                                                            <label for="exampleFormControlSelect1">Hora de Salida</label>
                                                        </div>
                                                        <div class="form-group col-md-4 pr-1">
                                                            <select class="form-control form-control-sm" id="inp_hour_exit_edit">
                                                                <?php for($i = 1; $i < 24; $i++) { ?>
                                                                <option value="<?= $i < 10 ? '0'.$i : $i; ?>" <?php if($i == $arrivalTimeArgs_ex[0]){ ?> selected="selected" <?php } ?> ><?= $i < 10 ? '0'.$i : $i; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-1 p-1 text-center">
                                                            <span>:</span>
                                                        </div>
                                                        <div class="form-group col-md-4 pl-1">
                                                            <select class="form-control form-control-sm" id="inp_minute_exit_edit">
                                                                <?php for($i = 0; $i < 60; $i++) { ?>
                                                                    <option value="<?= $i < 10 ? '0'.$i : $i; ?>" <?php if($i == $arrivalTimeArgs_ex[1]){ ?> selected="selected" <?php } ?> ><?= $i < 10 ? '0'.$i : $i; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-1 p-1 text-center">
                                                            <span>Hrs</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>   
                                            <?php } ?>
                                            
                                            <?php if ($type_service_get == 'REDHH' || $type_service_get == 'SEN/HH') { ?>
                                            <div class="form-row" id="inp_pickup_edit">
                                                
                                                <?php if ($type_service_get == 'REDHH' || $type_service_get == 'SEN/HH') { ?>
                                                <div class="form-group col-md-3">
                                                    <label id="label_date_star" for="datepicker_star">Fecha de Servicio</label>
                                                    <div class="input-group">
                                                        <input type="text" id="datepicker_star_edit" name="datepicker_star_edit" autocomplete="off" placeholder="Selecciona una fecha" class="form-control form-control-sm"  aria-describedby="date" value='<?= $details_reservation->date_arrival; ?>'>
                                                        <div class="input-group-append mr-2">
                                                            <span class="input-group-text" id="date"><i class="far fa-calendar-alt"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3" id="inp_pickup_enter_edit">
                                                    <div class="row">
                                                        <div class="col-md-12">                                            
                                                            <label for="exampleFormControlSelect1">Hora de Pickup <small>(Ida)</small></label>
                                                        </div>
                                                        <div class="form-group col-md-4 pr-1">
                                                            <select class="form-control form-control-sm" id="inp_hour_pick_edit">
                                                                
                                                                <?php for($i = 1; $i < 24; $i++) { ?>
                                                                <option value="<?= $i < 10 ? '0'.$i : $i; ?>" <?php if($i == $arrivalTimeArgs[0]){ ?> selected="selected" <?php } ?> ><?= $i < 10 ? '0'.$i : $i; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-1 p-1 text-center">
                                                            <span>:</span>
                                                        </div>
                                                        <div class="form-group col-md-4 pl-1">
                                                            <select class="form-control form-control-sm" id="inp_minute_pick_edit">
                                                                <?php for($i = 0; $i < 60; $i++) { ?>
                                                                    <option value="<?= $i < 10 ? '0'.$i : $i; ?>" <?php if($i == $arrivalTimeArgs[1]){ ?> selected="selected" <?php } ?> ><?= $i < 10 ? '0'.$i : $i; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-1 p-1 text-center">
                                                            <span>Hrs</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                                
                                                <?php if ($type_service_get == 'REDHH') { ?>
                                                <div class="form-group col-md-3">
                                                    <div class="form-group pb-2" id="content_date_end">
                                                        <label for="datepicker_end">Salida</label>
                                                        <div class="input-group">
                                                            <input type="text" id="datepicker_end_edit" name="datepicker_end_edit" autocomplete="off" placeholder="Selecciona una fecha" class="form-control form-control-sm" aria-describedby="date" value='<?= $details_reservation->date_exit; ?>'>
                                                            <div class="input-group-append mr-2">
                                                                <span class="input-group-text" id="date"><i class="far fa-calendar-minus"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3" id="inp_pickup_exit_edit">
                                                    <div class="row">
                                                        <div class="col-md-12">                                            
                                                            <label for="exampleFormControlSelect1">Hora de Pickup <small>(Regreso)</small></label>
                                                        </div>
                                                        <div class="form-group col-md-4 pr-1">
                                                            <select class="form-control form-control-sm" id="inp_hour_pick_inter_edit">
                                                                
                                                                <?php for($i = 1; $i < 24; $i++) { ?>
                                                                <option value="<?= $i < 10 ? '0'.$i : $i; ?>" <?php if($i == $arrivalTimeArgs_ex[0]){ ?> selected="selected" <?php } ?> ><?= $i < 10 ? '0'.$i : $i; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-1 p-1 text-center">
                                                            <span>:</span>
                                                        </div>
                                                        <div class="form-group col-md-4 pl-1">
                                                            <select class="form-control form-control-sm" id="inp_minute_pick_inter_edit">
                                                                
                                                                <?php for($i = 0; $i < 60; $i++) { ?>
                                                                    <option value="<?= $i < 10 ? '0'.$i : $i; ?>" <?php if($i == $arrivalTimeArgs_ex[1]){ ?> selected="selected" <?php } ?> ><?= $i < 10 ? '0'.$i : $i; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-1 p-1 text-center">
                                                            <span>Hrs</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-xl-12 col-md-12 content_type_info">
                                        <h6>DATOS DE PAGO Y ESTADO</h6>
                                    </div>
                                    <div class="col-xl-12 col-md-12 pt-3">
                                        <div class="form_details">
                                            <div class="form-row">
                                                <div class="form-group col-md-2">
                                                    <label for="">Fecha de Reservación</label>
                                                    <input type="text" class="form-control form-control-sm" id="inp_date_register_res_edit" placeholder="Fecha de Registro de Reservación" value='<?php echo $date_register_reservation ?>' disabled>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="">Estado</label>
                                                    <input type="text" class="form-control form-control-sm" id="inp_status_reserva_edit" placeholder="Estado de la Reservación" value='<?php echo $status_reservation ?>' disabled>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="inputEmail4">Método de Pago</label>
                                                    <input type="text" class="form-control form-control-sm" id="inp_method_payment_edit" placeholder="Método de Pago" value='<?php echo $newnamepay ?>' disabled>
                                                </div>
                                                <?php if($details_reservation->method_payment == 'card' || $details_reservation->method_payment == 'paypal'){?>
                                                <div class="form-group col-md-2 pl-1">
                                                    <label for="">Subtotal</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control form-control-sm" id="inp_total_cost_edit" placeholder="Subtotal" value='<?php echo $total_cost ?>' disabled >
                                                        <div class="input-group-append mr-2">
                                                            <span class="input-group-text" id="currency"><small><?php echo $details_reservation->type_currency ?></small></span>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" class="form-control form-control-sm" id="inp_total_cost_b" placeholder="Subtota" value='<?php echo $total_cost ?>' disabled ><br>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="">Comisión</label>
                                                    <input type="text" class="form-control form-control-sm" id="inp_agency_commision_edit" placeholder="Comisión" value='<?php echo $agency_commision ?>' >
                                                </div>
                                                <?php } ?>
                                                <div class="form-group col-md-2 pl-1">
                                                    <label for="">Total</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control form-control-sm" id="inp_total_cost_commesion_edit" placeholder="Costo Total" value='<?php echo $new_total_cost_commision ?>' disabled >
                                                        <div class="input-group-append mr-2">
                                                            <span class="input-group-text" id="currency"><small><?php echo $details_reservation->type_currency ?></small></span>
                                                        </div>
                                                    </div>
                                                        <input type="hidden" class="form-control form-control-sm" id="inp_total_cost_commesion_b" placeholder="Costo Total" value='<?php echo $total_cost_commision ?>' disabled ><br>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-xl-12 col-md-12 content_type_info">
                                        <h6>DATOS DEL CLIENTE</h6>
                                    </div>
                                    <div class="col-xl-12 col-md-12 pt-3">
                                        <div class="form_details">
                                            <div class="form-row">
                                                <div class="form-group col-md-2">
                                                    <label for="">Nombre</label>
                                                    <input type="text" class="form-control form-control-sm" id="inp_name_client_edit" placeholder="Nombre del Cliente" value='<?php echo $name_client ?>' >
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="">Apellido Paterno</label>
                                                    <input type="text" class="form-control form-control-sm" id="inp_lastname_client_edit" placeholder="Apellido del Cliente" value='<?php echo $last_name ?>' >
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="inputEmail4">Correo Electronico</label>
                                                    <input type="email" class="form-control form-control-sm" id="inp_email_client_edit" placeholder="Email del Cliente" value='<?php echo $email_client ?>' >
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="">Teléfono Celular</label>
                                                    <input type="text" class="form-control form-control-sm" id="inp_phone_client_edit" placeholder="Teléfono del Cliente" value='<?php echo $phone_client ?>' >
                                                </div>
                                                <div class="form-group col-md-2 pl-1">
                                                    <label for="">País</label>
                                                    <input type="text" class="form-control form-control-sm" id="inp_country_client_edit" placeholder="País del Cliente" value='<?php echo $country_client ?>' disabled >
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="">Peticiones Especiales</label>
                                                    <textarea name="" class="form-control form-control-sm" id="inp_special_requests_edit" rows="3" ><?php echo $comments_client ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <a href="#" class="btn btn-yamevi btn-block" id="update_details_reservation">G U A R D A R</a>
                        </div>
                        <!-- <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 pt-4 pr-1 pl-1">
                            <div class="card content_resumen">
                                <div class="card-header text-center">
                                    <h4>R E S U M E N</h4>
                                </div>
                                <div class="card-body pt-2">
                                    <div class="line_resumen">
                                        <small>Traslado: </small><br>
                                        <span id="traslado_resumen"></span>
                                    </div>
                                    <div class="line_resumen">
                                        <small>Servicios: </small><br>
                                        <span id="servicio_resumen"></span>
                                    </div>
                                    <div class="line_resumen">
                                        <small>Hotel: </small><br>
                                        <span id="h_origen_resumen"></span>
                                    </div>
                                    <div class="line_resumen content_h_destino">
                                        <small>Hotel Destino: </small><br>
                                        <span id="h_destino_resumen"></span>
                                    </div>
                                    <div class="line_resumen">
                                        <small>Pajeros: </small><br>
                                        <span id="pasajeros_resumen"></span>
                                    </div>
                                    <div class="line_resumen">
                                        <small>Método de Pago: </small>
                                        <span>
                                            <select class="form-control form-control-sm info_payment p-0" id="mpago_resumen">
                                                <option id="option_card"  value="card">Tarjeta Crédito/Débito</option>
                                                <option value="transfer">Transferencia</option>
                                                <option id="option_paypal" value="paypal">Paypal</option>
                                                <option id="option_cash" value="airport">Pago al abordar</option>
                                            </select>
                                        </span>
                                    </div>
                                    <div class="line_resumen content_cservicio">
                                        <small>Cargo Por Servicio: </small>
                                        <span><input type="text" class="form-control form-control-sm info_service_charge" placeholder="0.00" id="cservicio_resumen"></span>
                                    </div>
                                    <div class="line_resumen content_descuento">
                                        <small>Descuento: </small>
                                        <span><input type="text" class="form-control form-control-sm info_discount" id="descuento_resumen" placeholder="0.00" disabled></span>
                                    </div>
                                    <div class="line_resumen">
                                        <small>Idioma de ticket: </small>
                                        <span><select class="form-control form-control-sm info_payment p-0" id="idioma_resumen">
                                                    <option value="">Elige el idioma del ticket</option>
                                                    <option value="mx">Español</option>
                                                    <option value="us">Ingles</option>
                                                    <option value="pt">Portugués</option>
                                        </select></span>
                                    </div>
                                    <div class="line_resumen">
                                        <div class="row ">
                                            <div class="col-md-2 pl-0">                                
                                                <small>Total: </small>
                                            </div>
                                            <div class="col-md-6 text-right pr-0">
                                                <h2 id="info_import" data-ratemx="00" data-rateus="00" data-ratemx_c="00" data-rateus_c="00" data-discountmx="00" data-discountus="00"></h2>
                                            </div>
                                            <div class="col-md-4 text-right pl-1 pr-0">
                                                <select class="form-control" id="select_type_change">
                                                        <option value="mxn">MXN</option>
                                                        <option value="usd">USD</option>
                                                </select>
                                                <input type="hidden" name="inp_amount_total_mxn" id="inp_amount_total_mxn">
                                                <input type="hidden" name="inp_amount_total_usd" id="inp_amount_total_usd">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pt-3 " id="content_terms_conditions">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" class="custom-control-input" id="check_terminos" required>
                                            <label class="custom-control-label" for="check_terminos">Acepto los<a target="_blank" href="https://www.yamevitravel.com/terminos-y-condiciones/" >Términos y Condiciones</a></label>
                                            <div class="invalid-feedback d-none"><small>Debes aceptar los términos y condiciones para continuar.</small></div>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn_animation_2 btn pt-2 pb-2  btn-sm btn-block btn-yamevi_2 h-100"  id="finish_reserv"><span>Reservar </span></button>
                                        
                                        <div class="btn_load btn_load_black btn-block">
                                            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <br>
                    </div>
                </div>
            <?php } ?>
        </div>
     </div>
</body>
    <?php include('include/footer_agencies.php')?>
    <?php include('include/scrips_agencies.php')?>
</html>