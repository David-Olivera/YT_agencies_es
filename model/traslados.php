<?php
    class Transfer{
        
        function create_reserva($obj){
            session_start();
            include('../config/conexion.php');
            $ins = json_decode($obj);
            $id_agencie = mysqli_real_escape_string($con,$ins->{'id_agencie'});
            $code_reserv = mysqli_real_escape_string($con,$ins->{'code_reserv'});
            $of_the_agency = mysqli_real_escape_string($con, $ins->{'of_the_agency'});
            $name_advisor = mysqli_real_escape_string($con,$ins->{'name_advisor'});
            $name_client = mysqli_real_escape_string($con,$ins->{'name_client'});
            $lastname_client = mysqli_real_escape_string($con,$ins->{'lastname_client'});
            $email_client = mysqli_real_escape_string($con, $ins->{'email_client'});
            $phone_client = mysqli_real_escape_string($con, $ins->{'phone_client'});
            $country = mysqli_real_escape_string($con,$ins->{'country'});
            $special_requests = mysqli_real_escape_string($con,$ins->{'special_requests'});
            $hotel_origin = mysqli_real_escape_string($con,$ins->{'hotel_origin'});
            $hotel_destiny = mysqli_real_escape_string($con,$ins->{'hotel_destiny'});
            $type_transfer = mysqli_real_escape_string($con,$ins->{'type_transfer'});
            $type_service = mysqli_real_escape_string($con, $ins->{'type_service'});
            $pasajeros = mysqli_real_escape_string($con,$ins->{'pasajeros'});
            $time_entry = mysqli_real_escape_string($con,$ins->{'time_entry'});
            $airline_entry  = mysqli_real_escape_string($con,$ins->{'airline_entry'});
            $nofly_entry = mysqli_real_escape_string($con,$ins->{'nofly_entry'});
            $time_exit = mysqli_real_escape_string($con,$ins->{'time_exit'});
            $pick_up = mysqli_real_escape_string($con,$ins->{'pick_up'});
            $pick_up_inter  = mysqli_real_escape_string($con,$ins->{'pick_up_inter'});
            $airline_exit = mysqli_real_escape_string($con,$ins->{'airline_exit'});
            $nofly_exit = mysqli_real_escape_string($con,$ins->{'nofly_exit'});
            $currency = mysqli_real_escape_string($con,$ins->{'currency'});
            $type_change = mysqli_real_escape_string($con,$ins->{'type_change'});
            $method_peyment = mysqli_real_escape_string($con,$ins->{'method_peyment'});
            $total_mxn = mysqli_real_escape_string($con,$ins->{'total_mxn'});
            $total_usd = mysqli_real_escape_string($con,$ins->{'total_usd'});
            $service_charge = mysqli_real_escape_string($con,$ins->{'service_charge'});
            $amount_total = mysqli_real_escape_string($con,$ins->{'amount_total'});
            $letter_lang = mysqli_real_escape_string($con,$ins->{'letter_lang'});
            $status = mysqli_real_escape_string($con,$ins->{'status'});
            $date_entry = mysqli_real_escape_string($con,$ins->{'date_entry'});
            $date_exit = mysqli_real_escape_string($con,$ins->{'date_exit'});
            $new_time_en = "";
            $new_time_ex = "";
            $new_date_en = "";
            $new_date_ex = "";
            $type_currency ="";
            //Generador de codigo
            $caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
            srand((double)microtime()*1000000);
            $rand = '';
            for($i = 0; $i < 10; $i++) {
                $rand .= $caracteres[rand()%strlen($caracteres)];
            }
            $code_invoice = 'Y'.$rand.'T';
            $new_total_cost = "";
            if ($type_service == 'SEN/HA' ) {
                $new_time_en = $time_entry;
                $new_time_ex = $time_exit;
                $new_date_ex = $date_entry;
                $new_date_en = "";

            }
            
            if ($type_service == 'RED') {
                $new_date_en = $date_entry;
                $new_date_ex = $date_exit;
                $new_time_en = $time_entry;
                $new_time_ex = $time_exit;

            }
            if ($type_service == 'SEN/AH' ) {
                $new_time_en = $time_entry;
                $new_time_ex = $time_exit;
                $new_date_ex = "";
                $new_date_en = $date_entry;
            }
            if ($type_service == 'SEN/HH' ) {
                $new_time_en = $pick_up;
                $new_time_ex = $pick_up_inter;
                $new_date_ex = "";
                $new_date_en = $date_entry;
            }
            if ($type_service == 'REDHH') {
                $new_time_en = $pick_up;
                $new_time_ex = $pick_up_inter;
                $new_date_ex = $date_exit;
                $new_date_en = $date_entry;

            }
            if ($currency == 'MXN') {
                $type_currency = 'mx';
            }else{
                $type_currency = 'us';
            }
            //Insertamos datos Reserva
            $id_agency = $_SESSION['id_agency'];
			date_default_timezone_set('America/Cancun');
			$today = date('Y-m-d');
            $state = "COMPLETED";
            if ($method_peyment == "transfer" || $method_peyment == "card" || $method_peyment == "paypal" || $method_peyment == "oxxo") {
                $state = "RESERVED";
            }
            //Insertamos datos Clientes
            $query_client = "INSERT INTO clients(code_client,name_advisor,name_client,last_name,email_client,phone_client,comments_client,country_client)VALUES('$code_reserv','$name_advisor','$name_client','$lastname_client','$email_client','$phone_client','$special_requests','$country');";
            $result_client = mysqli_query($con, $query_client);
            $id_client = mysqli_insert_id($con);
            //Insertamos datos Reserva
            $query_reserva = "INSERT INTO reservations(type_transfer, airline_in, no_fly, airline_out, no_flyout, code_invoice, status_reservation, date_register_reservation, transfer_destiny,destiny_interhotel, id_client,id_agency,of_the_agency,type_language)
            VALUES('$type_service', '$airline_entry', '$nofly_entry', '$airline_exit', '$nofly_exit','$code_invoice', '$state','$today','$hotel_origin','$hotel_destiny',$id_client,$id_agency,$of_the_agency,'$letter_lang');";
            $result_reserv = mysqli_query($con, $query_reserva);
            $id_reserva = mysqli_insert_id($con);
            //Insertamos datos Detalles Reserva
            $query_detalles = "INSERT INTO reservation_details(id_reservation, date_arrival,date_exit, time_arrival, time_exit, number_adults, agency_commision, total_cost_commision, total_cost, type_currency, change_type, type_service, method_payment, pickup_entry,pickup)
            VALUES($id_reserva, '$new_date_en', '$new_date_ex', '$new_time_en', '$new_time_ex', $pasajeros,'$service_charge', $amount_total, $total_mxn, '$type_currency', $type_change, '$type_transfer','$method_peyment', '$pick_up', '$pick_up_inter');";
            $result_detalles = mysqli_query($con, $query_detalles);
            //Insertamos datos Conciliacion
            $query_concilia = "INSERT INTO conciliation(id_reservation, id_agency, register_date) VALUES($id_reserva, $id_agency, '$today');";
            $result_concilia = mysqli_query($con, $query_concilia);
            //Diseño de carta de confirmacion
            if ($result_reserv && $result_detalles && $result_concilia && $result_client) {
                $letter = $this->createLetterConfirm($id_reserva,$letter_lang,$con, $ticket ="", $total="");
                return $letter;
            }else{
                $error = '0';
                return $error;
            }
        }

        public function search_traslado($obj){
            $ins = json_decode($obj);
            include('../config/conexion.php');
            $hotel = mysqli_real_escape_string($con,$ins->{'hotel'});
            $pasajeros = $ins->{'pasajeros'};
            $traslados = $ins->{'traslado'};
            $f_llegada = $ins->{'date_star'};
            $f_salida = $ins->{'date_end'};
            $rate_service_shared = '';
            $rate_service_private = '';
            $rate_service_luxury = '';

            //Validamos si es Inter Hotel
            if ($traslados == 'REDHH' || $traslados == 'SEN/HH') {
                return $this->getServiceListHotelHotel($ins, $con);
                exit;
            }
            //Verificamos existencia de hotel
            if ($this->verifyDestionation($ins->{'hotel'}, $con) == false) {
                return NULL;
                exit;
            }
            //Obetnemos el tipo de moneda
            $moneda = $this->getDivisa('mxn', $con);
           
            //Verificacion de tipo de servicio de traslado
            switch ($ins->{'traslado'}) {
                case 'RED':
                    $name_traslado = 'Redondo';
                    break;
        
                case 'SEN/AH':
                    $name_traslado = 'Aeropuerto - Hotel';
                    break;
         
                case 'SEN/HA':
                    $name_traslado = 'Hotel - Aeropuerto';
                    break;
             
                case 'REDHH':
                    $name_traslado = 'Redondo / Hotel - Hotel';
                    break;
            
                case 'SEN/HH':
                    $name_traslado = 'Sencillo / Hotel - Hotel';
                    break;
           }

           //Obtenemos zona de destino
           $zona = json_decode($this->getAreaDestination($ins->{'hotel'}, $con));
            
           //Obtenemos la tarifa de la zona
           $rates = json_decode($this->getRateArea($zona->{'id_zone'}, $con));  

           //Compartido
           if (intval($rates[0]->{'shared'}->{'oneway'}) > 0 && $rates[0]->{'shared'}->{'oneway'} != NULL ) {
               
               $rates_shared_rt =  "";
               $rates_shared_ow =  "";
               $div_prices_shared = "";
               if ($traslados == 'RED') {
                    $rates_shared_ow = $rates[0]->{'shared'}->{'oneway'};
                    $rates_shared_rt = $rates[0]->{'shared'}->{'roundtrip'};
                    $rate_service_rt = $rates_shared_rt * $pasajeros;
                    $rate_service_ow = $rates_shared_ow * $pasajeros;
                    $div_prices_shared = '
                        <div class="row mt-2 content_prices_results">
                            <div class="col-xl-6 col-md-12 ">
                                <i class="fal fa-circle"></i>
                                <h5>SENCILLO</h5>
                                <h5 class="mt-1"><strong>$'.round($rate_service_ow, 2).' MXN</strong></h5>
                                <small>$'.round($rate_service_ow / $moneda,0).' USD</small>
                            </div>
                            <div class="col-xl-6 col-md-12">
                                <i class="fas fa-check-square active"></i>
                                <h5>REDONDO</h5>
                                <h5 class="mt-1" id="rate_service"  ><strong>$'.round($rate_service_rt, 2).' MXN</strong></h5>
                                <small>$'.round($rate_service_rt / $moneda,0).' USD</small>
                            </div>
                        </div>
                    ';
               }else{
                    $rates_shared_ow = $rates[0]->{'shared'}->{'oneway'};
                    $rates_shared_rt = $rates[0]->{'shared'}->{'roundtrip'};
                    $rate_service_rt = $rates_shared_rt * $pasajeros;
                    $rate_service_ow = $rates_shared_ow * $pasajeros;
                    $div_prices_shared = '
                        <div class="row mt-2 content_prices_results">
                            <div class="col-xl-6 col-md-12">
                                <i class="fas fa-check-square active"></i>
                                <h5>SENCILLO</h5>
                                <h5 class="mt-1" id="rate_service"  ><strong>$'.round($rate_service_ow, 2).' MXN</strong></h5>
                                <small>$'.round($rate_service_ow / $moneda,0).' USD</small>
                            </div>
                            <div class="col-xl-6 col-md-12 ">
                                <i class="fal fa-circle"></i>
                                <h5>REDONDO</h5>
                                <h5 class="mt-1"><strong>$'.round($rate_service_rt, 2).' MXN</strong></h5>
                                <small>$'.round($rate_service_rt / $moneda,0).' USD</small>
                            </div>
                        </div>
                    ';
               }
               $rate_service_shared = '               
                    <div class="row mb-3 mt-3 p-2 bg-white border rounded">
                        <div class="col-md-3 mt-1 text-center content_card_result_center" >
                            <div>
                                <img class="img-fluid img-responsive rounded product-image" src="../assets/img/traslados/priv_com.png">
                                <br><br>
                                <h5 style="text-transform: uppercase;">SERVICIO <span>COMPARTIDO</span></h5>
                            </div>
                        </div>
                        <div class="xol-xl-6 col-md-6 mt-1 mb-1 content_rules_card_result">
                            <p><small>El servicio compartido es por pasajero.</small></p>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Incluye todos los impuestos y tasas aeroportuarias.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Seguro de viajero.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Recepción por uno de nuestros representantes.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Servicio a la mayoría de los hoteles.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> El servicio compartido sale de forma continua desde el aeropuerto. </span></div>
                        </div>
                        <div class="col-xl-3 col-md-3 border-left mt-1 ">
                            <div class="w-100 text-center">
                                <div class=" text-center align-items-center">
                                    <small id="name_hotel"><strong>'.$hotel.'</strong></small><br>
                                    <small id="name_traslado">'.$name_traslado.'</small><br>
                                    <small id="name_pasajeros">Pasajeros: '.$pasajeros.'</small><br>
                                </div>
                                '.$div_prices_shared.'
                                <div class="d-flex flex-column mt-4 mb-3">
                                    <button type="submit" class="btn_animation_2 btn btn-block btn-yamevi" data-tchange="'.$moneda.'" data-fllegada="'.$f_llegada.'" data-fsalida="'.$f_salida.'"  id="init_reserva" data-service ="Shared" data-pasajeros="'.$pasajeros.'" data-type="compartido" data-rate-ow="'.round($rate_service_ow,2).'"  data-rateus-ow = "'.round($rate_service_ow / $moneda,0).'" data-rate-rt="'.round($rate_service_rt,2).'"  data-rateus-rt = "'.round($rate_service_rt / $moneda,0).'"><span>Reservar </span></button>
                                </div>
                            </div>
                        </div>
                    </div>
               ';
           }else{
            $rate_service_shared = '               
                    <div class="row mb-3 mt-3 p-2 bg-white border rounded">
                        <div class="col-md-3 mt-1 text-center content_card_result_center" >
                            <div>
                                <img class="img-fluid img-responsive rounded product-image" src="../assets/img/traslados/priv_com.png">
                                <br><br>
                                <h5 style="text-transform: uppercase;">SERVICIO <span>PRIVADO</span></h5>
                            </div>
                        </div>
                        <div class="xol-xl-6 col-md-6 mt-1 mb-1 content_rules_card_result">
                            <p><small>El servicio privado es por van, NO por pasajero. Servicio disponible 24/7</small></p>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Precio por Vehículo</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Incluye todos los impuestos y tasas aeroportuarias.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Seguro de viajero.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Recepción por uno de nuestros representantes.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> 24 Horas de servicio.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Servicio puerta a puerta en Cancun & Riviera Maya.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Vehículo privado – NO COMPARTIDO.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Vehículo espacioso para los pasajeros y el equipaje.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Un asiento de seguridad para niños incluido - Cuando lo solicite.</span></div>
                        </div>
                        <div class="col-xl-3 col-md-3 border-left mt-1 ">
                            <div class="w-100 text-center">
                                <div class=" text-center align-items-center">
                                    <small class="name_hotel"><strong>'.$hotel.'</strong></small><br>
                                    <small class="name_traslado">'.$name_traslado.'</small><br>
                                    <small class="name_pasajeros">Pasajeros: '.$pasajeros.'</small><br>
                                </div>
                                <div class="row mt-2 content_prices_results">
                                    <div class="col-xl-6 col-md-12 ">
                                        <i class="fal fa-circle"></i>
                                        <h5>SENCILLO</h5>
                                        <h5 class="mt-1"><strong>---</strong></h5>
                                    </div>
                                    <div class="col-xl-6 col-md-12">
                                        <i class="fal fa-circle"></i>
                                        <h5>REDONDO</h5>
                                        <h5 class="mt-1"><strong>---</strong></h5>
                                    </div>
                                </div>
                                <div class="d-flex flex-column mt-4">
                                    <p  class="text_not_available">NO DISPONIBLE</p>
                                </div>
                            </div>
                        </div>
                    </div>              
            ';
           }

           //Privado
           if (intval($rates[0]->{'private'}->{'privado_ow_1'}) > 0 && $rates[0]->{'private'}->{'privado_ow_1'} != NULL) {
               $rates_private_ow = "";
               $rates_private_rt = "";
               $div_prices_private = "";
               if ($pasajeros >=1 && $pasajeros <=4) {
                    $rates_private_ow = $rates[0]->{'private'}->{'privado_ow_1'} ;
                    $rates_private_rt = $rates[0]->{'private'}->{'privado_rt_1'};
               }
               if ($pasajeros >=5 && $pasajeros <=6) {
                    $rates_private_ow = $rates[0]->{'private'}->{'privado_ow_2'} ;
                    $rates_private_rt = $rates[0]->{'private'}->{'privado_rt_2'};
               }
               if ($pasajeros >=7 && $pasajeros <=8) {
                    $rates_private_ow = $rates[0]->{'private'}->{'privado_ow_3'} ;
                    $rates_private_rt = $rates[0]->{'private'}->{'privado_rt_3'};
               }
               if ($pasajeros >=9 && $pasajeros <=10) {
                    $rates_private_ow = $rates[0]->{'private'}->{'privado_ow_4'} ;
                    $rates_private_rt = $rates[0]->{'private'}->{'privado_rt_4'};
               }
               if ($pasajeros >10 && $pasajeros <=11) {
                    $rates_private_ow = $rates[0]->{'private'}->{'privado_ow_5'} ;
                    $rates_private_rt = $rates[0]->{'private'}->{'privado_rt_5'};
               }
               if ($pasajeros >=12 && $pasajeros <=16) {
                    $rates_private_ow = $rates[0]->{'private'}->{'privado_ow_6'} ;
                    $rates_private_rt = $rates[0]->{'private'}->{'privado_rt_6'};
               }
               if ($traslados == 'RED') {
                    $div_prices_private = '
                        <div class="row mt-2 content_prices_results">
                            <div class="col-xl-6 col-md-12 ">
                                <i class="fal fa-circle"></i>
                                <h5>SENCILLO</h5>
                                <h5 class="mt-1"><strong>$'.round($rates_private_ow, 2).' MXN</strong></h5>
                                <small>$'.round($rates_private_ow / $moneda,0).' USD</small>
                            </div>
                            <div class="col-xl-6 col-md-12">
                                <i class="fas fa-check-square active"></i>
                                <h5>REDONDO</h5>
                                <h5 class="mt-1" id="rate_service"  ><strong>$'.round($rates_private_rt, 2).' MXN</strong></h5>
                                <small>$'.round($rates_private_rt / $moneda,0).' USD</small>
                            </div>
                        </div>
                    ';
               }else{
                    $div_prices_private = '
                        <div class="row mt-2 content_prices_results">
                            <div class="col-xl-6 col-md-12">
                                <i class="fas fa-check-square active"></i>
                                <h5>SENCILLO</h5>
                                <h5 class="mt-1" id="rate_service"  ><strong>$'.round($rates_private_ow, 2).' MXN</strong></h5>
                                <small>$'.round($rates_private_ow / $moneda,0).' USD</small>
                            </div>
                            <div class="col-xl-6 col-md-12 ">
                                <i class="fal fa-circle"></i>
                                <h5>REDONDO</h5>
                                <h5 class="mt-1"><strong>$'.round($rates_private_rt, 2).' MXN</strong></h5>
                                <small>$'.round($rates_private_rt / $moneda,0).' USD</small>
                            </div>
                        </div>
                    ';
               }
               $rate_service_private = '               
                    <div class="row mb-3 mt-3 p-2 bg-white border rounded">
                        <div class="col-md-3 mt-1 text-center content_card_result_center" >
                            <div>
                                <img class="img-fluid img-responsive rounded product-image" src="../assets/img/traslados/priv_com.png">
                                <br><br>
                                <h5 style="text-transform: uppercase;">SERVICIO <span>PRIVADO</span></h5>
                                <input type="hidden" id="input_type_service" value="Private"></input>
                            </div>
                        </div>
                        <div class="xol-xl-6 col-md-6 mt-1 mb-1 content_rules_card_result">
                            <p><small>El servicio privado es por van, NO por pasajero. Servicio disponible 24/7</small></p>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Precio por Vehículo</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Incluye todos los impuestos y tasas aeroportuarias.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Seguro de viajero.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Recepción por uno de nuestros representantes.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> 24 Horas de servicio.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Servicio puerta a puerta en Cancun & Riviera Maya.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Vehículo privado – NO COMPARTIDO.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Vehículo espacioso para los pasajeros y el equipaje.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Un asiento de seguridad para niños incluido - Cuando lo solicite.</span></div>
                        </div>
                        <div class="col-xl-3 col-md-3 border-left mt-1 ">
                            <div class="w-100 text-center">
                                <div class=" text-center align-items-center">
                                    <small id="name_hotel"><strong>'.$hotel.'</strong></small><br>
                                    <small id="name_traslado">'.$name_traslado.'</small><br>
                                    <small id="name_pasajeros">Pasajeros: '.$pasajeros.'</small><br>
                                </div>
                                '.$div_prices_private.'
                                <div class="d-flex flex-column mt-4">
                                    <button type="submit" class="btn_animation_2 btn btn-block btn-yamevi" data-tchange="'.$moneda.'" data-fllegada="'.$f_llegada.'" data-fsalida="'.$f_salida.'" data-type="privado" data-pasajeros="'.$pasajeros.'" data-rate-ow="'.round($rates_private_ow,2).'"  data-rateus-ow= "'.round($rates_private_ow / $moneda,0).'" data-rate-rt="'.round($rates_private_rt,2).'"  data-rateus-rt= "'.round($rates_private_rt / $moneda,0).'" id="init_reserva"><span>Reservar </span></button>
                                </div>
                            </div>
                        </div>
                    </div>
               ';
           }else{
                $rate_service_private = '               
                        <div class="row mb-3 mt-3 p-2 bg-white border rounded">
                            <div class="col-md-3 mt-1 text-center content_card_result_center" >
                                <div>
                                    <img class="img-fluid img-responsive rounded product-image" src="../assets/img/traslados/priv_com.png">
                                    <br><br>
                                    <h5 style="text-transform: uppercase;">SERVICIO <span>PRIVADO</span></h5>
                                </div>
                            </div>
                            <div class="xol-xl-6 col-md-6 mt-1 mb-1 content_rules_card_result">
                                <p><small>El servicio privado es por van, NO por pasajero. Servicio disponible 24/7</small></p>
                                <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Precio por Vehículo</span></div>
                                <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Incluye todos los impuestos y tasas aeroportuarias.</span></div>
                                <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Seguro de viajero.</span></div>
                                <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Recepción por uno de nuestros representantes.</span></div>
                                <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> 24 Horas de servicio.</span></div>
                                <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Servicio puerta a puerta en Cancun & Riviera Maya.</span></div>
                                <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Vehículo privado – NO COMPARTIDO.</span></div>
                                <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Vehículo espacioso para los pasajeros y el equipaje.</span></div>
                                <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Un asiento de seguridad para niños incluido - Cuando lo solicite.</span></div>
                            </div>
                            <div class="col-xl-3 col-md-3 border-left mt-1 ">
                                <div class="w-100 text-center">
                                    <div class=" text-center align-items-center">
                                        <small class="name_hotel"><strong>'.$hotel.'</strong></small><br>
                                        <small class="name_traslado">'.$name_traslado.'</small><br>
                                        <small class="name_pasajeros">Pasajeros: '.$pasajeros.'</small><br>
                                    </div>
                                    <div class="row mt-2 content_prices_results">
                                        <div class="col-xl-6 col-md-12 ">
                                            <i class="fal fa-circle"></i>
                                            <h5>SENCILLO</h5>
                                            <h5 class="mt-1"><strong>---</strong></h5>
                                        </div>
                                        <div class="col-xl-6 col-md-12">
                                            <i class="fal fa-circle"></i>
                                            <h5>REDONDO</h5>
                                            <h5 class="mt-1" ><strong>---</strong></h5>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column mt-4">
                                        <p  class="text_not_available">NO DISPONIBLE</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                ';
           }

           //Lujo
           if (intval($rates[0]->{'luxury'}->{'lujo_ow_1'}) > 0 && $rates[0]->{'luxury'}->{'lujo_ow_1'} != NULL && $pasajeros <=6) {
                $rates_luxury_ow = "";
                $rates_luxury_rt = "";
                $div_prices_luxury = "";
                if ($pasajeros >=1 && $pasajeros <=6) {
                    $rates_luxury_ow = $rates[0]->{'luxury'}->{'lujo_ow_1'} ;
                    $rates_luxury_rt = $rates[0]->{'luxury'}->{'lujo_rt_1'};
                }
                if ($traslados == 'RED') {
                    $div_prices_luxury = '
                        <div class="row mt-2 content_prices_results">
                            <div class="col-xl-6 col-md-12 ">
                                <i class="fal fa-circle"></i>
                                <h5>SENCILLO</h5>
                                <h5 class="mt-1"><strong>$'.round($rates_luxury_ow, 2).' MXN</strong></h5>
                                <small>$'.round($rates_luxury_ow / $moneda,0).' USD</small>
                            </div>
                            <div class="col-xl-6 col-md-12">
                                <i class="fas fa-check-square active"></i>
                                <h5>REDONDO</h5>
                                <h5 class="mt-1" id="rate_service" ><strong>$'.round($rates_luxury_rt, 2).' MXN</strong></h5>
                                <small>$'.round($rates_luxury_rt / $moneda,0).' USD</small>
                            </div>
                        </div>
                    ';
               }else{
                    $div_prices_luxury = '
                        <div class="row mt-2 content_prices_results">
                            <div class="col-xl-6 col-md-12">
                                <i class="fas fa-check-square active"></i>
                                <h5>SENCILLO</h5>
                                <h5 class="mt-1" id="rate_service" ><strong>$'.round($rates_luxury_ow, 2).' MXN</strong></h5>
                                <small>$'.round($rates_luxury_ow / $moneda,0).' USD</small>
                            </div>
                            <div class="col-xl-6 col-md-12 ">
                                <i class="fal fa-circle"></i>
                                <h5>REDONDO</h5>
                                <h5 class="mt-1"><strong>$'.round($rates_luxury_rt, 2).' MXN</strong></h5>
                                <small>$'.round($rates_luxury_rt / $moneda,0).' USD</small>
                            </div>
                        </div>
                    ';
               }
               $rate_service_luxury = '               
                    <div class="row mb-3 mt-3 p-2 bg-white border rounded">
                        <div class="col-md-3 mt-1 text-center content_card_result_center" >
                            <div>
                                <img class="img-fluid img-responsive rounded product-image" src="../assets/img/traslados/lujo.png">
                                <br><br>
                                <h5 style="text-transform: uppercase;">SERVICIO <span>LUJO</span></h5>
                                <input type="hidden" id="input_type_service" value="Luxury"></input>
                            </div>
                        </div>
                        <div class="xol-xl-6 col-md-6 mt-1 mb-1 content_rules_card_result">
                            <p><small>El servicio de lujo es por van, NO por pasajero. Servicio disponible 24/7</small></p>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Precio por Vehículo</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Incluye todos los impuestos y tasas aeroportuarias.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Seguro de viajero.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Recepción por uno de nuestros representantes.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> 24 Horas de servicio.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Servicio puerta a puerta en Cancun & Riviera Maya.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Vehículo privado – NO COMPARTIDO.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Vehículo espacioso para los pasajeros y el equipaje.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Un asiento de seguridad para niños incluido - Cuando lo solicite.</span></div>
                        </div>
                        <div class="col-xl-3 col-md-3 border-left mt-1 ">
                            <div class="w-100 text-center">
                                <div class=" text-center align-items-center">
                                    <small id="name_hotel"><strong>'.$hotel.'</strong></small><br>
                                    <small id="name_traslado">'.$name_traslado.'</small><br>
                                    <small id="name_pasajeros">Pasajeros: '.$pasajeros.'</small><br>
                                </div>
                                '.$div_prices_luxury.'
                                <div class="d-flex flex-column mt-4">
                                    <button type="submit" class="btn_animation_2 btn btn-block btn-yamevi" data-tchange="'.$moneda.'" data-fllegada="'.$f_llegada.'" data-fsalida="'.$f_salida.'" data-type="lujo" data-pasajeros="'.$pasajeros.'" id="init_reserva" data-rate-ow="'.round($rates_luxury_ow,2).'"  data-rateus-ow = "'.round($rates_luxury_ow / $moneda,0).'" data-rate-rt="'.round($rates_luxury_rt,2).'"  data-rateus-rt = "'.round($rates_luxury_rt / $moneda,0).'"><span>Reservar </span></button>
                                </div>
                            </div>
                        </div>
                    </div>
               ';
           }else{
            $rate_service_luxury = '               
                 <div class="row mb-3 mt-3 p-2 bg-white border rounded">
                     <div class="col-md-3 mt-1 text-center content_card_result_center" >
                         <div>
                             <img class="img-fluid img-responsive rounded product-image" src="../assets/img/traslados/lujo.png">
                             <br><br>
                             <h5 style="text-transform: uppercase;">SERVICIO <span>LUJO</span></h5>
                         </div>
                     </div>
                     <div class="xol-xl-6 col-md-6 mt-1 mb-1 content_rules_card_result">
                         <p><small>El servicio de lujo es por van, NO por pasajero. Servicio disponible 24/7</small></p>
                         <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Precio por Vehículo</span></div>
                         <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Incluye todos los impuestos y tasas aeroportuarias.</span></div>
                         <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Seguro de viajero.</span></div>
                         <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Recepción por uno de nuestros representantes.</span></div>
                         <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> 24 Horas de servicio.</span></div>
                         <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Servicio puerta a puerta en Cancun & Riviera Maya.</span></div>
                         <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Vehículo privado – NO COMPARTIDO.</span></div>
                         <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Vehículo espacioso para los pasajeros y el equipaje.</span></div>
                         <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Un asiento de seguridad para niños incluido - Cuando lo solicite.</span></div>
                     </div>
                     <div class="col-xl-3 col-md-3 border-left mt-1 ">
                         <div class="w-100 text-center">
                             <div class=" text-center align-items-center">
                                 <small class="name_hotel"><strong>'.$hotel.'</strong></small><br>
                                 <small class="name_traslado">'.$name_traslado.'</small><br>
                                 <small class="name_pasajeros">Pasajeros: '.$pasajeros.'</small><br>
                             </div>
                             <div class="row mt-2 content_prices_results">
                                <div class="col-xl-6 col-md-12 ">
                                    <i class="fal fa-circle"></i>
                                    <h5>SENCILLO</h5>
                                    <h5 class="mt-1"><strong>---</strong></h5>
                                </div>
                                <div class="col-xl-6 col-md-12">
                                <i class="fal fa-circle"></i>
                                    <h5>REDONDO</h5>
                                    <h5 class="mt-1"><strong>---</strong></h5>
                                </div>
                            </div>
                             <div class="d-flex flex-column mt-4">
                                <p class="text_not_available">NO DISPONIBLE</p>
                             </div>
                         </div>
                     </div>
                 </div>
            ';

           }

           $lists_services = "";
           $lists_services = $rate_service_private.$rate_service_luxury.$rate_service_shared;
           echo $lists_services;


        }

        function getServiceListHotelHotel($ins, $con){
            include('../config/conexion.php');
            $hotel = mysqli_real_escape_string($con,$ins->{'hotel'});
            $interhotel = mysqli_real_escape_string($con,$ins->{'interhotel'});
            $pasajeros = $ins->{'pasajeros'};
            $traslados = $ins->{'traslado'};
            $f_llegada = $ins->{'date_star'};
            $f_salida = 0;
            $rate_service_shared = '';
            $rate_service_private = '';
            $rate_service_luxury = '';

            if($ins->{'date_end'}){
                $f_salida = $ins->{'date_end'};
            }       
            //Obetnemos el tipo de moneda
            $moneda = $this->getDivisa('mxn', $con);
             
            //Verificacion de tipo de servicio de traslado
            switch ($ins->{'traslado'}) {
                case 'RED':
                    $name_traslado = 'Redondo';
                    break;
        
                case 'SEN/AH':
                    $name_traslado = 'Aeropuerto - Hotel';
                    break;
         
                case 'SEN/HA':
                    $name_traslado = 'Hotel - Aeropuerto';
                    break;
             
                case 'REDHH':
                    $name_traslado = 'Redondo / Hotel - Hotel';
                    break;
            
                case 'SEN/HH':
                    $name_traslado = 'Sencillo / Hotel - Hotel';
                    break;
           }

            //Obtenemos zona de origen
            $zona = json_decode($this->getAreaDestination($ins->{'hotel'}, $con));
            //Obtenemos la tarifa de la zona
            $rates = json_decode($this->getRateArea($zona->{'id_zone'}, $con));  
             
            $zona_interhotel = '';
            $rates_interhotel = '';
            if ($ins->{'interhotel'}) {
                //Obtenemos zona de destino
                $zona_interhotel = json_decode($this->getAreaDestination($ins->{'interhotel'}, $con));
                //Obtenemos la tarifa de la zona
                $rates_interhotel = json_decode($this->getRateArea($zona_interhotel->{'id_zone'}, $con));  
                
            }
            //Cargo adicional al encontrarse a una distancia muy larga de 20%
            $additional_charge = 0;
            if ($zona->{'additional_charge'} != $zona_interhotel->{'additional_charge'}) {
                $additional_charge = 0.80;
            }
            //Compartido Hinter hotel
            if (intval($rates[0]->{'shared'}->{'oneway'}) > 0 && $rates[0]->{'shared'}->{'oneway'} != NULL  && intval($rates_interhotel[0]->{'shared'}->{'oneway'}) > 0 && $rates_interhotel[0]->{'shared'}->{'oneway'} != NULL) {
                $rates_shared_rt =  "";
                $rates_shared_ow =  "";
                $rates_shared_rt_2 =  "";
                $rates_shared_ow_2 =  "";
                $div_prices_shared = "";
                if ($traslados == 'REDHH') {
                    //Hotel 1
                    $rates_shared_ow = $rates[0]->{'shared'}->{'oneway'};
                    $rates_shared_rt = $rates[0]->{'shared'}->{'roundtrip'};
                    $rate_service_rt = $rates_shared_rt * $pasajeros;
                    $rate_service_ow = $rates_shared_ow * $pasajeros;
                    //Hotel 2
                    $rates_shared_ow_2 = $rates_interhotel[0]->{'shared'}->{'oneway'};
                    $rates_shared_rt_2 = $rates_interhotel[0]->{'shared'}->{'roundtrip'};
                    $rate_service_rt_2 = $rates_shared_rt_2 * $pasajeros;
                    $rate_service_ow_2 = $rates_shared_ow_2 * $pasajeros;
                    $new_rate_rt = '';
                    $new_rate_ow = '';
                    if ($rates_shared_rt > $rates_shared_rt_2) {
                        $new_rate_rt = $rates_shared_rt;
                        $new_rate_ow = $rates_shared_ow;
                    }else{
                        $new_rate_rt = $rates_shared_rt_2;
                        $new_rate_ow = $rates_shared_ow_2;
                    }
                    $new_rate_additional_charge_rt = '';
                    $new_rate_additional_charge_rt = $new_rate_rt;
                    $new_rate_additional_charge_ow = '';
                    $new_rate_additional_charge_ow = $new_rate_ow;
                    if ($additional_charge != 0) {
                        $new_rate_additional_rt = $new_rate_rt * $additional_charge;  
                        $new_rate_additional_ow = $new_rate_ow * $additional_charge;  
                        $new_rate_additional_charge_rt  =  $new_rate_rt + $new_rate_additional_rt;
                        $new_rate_additional_charge_ow =  $new_rate_ow + $new_rate_additional_ow;
                    }

                    $div_prices_shared = '
                        <div class="row mt-2 content_prices_results">
                            <div class="col-xl-6 col-md-12 ">
                                <i class="fal fa-circle"></i>
                                <h5>SENCILLO</h5>
                                <h5 class="mt-1"><strong>$'.round($new_rate_additional_charge_ow, 2).' MXN</strong></h5>
                            </div>
                            <div class="col-xl-6 col-md-12">
                                <i class="fas fa-check-square active"></i>
                                <h5>REDONDO</h5>
                                <h5 class="mt-1" data-rate="'.round($new_rate_additional_charge_rt,2).'"><strong>$'.round($new_rate_additional_charge_rt, 2).' MXN</strong></h5>
                            </div>
                        </div>
                    ';
                }else{
                    $rates_shared_ow = $rates[0]->{'shared'}->{'oneway'};
                    $rates_shared_rt = $rates[0]->{'shared'}->{'roundtrip'};
                    $rate_service_rt = $rates_shared_rt * $pasajeros;
                    $rate_service_ow = $rates_shared_ow * $pasajeros;
                    //Hotel 2
                    $rates_shared_ow_2 = $rates_interhotel[0]->{'shared'}->{'oneway'};
                    $rates_shared_rt_2 = $rates_interhotel[0]->{'shared'}->{'roundtrip'};
                    $rate_service_rt_2 = $rates_shared_rt_2 * $pasajeros;
                    $rate_service_ow_2 = $rates_shared_ow_2 * $pasajeros;
                    $new_rate_rt = '';
                    $new_rate_ow = '';
                    $new_rate_rt_2 = '';
                    $new_rate_ow_2 = '';
                    if ($rate_service_ow > $rate_service_ow_2) {
                        $new_rate_rt = $rate_service_rt;
                        $new_rate_ow = $rate_service_ow;
                    }else{
                        $new_rate_rt =$rate_service_rt_2;
                        $new_rate_ow =$rate_service_ow_2;
                    }
                    $new_rate_additional_charge_rt = '';
                    $new_rate_additional_charge_rt = $new_rate_rt;
                    $new_rate_additional_charge_ow = '';
                    $new_rate_additional_charge_ow = $new_rate_ow;
                    if ($additional_charge != 0) {
                        $new_rate_additional_rt = $new_rate_rt * $additional_charge;  
                        $new_rate_additional_ow = $new_rate_ow * $additional_charge;

                        $new_rate_additional_charge_rt  =  $new_rate_rt + $new_rate_additional_rt;
                        $new_rate_additional_charge_ow =  $new_rate_ow + $new_rate_additional_ow;
                    }
                    $div_prices_shared = '
                        <div class="row mt-2 content_prices_results">
                            <div class="col-xl-6 col-md-12">
                                <i class="fas fa-check-square active"></i>
                                <h5>SENCILLO</h5>
                                <h5 class="mt-1" data-rate="'.round($new_rate_additional_charge_ow,2).'" ><strong>$'.round($new_rate_additional_charge_ow, 2).' MXN</strong></h5>
                            </div>
                            <div class="col-xl-6 col-md-12 ">
                                <i class="fal fa-circle"></i>
                                <h5>REDONDO</h5>
                                <h5 class="mt-1"><strong>$'.round($new_rate_additional_charge_rt, 2).' MXN</strong></h5>
                            </div>
                        </div>
                    ';
                }
                $rate_service_shared = '               
                    <div class="row mb-3 mt-3 p-2 bg-white border rounded">
                        <div class="col-md-3 mt-1 text-center content_card_result_center" >
                            <div>
                                <img class="img-fluid img-responsive rounded product-image" src="../assets/img/traslados/priv_com.png">
                                <br><br>
                                <h5 style="text-transform: uppercase;">SERVICIO <span>COMPARTIDO</span></h5>
                                <input type="hidden" id="input_type_service" value="Shared"></input>
                            </div>
                        </div>
                        <div class="xol-xl-6 col-md-6 mt-1 mb-1 content_rules_card_result">
                            <p><small>El servicio compartido es por pasajero.</small></p>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Incluye todos los impuestos y tasas aeroportuarias.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Seguro de viajero.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Recepción por uno de nuestros representantes.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Servicio a la mayoría de los hoteles.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> El servicio compartido sale de forma continua desde el aeropuerto. </span></div>
                        </div>
                        <div class="col-xl-3 col-md-3 border-left mt-1 ">
                            <div class="w-100 text-center">
                                <div class=" text-center align-items-center">
                                <small class="name_hotel"><strong>'.$hotel.' / '.$interhotel.'</strong></small><br>
                                    <small class="name_traslado">'.$name_traslado.'</small><br>
                                    <small class="name_pasajeros">Pasajeros: '.$pasajeros.'</small><br>
                                </div>
                                '.$div_prices_shared.'
                                <div class="d-flex flex-column mt-4 mb-3">
                                    <button type="submit" class="btn_animation_2 btn btn-block btn-yamevi"  ><span>Reservar </span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
            }else{
            $rate_service_shared = '               
                    <div class="row mb-3 mt-3 p-2 bg-white border rounded">
                        <div class="col-md-3 mt-1 text-center content_card_result_center" >
                            <div>
                                <img class="img-fluid img-responsive rounded product-image" src="../assets/img/traslados/priv_com.png">
                                <br><br>
                                <h5 style="text-transform: uppercase;">SERVICIO <span>PRIVADO</span></h5>
                            </div>
                        </div>
                        <div class="xol-xl-6 col-md-6 mt-1 mb-1 content_rules_card_result">
                            <p><small>El servicio privado es por van, NO por pasajero. Servicio disponible 24/7</small></p>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Precio por Vehículo</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Incluye todos los impuestos y tasas aeroportuarias.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Seguro de viajero.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Recepción por uno de nuestros representantes.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> 24 Horas de servicio.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Servicio puerta a puerta en Cancun & Riviera Maya.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Vehículo privado – NO COMPARTIDO.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Vehículo espacioso para los pasajeros y el equipaje.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Un asiento de seguridad para niños incluido - Cuando lo solicite.</span></div>
                        </div>
                        <div class="col-xl-3 col-md-3 border-left mt-1 ">
                            <div class="w-100 text-center">
                                <div class=" text-center align-items-center">
                                    <small class="name_hotel"><strong>'.$hotel.' / '.$interhotel.'</strong></small><br>
                                    <small class="name_traslado">'.$name_traslado.'</small><br>
                                    <small class="name_pasajeros">Pasajeros: '.$pasajeros.'</small><br>
                                </div>
                                <div class="row mt-2 content_prices_results">
                                    <div class="col-xl-6 col-md-12 ">
                                        <i class="fal fa-circle"></i>
                                        <h5>SENCILLO</h5>
                                        <h5 class="mt-1"><strong>---</strong></h5>
                                    </div>
                                    <div class="col-xl-6 col-md-12">
                                        <i class="fal fa-circle"></i>
                                        <h5>REDONDO</h5>
                                        <h5 class="mt-1"><strong>---</strong></h5>
                                    </div>
                                </div>
                                <div class="d-flex flex-column mt-4">
                                    <p  class="text_not_available">NO DISPONIBLE</p>
                                </div>
                            </div>
                        </div>
                    </div>              
            ';
            }

            //Privado
            if (intval($rates[0]->{'private'}->{'privado_ow_1'}) > 0 && $rates[0]->{'private'}->{'privado_ow_1'} != NULL) {
                $rates_private_rt =  "";
                $rates_private_ow =  "";
                $rates_private_rt_2 =  "";
                $rates_private_ow_2 =  "";
                $div_prices_private = "";
                $new_rate_rt = '';
                $new_rate_ow = '';
                if ($pasajeros >=1 && $pasajeros <=4) {
                    //Hotel 1
                    $rates_private_ow = $rates[0]->{'private'}->{'privado_ow_1'} ;
                    $rates_private_rt = $rates[0]->{'private'}->{'privado_rt_1'};
                    //Hotel 2
                    $rates_private_ow_2 = $rates_interhotel[0]->{'private'}->{'privado_ow_1'};
                    $rates_private_rt_2 = $rates_interhotel[0]->{'private'}->{'privado_rt_1'};

                }
                if ($pasajeros >=5 && $pasajeros <=6) {
                    $rates_private_ow = $rates[0]->{'private'}->{'privado_ow_2'} ;
                    $rates_private_rt = $rates[0]->{'private'}->{'privado_rt_2'};
                    
                    $rates_private_ow_2 = $rates_interhotel[0]->{'private'}->{'privado_ow_2'} ;
                    $rates_private_rt_2 = $rates_interhotel[0]->{'private'}->{'privado_rt_2'};
                }
                if ($pasajeros >=7 && $pasajeros <=8) {
                    $rates_private_ow = $rates[0]->{'private'}->{'privado_ow_3'} ;
                    $rates_private_rt = $rates[0]->{'private'}->{'privado_rt_3'};
                    
                    $rates_private_ow_2 = $rates_interhotel[0]->{'private'}->{'privado_ow_3'} ;
                    $rates_private_rt_2 = $rates_interhotel[0]->{'private'}->{'privado_rt_3'};
                }
                if ($pasajeros >=9 && $pasajeros <=10) {
                    $rates_private_ow = $rates[0]->{'private'}->{'privado_ow_4'} ;
                    $rates_private_rt = $rates[0]->{'private'}->{'privado_rt_4'};
                    
                    $rates_private_ow_2 = $rates_interhotel[0]->{'private'}->{'privado_ow_4'} ;
                    $rates_private_rt_2 = $rates_interhotel[0]->{'private'}->{'privado_rt_4'};
                }
                if ($pasajeros >10 && $pasajeros <=11) {
                    $rates_private_ow = $rates[0]->{'private'}->{'privado_ow_5'} ;
                    $rates_private_rt = $rates[0]->{'private'}->{'privado_rt_5'};
                    
                    $rates_private_ow_2 = $rates_interhotel[0]->{'private'}->{'privado_ow_5'} ;
                    $rates_private_rt_2 = $rates_interhotel[0]->{'private'}->{'privado_rt_5'};
                }
                if ($pasajeros >=12 && $pasajeros <=16) {
                    $rates_private_ow = $rates[0]->{'private'}->{'privado_ow_6'} ;
                    $rates_private_rt = $rates[0]->{'private'}->{'privado_rt_6'};
                    
                    $rates_private_ow_2 = $rates_interhotel[0]->{'private'}->{'privado_ow_6'} ;
                    $rates_private_rt_2 = $rates_interhotel[0]->{'private'}->{'privado_rt_6'};
                }
                if ($traslados == 'REDHH') {
                    if ($rates_private_rt > $rates_private_rt_2) {
                        $new_rate_rt = $rates_private_rt;
                        $new_rate_ow = $rates_private_ow;
                    }else{
                        $new_rate_rt = $rates_private_rt_2;
                        $new_rate_ow = $rates_private_ow_2;
                    }
                    $new_rate_additional_charge_rt = '';
                    $new_rate_additional_charge_rt = $new_rate_rt;
                    $new_rate_additional_charge_ow = '';
                    $new_rate_additional_charge_ow = $new_rate_ow;
                    if ($additional_charge != 0) {
                        $new_rate_additional_charge_rt = $new_rate_rt / $additional_charge;  
                        $new_rate_additional_charge_ow = $new_rate_ow / $additional_charge;  
                    }
                    $div_prices_private = '
                        <div class="row mt-2 content_prices_results">
                            <div class="col-xl-6 col-md-12 ">
                                <i class="fal fa-circle"></i>
                                <h5>SENCILLO</h5>
                                <h5 class="mt-1"><strong>$'.round($new_rate_additional_charge_ow, 2).' MXN</strong></h5>
                                <small>$'.round($new_rate_additional_charge_ow / $moneda,0).' USD</small>
                            </div>
                            <div class="col-xl-6 col-md-12">
                                <i class="fas fa-check-square active"></i>
                                <h5>REDONDO</h5>
                                <h5 class="mt-1" data-rate="'.round($new_rate_additional_charge_rt,2).'"><strong>$'.round($new_rate_additional_charge_rt, 2).' MXN</strong></h5>
                                <small>$'.round($new_rate_additional_charge_rt / $moneda,0).' USD</small>
                            </div>
                        </div>
                    ';
                }else{
                    if ($rates_private_ow > $rates_private_ow_2) {
                        $new_rate_rt = $rates_private_rt;
                        $new_rate_ow = $rates_private_ow;
                    }else{
                        $new_rate_rt = $rates_private_rt_2;
                        $new_rate_ow = $rates_private_ow_2;
                    }
                    $new_rate_additional_charge_rt = '';
                    $new_rate_additional_charge_rt = $new_rate_rt;
                    $new_rate_additional_charge_ow = '';
                    $new_rate_additional_charge_ow = $new_rate_ow;
                    if ($additional_charge != 0) {
                        $new_rate_additional_charge_rt = $new_rate_rt / $additional_charge;  
                        $new_rate_additional_charge_ow = $new_rate_ow / $additional_charge;  
                    }
                    $div_prices_private = '
                        <div class="row mt-2 content_prices_results">
                            <div class="col-xl-6 col-md-12">
                                <i class="fas fa-check-square active"></i>
                                <h5>SENCILLO</h5>
                                <h5 class="mt-1" data-rate="'.round($new_rate_additional_charge_ow,2).'" ><strong>$'.round($new_rate_additional_charge_ow, 2).' MXN</strong></h5>
                                <small>$'.round($new_rate_additional_charge_ow / $moneda,0).' USD</small>
                            </div>
                            <div class="col-xl-6 col-md-12 ">
                                <i class="fal fa-circle"></i>
                                <h5>REDONDO</h5>
                                <h5 class="mt-1"><strong>$'.round($new_rate_additional_charge_rt, 2).' MXN</strong></h5>
                                <small>$'.round($new_rate_additional_charge_rt / $moneda,0).' USD</small>
                            </div>
                        </div>
                    ';
                }
                $rate_service_private = '               
                    <div class="row mb-3 mt-3 p-2 bg-white border rounded">
                        <div class="col-md-3 mt-1 text-center content_card_result_center" >
                            <div>
                                <img class="img-fluid img-responsive rounded product-image" src="../assets/img/traslados/priv_com.png">
                                <br><br>
                                <h5 style="text-transform: uppercase;">SERVICIO <span>PRIVADO</span></h5>
                                <input type="hidden" id="input_type_service" value="Private"></input>
                            </div>
                        </div>
                        <div class="xol-xl-6 col-md-6 mt-1 mb-1 content_rules_card_result">
                            <p><small>El servicio privado es por van, NO por pasajero. Servicio disponible 24/7</small></p>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Precio por Vehículo</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Incluye todos los impuestos y tasas aeroportuarias.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Seguro de viajero.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Recepción por uno de nuestros representantes.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> 24 Horas de servicio.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Servicio puerta a puerta en Cancun & Riviera Maya.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Vehículo privado – NO COMPARTIDO.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Vehículo espacioso para los pasajeros y el equipaje.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Un asiento de seguridad para niños incluido - Cuando lo solicite.</span></div>
                        </div>
                        <div class="col-xl-3 col-md-3 border-left mt-1 ">
                            <div class="w-100 text-center">
                                <div class=" text-center align-items-center">
                                    <small id="name_hotel"><strong>'.$hotel.'</strong></small> / <small id="name_interhotel"><strong>'.$interhotel.'</strong></small><br>
                                    <small id="name_traslado">'.$name_traslado.'</small><br>
                                    <small id="name_pasajeros">Pasajeros: '.$pasajeros.'</small><br>
                                    
                                </div>
                                '.$div_prices_private.'
                                <div class="d-flex flex-column mt-4">
                                    <button type="submit" class="btn_animation_2 btn btn-block btn-yamevi" data-tchange="'.$moneda.'" data-fllegada="'.$f_llegada.'" data-fsalida="'.$f_salida.'" data-type="privado" data-pasajeros="'.$pasajeros.'" data-rate-ow="'.round($new_rate_additional_charge_ow,2).'"  data-rateus-ow= "'.round($new_rate_additional_charge_ow / $moneda,0).'" data-rate-rt="'.round($new_rate_additional_charge_rt,2).'"  data-rateus-rt= "'.round($new_rate_additional_charge_rt / $moneda,0).'" id="init_reserva"><span>Reservar </span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
            }else{
                $rate_service_private = '               
                        <div class="row mb-3 mt-3 p-2 bg-white border rounded">
                            <div class="col-md-3 mt-1 text-center content_card_result_center" >
                                <div>
                                    <img class="img-fluid img-responsive rounded product-image" src="../assets/img/traslados/priv_com.png">
                                    <br><br>
                                    <h5 style="text-transform: uppercase;">SERVICIO <span>PRIVADO</span></h5>
                                </div>
                            </div>
                            <div class="xol-xl-6 col-md-6 mt-1 mb-1 content_rules_card_result">
                                <p><small>El servicio privado es por van, NO por pasajero. Servicio disponible 24/7</small></p>
                                <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Precio por Vehículo</span></div>
                                <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Incluye todos los impuestos y tasas aeroportuarias.</span></div>
                                <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Seguro de viajero.</span></div>
                                <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Recepción por uno de nuestros representantes.</span></div>
                                <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> 24 Horas de servicio.</span></div>
                                <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Servicio puerta a puerta en Cancun & Riviera Maya.</span></div>
                                <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Vehículo privado – NO COMPARTIDO.</span></div>
                                <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Vehículo espacioso para los pasajeros y el equipaje.</span></div>
                                <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Un asiento de seguridad para niños incluido - Cuando lo solicite.</span></div>
                            </div>
                            <div class="col-xl-3 col-md-3 border-left mt-1 ">
                                <div class="w-100 text-center">
                                    <div class=" text-center align-items-center">
                                        <small class="name_hotel"><strong>'.$hotel.'</strong></small><br>
                                        <small class="name_traslado">'.$name_traslado.'</small><br>
                                        <small class="name_pasajeros">Pasajeros: '.$pasajeros.'</small><br>
                                    </div>
                                    <div class="row mt-2 content_prices_results">
                                        <div class="col-xl-6 col-md-12 ">
                                            <i class="fal fa-circle"></i>
                                            <h5>SENCILLO</h5>
                                            <h5 class="mt-1"><strong>---</strong></h5>
                                        </div>
                                        <div class="col-xl-6 col-md-12">
                                            <i class="fal fa-circle"></i>
                                            <h5>REDONDO</h5>
                                            <h5 class="mt-1" ><strong>---</strong></h5>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column mt-4">
                                        <p  class="text_not_available">NO DISPONIBLE</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                ';
            }

            //Lujo
            if (intval($rates[0]->{'luxury'}->{'lujo_ow_1'}) > 0 && $rates[0]->{'luxury'}->{'lujo_ow_1'} != NULL && $pasajeros <=6) {
                $rates_luxury_ow = "";
                $rates_luxury_rt = "";
                $rates_luxury_ow_2 = "";
                $rates_luxury_rt_2 = "";
                $div_prices_luxury = "";
                if ($pasajeros >=1 && $pasajeros <=6) {
                    $rates_luxury_ow = $rates[0]->{'luxury'}->{'lujo_ow_1'} ;
                    $rates_luxury_rt = $rates[0]->{'luxury'}->{'lujo_rt_1'};

                    $rates_luxury_ow_2 = $rates_interhotel[0]->{'luxury'}->{'lujo_ow_1'} ;
                    $rates_luxury_rt_2 = $rates_interhotel[0]->{'luxury'}->{'lujo_rt_1'};
                }
                if ($traslados == 'REDHH') {
                    if ($rates_luxury_rt > $rates_luxury_rt_2) {
                        $new_rate_rt = $rates_luxury_rt;
                        $new_rate_ow = $rates_luxury_ow;
                    }else{
                        $new_rate_rt = $rates_luxury_rt_2;
                        $new_rate_ow = $rates_luxury_ow_2;
                    }
                    $new_rate_additional_charge_rt = '';
                    $new_rate_additional_charge_rt = $new_rate_rt;
                    $new_rate_additional_charge_ow = '';
                    $new_rate_additional_charge_ow = $new_rate_ow;
                    if ($additional_charge != 0) {
                        $new_rate_additional_charge_rt = $new_rate_rt / $additional_charge;  
                        $new_rate_additional_charge_ow = $new_rate_ow / $additional_charge;  
                    }
                    $div_prices_luxury = '
                        <div class="row mt-2 content_prices_results">
                            <div class="col-xl-6 col-md-12 ">
                                <i class="fal fa-circle"></i>
                                <h5>SENCILLO</h5>
                                <h5 class="mt-1"><strong>$'.round($new_rate_additional_charge_ow, 2).' MXN</strong></h5>
                                <small>$'.round($new_rate_additional_charge_ow / $moneda,0).' USD</small>
                            </div>
                            <div class="col-xl-6 col-md-12">
                                <i class="fas fa-check-square active"></i>
                                <h5>REDONDO</h5>
                                <h5 class="mt-1" id="rate_service" ><strong>$'.round($new_rate_additional_charge_rt, 2).' MXN</strong></h5>
                                <small>$'.round($new_rate_additional_charge_rt / $moneda,0).' USD</small>
                            </div>
                        </div>
                    ';
            }else{
                    if ($rates_luxury_ow > $rates_luxury_ow_2) {
                        $new_rate_rt = $rates_luxury_rt;
                        $new_rate_ow = $rates_luxury_ow;
                    }else{
                        $new_rate_rt = $rates_luxury_rt_2;
                        $new_rate_ow = $rates_luxury_ow_2;
                    }
                    $new_rate_additional_charge_rt = '';
                    $new_rate_additional_charge_rt = $new_rate_rt;
                    $new_rate_additional_charge_ow = '';
                    $new_rate_additional_charge_ow = $new_rate_ow;
                    if ($additional_charge != 0) {
                        $new_rate_additional_charge_rt = $new_rate_rt / $additional_charge;  
                        $new_rate_additional_charge_ow = $new_rate_ow / $additional_charge;  
                    }
                    $div_prices_luxury = '
                        <div class="row mt-2 content_prices_results">
                            <div class="col-xl-6 col-md-12">
                                <i class="fas fa-check-square active"></i>
                                <h5>SENCILLO</h5>
                                <h5 class="mt-1" id="rate_service" ><strong>$'.round($new_rate_additional_charge_ow, 2).' MXN</strong></h5>
                                <small>$'.round($new_rate_additional_charge_ow / $moneda,0).' USD</small>
                            </div>
                            <div class="col-xl-6 col-md-12 ">
                                <i class="fal fa-circle"></i>
                                <h5>REDONDO</h5>
                                <h5 class="mt-1"><strong>$'.round($new_rate_additional_charge_rt, 2).' MXN</strong></h5>
                                <small>$'.round($new_rate_additional_charge_rt / $moneda,0).' USD</small>
                            </div>
                        </div>
                    ';
            }
            $rate_service_luxury = '               
                    <div class="row mb-3 mt-3 p-2 bg-white border rounded">
                        <div class="col-md-3 mt-1 text-center content_card_result_center" >
                            <div>
                                <img class="img-fluid img-responsive rounded product-image" src="../assets/img/traslados/lujo.png">
                                <br><br>
                                <h5 style="text-transform: uppercase;">SERVICIO <span>LUJO</span></h5>
                                <input type="hidden" id="input_type_service" value="Luxury"></input>
                            </div>
                        </div>
                        <div class="xol-xl-6 col-md-6 mt-1 mb-1 content_rules_card_result">
                            <p><small>El servicio de lujo es por van, NO por pasajero. Servicio disponible 24/7</small></p>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Precio por Vehículo</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Incluye todos los impuestos y tasas aeroportuarias.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Seguro de viajero.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Recepción por uno de nuestros representantes.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> 24 Horas de servicio.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Servicio puerta a puerta en Cancun & Riviera Maya.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Vehículo privado – NO COMPARTIDO.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Vehículo espacioso para los pasajeros y el equipaje.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Un asiento de seguridad para niños incluido - Cuando lo solicite.</span></div>
                        </div>
                        <div class="col-xl-3 col-md-3 border-left mt-1 ">
                            <div class="w-100 text-center">
                                <div class=" text-center align-items-center">
                                    <small id="name_hotel"><strong>'.$hotel.'</strong></small> / <small id="name_interhotel"><strong>'.$interhotel.'</strong></small><br>
                                    <small id="name_traslado">'.$name_traslado.'</small><br>
                                    <small id="name_pasajeros">Pasajeros: '.$pasajeros.'</small><br>
                                </div>
                                '.$div_prices_luxury.'
                                <div class="d-flex flex-column mt-4">
                                    <button type="submit" class="btn_animation_2 btn btn-block btn-yamevi" data-tchange="'.$moneda.'" data-fllegada="'.$f_llegada.'" data-fsalida="'.$f_salida.'" data-type="lujo" data-pasajeros="'.$pasajeros.'" id="init_reserva" data-rate-ow="'.round($new_rate_additional_charge_ow,2).'"  data-rateus-ow = "'.round($new_rate_additional_charge_ow / $moneda,0).'" data-rate-rt="'.round($new_rate_additional_charge_rt,2).'"  data-rateus-rt = "'.round($new_rate_additional_charge_rt / $moneda,0).'"><span>Reservar </span></button>
                                </div>
                            </div>
                        </div>
                    </div>
            ';
            }else{
                $rate_service_luxury = '               
                    <div class="row mb-3 mt-3 p-2 bg-white border rounded">
                        <div class="col-md-3 mt-1 text-center content_card_result_center" >
                            <div>
                                <img class="img-fluid img-responsive rounded product-image" src="../assets/img/traslados/lujo.png">
                                <br><br>
                                <h5 style="text-transform: uppercase;">SERVICIO <span>LUJO</span></h5>
                            </div>
                        </div>
                        <div class="xol-xl-6 col-md-6 mt-1 mb-1 content_rules_card_result">
                            <p><small>El servicio de lujo es por van, NO por pasajero. Servicio disponible 24/7</small></p>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Precio por Vehículo</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Incluye todos los impuestos y tasas aeroportuarias.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Seguro de viajero.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Recepción por uno de nuestros representantes.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> 24 Horas de servicio.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Servicio puerta a puerta en Cancun & Riviera Maya.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Vehículo privado – NO COMPARTIDO.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Vehículo espacioso para los pasajeros y el equipaje.</span></div>
                            <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Un asiento de seguridad para niños incluido - Cuando lo solicite.</span></div>
                        </div>
                        <div class="col-xl-3 col-md-3 border-left mt-1 ">
                            <div class="w-100 text-center">
                                <div class=" text-center align-items-center">
                                    <small class="name_hotel"><strong>'.$hotel.'</strong></small><br>
                                    <small class="name_traslado">'.$name_traslado.'</small><br>
                                    <small class="name_pasajeros">Pasajeros: '.$pasajeros.'</small><br>
                                </div>
                                <div class="row mt-2 content_prices_results">
                                    <div class="col-xl-6 col-md-12 ">
                                        <i class="fal fa-circle"></i>
                                        <h5>SENCILLO</h5>
                                        <h5 class="mt-1"><strong>---</strong></h5>
                                    </div>
                                    <div class="col-xl-6 col-md-12">
                                    <i class="fal fa-circle"></i>
                                        <h5>REDONDO</h5>
                                        <h5 class="mt-1"><strong>---</strong></h5>
                                    </div>
                                </div>
                                <div class="d-flex flex-column mt-4">
                                    <p class="text_not_available">NO DISPONIBLE</p>
                                </div>
                            </div>
                        </div>
                    </div>
                ';

            }
            echo $rate_service_private.$rate_service_luxury;
        }
        function verifyDestionation($hotel, $con){
            $newhotel = mysqli_real_escape_string($con, $hotel);
            $query = "SELECT * FROM hotels AS H INNER JOIN rates_agencies AS R ON H.id_zone = R.id_zone WHERE H.name_hotel = '$newhotel';";
            $result = mysqli_query($con, $query);
            $res = false;
            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    $res = true;
                }
            }
            return $res;
        }

        function getDivisa($divisa, $con){
            $query = "SELECT amount_change FROM exchange_rate WHERE STATUS = 1 AND divisa = '$divisa' ORDER BY date_modify DESC LIMIT 0,1;";
            $result = mysqli_query($con,$query);
            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        $divisa = $row['amount_change'];
                    }
                }
            }
            return $divisa;
        }
        function getAreaDestination($hotel, $con){
            $newhotel = mysqli_real_escape_string($con, $hotel);
            $query= "SELECT R.id_zone, R.name_zone, R.additional_charge FROM hotels AS H INNER JOIN rates_public AS R ON H.id_zone = R.id_zone WHERE H.name_hotel = '$newhotel';";
            $result = mysqli_query($con, $query);
            $json = array();
            if ($result) {                
                while ($row = mysqli_fetch_object($result)) {
                   $json = array(
                        'id_zone' => $row->id_zone,
                        'name_zone' => $row->name_zone,
                        'additional_charge' => $row->additional_charge
                   );
                }
            }
            $jsonString = json_encode($json);
            return $jsonString;
        }
        function getRateArea($id_zone,$con){
            $query= "SELECT * FROM rates_agencies WHERE id_zone = $id_zone;";
            $result = mysqli_query($con, $query);
            $json = array();
            $shared = array();
            $private = array();
            $luxury = array();
            if ($result) {                
                while ($row = mysqli_fetch_object($result)) {
                        $json[]=array(
                            'shared' =>array(
                                'oneway' => $row->compartido_ow, 
                                'roundtrip' => $row->compartido_rt, 
                                'oneway_premium' => $row->compartido_ow_premium, 
                                'roundtrip_premium' => $row->compartido_rt_premium
                            ),
                            'private' =>array(
                                'privado_ow_1' => $row->privado_ow_1,
                                'privado_rt_1' => $row->privado_rt_1,
                                'privado_ow_2' => $row->privado_ow_2,
                                'privado_rt_2' => $row->privado_rt_2,
                                'privado_ow_3' => $row->privado_ow_3,
                                'privado_rt_3' => $row->privado_rt_3,
                                'privado_ow_4' => $row->privado_ow_4,
                                'privado_rt_4' => $row->privado_rt_4,
                                'privado_ow_5' => $row->privado_ow_5,
                                'privado_rt_5' => $row->privado_rt_5,
                                'privado_ow_6' => $row->privado_ow_6,
                                'privado_rt_6' => $row->privado_rt_6
                            ),
                            'luxury' =>array(
                                'lujo_ow_1' => $row->lujo_ow_1 ,
                                'lujo_rt_1' => $row->lujo_rt_1 
                            ),
                        );
                }
            }
            $jsonString = json_encode($json);
            return $jsonString;
        }
        function createLetterConfirm($id, $letter,$con, $ticket, $total){
            $newticket = 0;
            if ($ticket != '' || $ticket ==1) {
                $newticket = $ticket;
            }
            $newtotal = 0;
            if ($total != '' || $total ==1) {
                $newtotal = $total;
            }
            if ($con == "") {            
                include('../config/conexion.php');
            }
            $id_reservation = mysqli_real_escape_string($con, $id);
            $letter_lang = mysqli_real_escape_string($con, $letter);
            $query_letter = "SELECT * FROM reservations AS R INNER JOIN clients AS C ON R.id_client = C.id_client
            INNER JOIN reservation_details AS D ON D.id_reservation = R.id_reservation WHERE R.id_reservation = $id_reservation;";
            $result_letter = mysqli_query($con, $query_letter);
            $obj = "";
            $footer_letter = "0";
            $type_currency ="";
            $type_service = "";
            $type_transfer = "";
            $data_entry ="";
            $data_exit = "";
            //Textos
            $asociacion = '';
            $n_idresercion = '';
            $n_total ='';

            $datos_reserva_externa = '';
            $n_localizador = '';
            $n_asesor = '';

            $datos_reservacion = '';
            $n_traslado ='';
            $n_servicio = '';
            $n_pasajeros = '';
            $n_text_pasajeros = '';
            $n_hotel = '';
            $n_hotel_ida = '';
            $n_hotel_vuelta = '';
            $n_date_entry = '';
            $n_date_exit = '';
            $n_llegada = '';
            $n_salida = '';
            $n_aerolina = '';
            $n_vuelo = '';

            $datos_cliente = '';
            $n_nombre = '';
            $n_email = '';
            $n_telefono = '';
            $n_pais = '';
            $n_comentarios = '';

            $datos_pago = '';
            $n_mpego = '';
            $n_estado = '';

            $aviso_carta ='';
            $id_agencie='';
            $footer_letter="";

            if ($result_letter) {
                $obj = mysqli_fetch_object($result_letter);
                //Tipo de divisa

                $id_agencie = $obj->id_agency; 
                 //Logo agencias
                $logo_agencie = $this->getIcon($id_agencie,$con);

                $new_type_currency = "";
                if ($obj->type_currency == 'mx') {
                    $new_type_currency = "MXN";
                }else {
                    $new_type_currency = "USD";
                }
                $comments ="Sin comentarios";
                if ($obj->comments_client) {
                    $comments = $obj->comments_client;
                }

                //Armando cuerpo de  por tipo de idioma
                if ($letter_lang == 'mx') {
                    $asociacion = 'EN ASOCIACIÓN CON';
                    $n_idresercion = 'ID reservación';
                    $n_total ='Total';
        
                    $datos_reserva_externa = 'Datos de reserva externa';
                    $n_localizador = 'Localizador';
                    $n_asesor = 'Asesor';
        
                    $datos_reservacion = 'Detalles de Reservación';
                    $n_traslado ='Traslado';
                    $n_servicio = 'Servicio';
                    $n_pasajeros = 'Pasajeros';
                    $n_text_pasajeros = 'Pasajero(s)';
                    $n_hotel = 'Hotel';
                    $n_hotel_ida = 'Hotel de Ida';
                    $n_hotel_vuelta = 'Hotel de Vuelta';
                    $n_date_entry = 'Fecha llegada';
                    $n_date_exit = 'Fecha salida';
                    $n_llegada = 'Llegada';
                    $n_salida = 'Salida';
                    $n_aerolina = 'Aerolina';
                    $n_vuelo = 'No. de vuelo';
        
                    $datos_cliente = 'Datos de Cliente';
                    $n_nombre = 'Nombre';
                    $n_email = 'Email';
                    $n_telefono = 'Teléfono';
                    $n_pais = 'País';
                    $n_comentarios = 'Comentarios';
        
                    $datos_pago = 'Detalles de Pago';
                    $n_mpego = 'Método de Pago';
                    $n_estado = 'Estado';
                    $aviso_carta ='';   
                    $method_payment = "";   
                    $typePayment = 'PAGADO';
                    $typePayment = ($obj->method_payment == 'transfer') ? 'TRANSFERENCIA BANCARIA' : 'PAGO CON TARJETA';
                    if($obj->method_payment == 'airport') { $typePayment = "PAGO AL ABORDAR"; }
                    if($obj->method_payment == 'paypal') { $typePayment = 'PAGO POR PAYPAL'; }
                    if($obj->method_payment == 'card'){ $typePayment = 'PAGO CON TARJETA'; }
                    switch ($obj->type_service) {
                        case 'compartido':
                            $type_service = 'Compartido';
                            break;
                        case 'privado':
                            $type_service = 'Privado';
                            break;
                        case 'lujo':
                            $type_service = 'Lujo';
                            break;          
                    }
                    switch ($obj->method_payment) {
                        case 'card':
                            $method_payment = 'Tarjeta';
                            break;
                        case 'transfer':
                            $method_payment = 'Transferencia';
                            break;
                        case 'paypal':
                            $method_payment = 'PayPal';
                            break; 
                        case 'airport':
                            $method_payment = 'Pago al Abordar';
                            break; 
                    }
                    switch ($obj->type_transfer) {
                        case 'SEN/AH':
                            $type_transfer = 'Sencillo / Aeropuerto - Hotel';
                            $date_entry = $obj->date_arrival.' / '.$obj->time_arrival;
                            break;
                        case 'SEN/HA':
                            $type_transfer = 'Sencillo / Hotel - Aeropuerto';
                            $date_exit = $obj->date_exit.' / '.$obj->time_exit;
                            break;
                        case 'RED':
                            $type_transfer = 'Redondo';
                            $data_entry = $obj->date_arrival.' / '.$obj->time_arrival;
                            $data_exit = $obj->date_exit.' / '.$obj->time_exit;
                            break;
                        case 'REDHH':
                            $type_transfer = 'Redondo / Hotel - Hotel';
                            break;
                        case 'SEN/HH':
                            $type_transfer = 'Sencillo / Hotel - Hotel';
                            break;
                    }
                    
                    $subjectSales = 'Nueva reservación - '.$obj->id_agency.' - '.$obj->code_invoice;
                    $subjectClient = 'Transportación reservada - Sistema Agencias - '.$obj->code_invoice;
                    $currency = 'MXN';
                    
                    $footer_letter = $this->getFooterLetter($letter_lang, $con);

                }
                if ($letter_lang == 'us') {
                    $asociacion = 'IN ASSOCIATION WITH';
                    $n_idresercion = 'ID reservation';
                    $n_total ='Total';
        
                    $datos_reserva_externa = 'External Data Reservation';
                    $n_localizador = 'Locator';
                    $n_asesor = 'Advisor';
        
                    $datos_reservacion = 'Reservation Details';
                    $n_traslado ='Transfer';
                    $n_servicio = 'Service';
                    $n_pasajeros = 'Passengers';
                    $n_text_pasajeros = 'Passenger(s)';
                    $n_hotel = 'Hotel';
                    $n_hotel_ida = 'Hotel';
                    $n_hotel_vuelta = 'Return Hotel';
                    $n_date_entry = 'Arrival Date';
                    $n_date_exit = 'Exit Date';
                    $n_llegada = 'Arrival';
                    $n_salida = 'Exit';
                    $n_aerolina = 'Airline';
                    $n_vuelo = 'No. Fly';
        
                    $datos_cliente = 'Customer Data';
                    $n_nombre = 'Name';
                    $n_email = 'Email';
                    $n_telefono = 'Phone';
                    $n_pais = 'Country';
                    $n_comentarios = 'Comments';
        
                    $datos_pago = 'Payment Details';
                    $n_mpego = 'Payment method';
                    $n_estado = 'Status';
        
                    $aviso_carta ='';        
                    $typePayment = 'PAID';
                    $typePayment = ($obj->method_payment == 'transfer') ? 'BANK TRANSFER' : 'CREDIT/DEBIT CARD';
                    if($obj->method_payment == 'airport') { $typePayment = "PAY IN CASH"; }
                    if($obj->method_payment == 'paypal') { $typePayment = 'PAYMENT THROUGH PAYPAL'; }
                    if($obj->method_payment == 'card'){ $typePayment = 'CREDIT/DEBIT CARD'; }
                    
                    switch ($obj->type_service) {
                        case 'compartido':
                            $type_service = 'Shared';
                            break;
                        case 'privado':
                            $type_service = 'Private';
                            break;
                        case 'lujo':
                            $type_service = 'Luxury';
                            break;          
                    }
                    switch ($obj->method_payment) {
                        case 'card':
                            $method_payment = 'Credit/Debit Card';
                            break;
                        case 'transfer':
                            $method_payment = 'Bank Transfer';
                            break;
                        case 'paypal':
                            $method_payment = 'PayPal';
                            break; 
                        case 'airport':
                            $method_payment = 'Pay in Cash';
                            break; 
                    }

                    switch ($obj->type_transfer) {
                        case 'SEN/AH':
                            $type_transfer = 'One Way Transfer / Airport to Hotel';
                            $date_entry = $obj->date_arrival.' / '.$obj->time_arrival;
                            break;
                        case 'SEN/HA':
                            $type_transfer = 'One Way Transfer / Hotel to Airport';
                            $date_exit = $obj->date_exit.' / '.$obj->time_exit;
                            break;
                        case 'RED':
                            $type_transfer = 'Round Trip';
                            $data_entry = $obj->date_arrival.'<br>'.$obj->time_arrival;
                            $data_exit = $obj->date_exit.' / '.$obj->time_exit;
                            break;
                        case 'REDHH':
                            $type_transfer = 'Round Trip / Hotel to Hotel';
                            break;
                        case 'SEN/HH':
                            $type_transfer = 'One Way / Hotel to Hotel';
                            break;
                    }
                    $subjectSales = 'New reservation - '.$obj->id_agency.' - '.$obj->code_invoice;
                    $subjectClient = 'Transportation Reserved - Agency System - '.$obj->code_invoice;
                    $currency = 'USD';
                    $footer_letter = $this->getFooterLetter($letter_lang, $con);

                }    
                if ($letter_lang == 'pt') {
                    $asociacion = 'EM ASSOCIAÇÃO COM';
                    $n_idresercion = 'ID de reserva';
                    $n_total ='Total';
        
                    $datos_reserva_externa = 'Dados de reserva externa';
                    $n_localizador = 'Localizador';
                    $n_asesor = 'Assessor';
        
                    $datos_reservacion = 'Dados de reserva';
                    $n_traslado ='Transferir';
                    $n_servicio = 'Serviço';
                    $n_pasajeros = 'Passageiros';
                    $n_text_pasajeros = 'Passageiro(s)';
                    $n_hotel = 'Hotel';
                    $n_hotel_ida = 'Hotel só de ida';
                    $n_hotel_vuelta = 'Hotel de retorno';
                    $n_date_entry = 'Data de chegada';
                    $n_date_exit = 'Data de saída';
                    $n_llegada = 'Chegada';
                    $n_salida = 'Partida';
                    $n_aerolina = 'CIA aérea';
                    $n_vuelo = 'Número de vôo';
        
                    $datos_cliente = 'Detalhes do cliente';
                    $n_nombre = 'Nome';
                    $n_email = 'E-mail';
                    $n_telefono = 'Telefone';
                    $n_pais = 'País';
                    $n_comentarios = 'Comentários';
        
                    $datos_pago = 'Detalhes do pagamento';
                    $n_mpego = 'Forma de pagamento';
                    $n_estado = 'A condição';
        
                    $aviso_carta ='';      
                    $typePayment = 'PAGO';
                    $typePayment = ($obj->method_payment == 'transfer') ? 'TRANSFERÊNCIA BANCÁRIA' : 'CARTÃO DE CRÉDITO';
                    if($obj->method_payment == 'airport') { $typePayment ='PAGAR NA CHEGADA'; }
                    if($obj->method_payment == 'paypal') { $typePayment = 'PAIEMENT PAR PAYPAL'; }
                    if($obj->method_payment == 'card'){ $typePayment = 'PAGAMENTO COM CARTÃO'; }
                    
                    switch ($obj->type_service) {
                        case 'compartido':
                            $type_service = 'Compartilhada';
                            break;
                        case 'privado':
                            $type_service = 'Particular';
                            break;
                        case 'lujo':
                            $type_service = 'Fine Dining';
                            break;          
                    }
                    switch ($obj->method_payment) {
                        case 'card':
                            $method_payment = 'PAGAMENTO COM CARTÃO';
                            break;
                        case 'transfer':
                            $method_payment = 'TRANSFERÊNCIA BANCÁRIA';
                            break;
                        case 'paypal':
                            $method_payment = 'PAYPAL';
                            break; 
                        case 'airport':
                            $method_payment = 'PAGAR NA CHEGADA';
                            break; 
                    }

                    switch ($obj->type_transfer) {
                        case 'SEN/AH':
                            $type_transfer = 'Aeroporto a Hotel';
                            $date_entry = $obj->date_arrival.' / '.$obj->time_arrival;
                            break;
                        case 'SEN/HA':
                            $type_transfer = 'Hotel a Aeroporto';
                            $date_exit = $obj->date_exit.' / '.$obj->time_exit;
                            break;
                        case 'RED':
                            $type_transfer = 'Ida e Volta';
                            $data_entry = $obj->date_arrival.'<br>'.$obj->time_arrival;
                            $data_exit = $obj->date_exit.' / '.$obj->time_exit;
                            break;
                        case 'REDHH':
                            $type_transfer = 'Ida e Volta / Hotel - Hotel';
                            break;
                        case 'SEN/HH':
                            $type_transfer = 'Simple / Hotel to Hotel';
                            break;
                    }
                    $subjectSales = 'Nueva reservación - PT - '.$obj->id_agency.' - '.$obj->code_invoice;
                    $subjectClient = 'Transporte reservados - Agências do Sistema - '.$obj->code_invoice;
                    $currency = 'USD';
                    $footer_letter = $this->getFooterLetter($letter_lang, $con);
                }   

                $template = '';

                //Header
                $template.='
                    <!DOCTYPE html>
                        <html lang="en">
                        <head>
                            <meta charset="UTF-8">
                            <meta http-equiv="X-UA-Compatible" content="IE=edge">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <title>Email</title>
                        </head>
                        <style type="text/css">
                        @import url("https://fonts.googleapis.com/css2?family=Barlow&display=swap");
                        p, h1, h2, h3, h4,h5, ol, li, ul,p,small { font-family:"Barlow",
                        sans-serif; }
                        @media all {
                            div.saltopagina{
                               display: none;
                            }
                         }
                            
                         @media print{
                            div.saltopagina{
                               display:block;
                               page-break-before:always;
                            }
                         }
                        </style>
                        <body style="margin: 0; padding: 20px; font-family: Arial, sans-serif"> 
                            <table align="center"  cellpadding="0" cellspacing="0" width="700" class="table" id="table_ticket"> 
                                <tr>
                                    <td style="padding-left: 20px; padding-right: 20px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding:20px 5px 20px 5px; border-bottom: 1px solid #a5a5a5;">
                                            <tr>
                                                <td width="170" valign="top" >
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td align="center">
                                                                <img src="../assets/img/agencias/'.$logo_agencie.'" alt="" width="70%" height="80" style="display: block;" />
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style=" line-height: 0; text-align: center; 
                                                vertical-align: middle;" width="200">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td align="center">
                                                                <h5 style="font-family: "Barlow", sans-serif;">'.$asociacion.'</h5>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td width="170" valign="top" >
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td align="center">
                                                                <img src="../assets/img/agencias/yt_small.png" alt="" width="auto" height="auto" style="display: block; padding-top: 10px; text-align: center;" />                                    
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td> 
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-left: 20px; padding-right: 20px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding:20px 5px 0px 5px;">
                                            <tr>
                                                <td style=" line-height: 0; text-align: center; " width="300">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td align="left">
                                                                <h3 style="margin-block-end: 0.5em;">'.$n_idresercion.'</h3>
                                                                <p>'.$obj->code_invoice.'</p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>';
                if ($newtotal == 1) {
                    $template.='
                                                <td style=" line-height: 0; text-align: center; " width="300">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td align="right">
                                                                <h3 style="margin-block-end: 0.5em;">Total</h3>
                                                                <p style="color: #E1423B; font-weight: bold;">$ 0.00 '.$new_type_currency.'</p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                    ';
                }
                if ($newtotal == 0) {
                    $template.='
                                                <td style=" line-height: 0; text-align: center; " width="300">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td align="right">
                                                                <h3 style="margin-block-end: 0.5em;">Total</h3>
                                                                <p style="color: #E1423B; font-weight: bold;">$ '.$obj->total_cost_commision.' '.$new_type_currency.'</p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                    ';
                }
                $template.='
                                                
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                ';
                //Apartado Reserva Externa
                if ($obj->code_client) {
                    $template.= '    
                                <tr>
                                    <td style="padding-left: 20px; padding-right: 20px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding:5px 5px 15px 5px;">
                                            <td style=" line-height: 0; text-align: center; " width="600">
                                                <table style="padding:20px 5px 0px 5px; border-bottom: 1px solid #E1423B;"cellpadding="0" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td align="left">
                                                            <h5 style="margin-block-end: 0.5em; color: #E1423B;;">'.$datos_reserva_externa.'</h5>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-left: 20px; padding-right: 20px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding:0px 5px 20px 5px;">
                                            <tr>
                                                <td style=" line-height: 0;" width="290">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <h5 style="margin-block-end: 0.5em;">'.$n_localizador.'</h5>
                                                                <small>'.$obj->code_client.'</small>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style=" line-height: 0; " width="170">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <h5 style="margin-block-end: 0.5em;">'.$n_asesor.'</h5>
                                                                <small>'.$obj->name_advisor.'</small>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style=" line-height: 0; " width="170">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                    ';
                }

                //Detalles de la reservacion
                $template.='
                                <tr>
                                    <td style="padding-left: 20px; padding-right: 20px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding:5px 5px 15px 5px;">
                                            <td style=" line-height: 0; text-align: center; " width="600">
                                                <table style="padding:10px 5px 0px 5px; border-bottom: 1px solid #E1423B;"cellpadding="0" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td align="left">
                                                            <h5 style="margin-block-end: 0.5em; color: #E1423B;">'.$datos_reservacion.'</h5>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-left: 20px; padding-right: 20px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding:0px 5px 20px 5px;">
                                            <tr>
                                                <td style=" line-height: 0;" width="290">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <h5 style="margin-block-end: 0.5em;">'.$n_traslado.'</h5>
                                                                <small>'.$type_transfer.'</small>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style=" line-height: 0; " width="170">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <h5 style="margin-block-end: 0.5em;">'.$n_servicio.'</h5>
                                                                <small>'.$obj->type_service.'</small>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style=" line-height: 0; " width="170">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <h5 style="margin-block-end: 0.5em;">'.$n_pasajeros.'</h5>
                                                                <small>'.$obj->number_adults.' '.$n_pasajeros.'(s)</small>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                ';

                if ($obj->type_transfer == 'SEN/AH' || $obj->type_transfer == 'RED' || $obj->type_transfer == 'SEN/HA') {
                    $template.='
                                <tr>
                                    <td style="padding-left: 20px; padding-right: 20px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding:0px 5px 20px 5px;">
                                            <tr>
                                                <td style=" line-height: 0;" width="290">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <h5 style="padding-bottom: 2px;">'.$n_hotel.'</h5>
                                                                <small>'.$obj->transfer_destiny.'</small>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                    ';
                    if ($obj->type_transfer == 'SEN/AH' ) {
                        $template.='
                                                <td style=" line-height: 0; " width="170">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <h5 style="padding-bottom: 2px;">'.$n_date_entry.'</h5>
                                                                <small>'.$obj->date_arrival.' / '.$obj->time_arrival.' Hrs</small>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style=" line-height: 0; " width="170">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                        ';
                    }
                    if ($obj->type_transfer == 'SEN/HA') {
                        $template.='
                                                <td style=" line-height: 0; " width="170">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <h5 style="padding-bottom: 2px;">'.$n_date_exit.'</h5>
                                                                <small>'.$obj->date_exit.' / '.$obj->time_exit.' Hrs</small>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style=" line-height: 0; " width="170">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                        ';
                    }
                    
                    if ($obj->type_transfer == 'RED') {
                        $template.='
                                                <td style=" line-height: 0; " width="170">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <h5 style="padding-bottom: 2px;">'.$n_date_entry.'</h5>
                                                                <small>'.$obj->date_arrival.' / '.$obj->time_arrival.' Hrs</small>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style=" line-height: 0; " width="170">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <h5 style="padding-bottom: 2px;">'.$n_date_exit.'</h5>
                                                                <small>'.$obj->date_exit.' / '.$obj->time_exit.' Hrs</small>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                        ';
                    }
                    $template.='
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                    ';

                }
                    $template.='
                                <tr>
                                    <td style="padding-left: 20px; padding-right: 20px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding:0px 5px 20px 5px;">
                                            <tr>
                    ';
                if($obj->type_transfer == 'SEN/HH' ){
                    $template.='
                                                <td width="290">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <h5 style="margin-block-end: 0.5em;">'.$n_hotel_ida.'</h5>
                                                                <small>'.$obj->transfer_destiny.'</small>
                                                                <br>
                                                                <small>></small>
                                                                <small>'.$obj->destiny_interhotel.'</small>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td  width="170">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <h5 style="margin-block-end: 0.5em;">'.$n_llegada.'</h5>
                                                                <small>'.$obj->date_arrival.'<br> '.$obj->time_arrival.' Hrs</small>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style=" line-height: 0; " width="170">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                    ';
                }
                if ($obj->type_transfer == 'REDHH') {
                        $template.='
                                                <td width="290">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <h5 style="margin-block-end: 0.5em;">'.$n_hotel_ida.'</h5>
                                                                <small>'.$obj->transfer_destiny.'</small>
                                                                <br>
                                                                <small>></small>
                                                                <small>'.$obj->destiny_interhotel.'</small>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td  width="200">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <h5 style="margin-block-end: 0.5em;">'.$n_llegada.'</h5>
                                                                <small>'.$obj->date_arrival.'<br> '.$obj->time_arrival.' Hrs</small>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td width="300">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <h5 style="margin-block-end: 0.5em;">'.$n_hotel_vuelta.'</h5>
                                                                <small>'.$obj->destiny_interhotel.'</small>
                                                                <br>
                                                                <small>></small>
                                                                <small>'.$obj->transfer_destiny.'</small>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td  width="180">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <h5 style="margin-block-end: 0.5em;">'.$n_salida.'</h5>
                                                                <small>'.$obj->date_exit.' <br> '.$obj->time_exit.' Hrs</small>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                        ';
                }
                    $template.='
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                    ';
                
                if ($obj->type_transfer == 'SEN/AH' || $obj->type_transfer == 'RED') {
                    $template.='
                                <tr>
                                    <td style="padding-left: 20px; padding-right: 20px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding:0px 5px 20px 5px;">
                                            <tr>
                                                <td style=" line-height: 0;" width="290">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <h5 style="margin-block-end: 0.5em;">'.$n_llegada.'</h5>
                                                                <small>></small>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style=" line-height: 0; " width="170">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <h5 style="margin-block-end: 0.5em;">'.$n_aerolina.'</h5>
                                                                <small>'.$obj->airline_in.'</small>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style=" line-height: 0; " width="170">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <h5 style="margin-block-end: 0.5em;">'.$n_vuelo.'</h5>
                                                                <small>'.$obj->no_fly.'</small>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                    ';
                }
                
                if ($obj->type_transfer == 'SEN/HA' || $obj->type_transfer == 'RED') {
                    $template.='
                                <tr>
                                    <td style="padding-left: 20px; padding-right: 20px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding:0px 5px 20px 5px;">
                                            <tr>
                                                <td style=" line-height: 0;" width="290">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <h5 style="margin-block-end: 0.5em;">'.$n_salida.'</h5>
                                                                <small><</small>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style=" line-height: 0; " width="170">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <h5 style="margin-block-end: 0.5em;">'.$n_aerolina.'</h5>
                                                                <small>'.$obj->airline_out.'</small>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style=" line-height: 0; " width="170">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <h5 style="margin-block-end: 0.5em;">'.$n_vuelo.'</h5>
                                                                <small>'.$obj->no_flyout.'</small>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                    ';
                }

                $template.= '
                                <tr>
                                    <td style="padding-left: 20px; padding-right: 20px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding:5px 5px 15px 5px;">
                                            <td style=" line-height: 0; text-align: center; " width="600">
                                                <table style="padding:10px 5px 0px 5px; border-bottom: 1px solid #E1423B;"cellpadding="0" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td align="left">
                                                            <h5 style="margin-block-end: 0.5em; color: #E1423B;;">'.$datos_cliente.'</h5>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-left: 20px; padding-right: 20px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding:0px 5px 20px 5px;">
                                            <tr>
                                                <td style=" line-height: 0;" width="250">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <h5 style="margin-block-end: 0.5em;">'.$n_nombre.'</h5>
                                                                <small>'.$obj->name_client.' '.$obj->last_name.'</small>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style=" line-height: 0; " width="170">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <h5 style="margin-block-end: 0.5em;">'.$n_email.'</h5>
                                                                <small>'.$obj->email_client.'</small>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style=" line-height: 0; " width="170">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <h5 style="margin-block-end: 0.5em;">'.$n_telefono.'</h5>
                                                                <small>'.$obj->phone_client.'</small>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style=" line-height: 0; " width="170">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <h5 style="margin-block-end: 0.5em;">'.$n_pais.'</h5>
                                                                <small>'.$obj->country_client.'</small>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-left: 20px; padding-right: 20px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding:0px 5px 20px 5px;">
                                            <tr>
                                                <td style=" line-height: 0;" width="700">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <h5 style="margin-block-end: 0.5em;">'.$n_comentarios.'</h5>
                                                                <small >'.$comments.'</small>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-left: 20px; padding-right: 20px;" id="me_pago">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding:5px 5px 15px 5px;">
                                            <td style=" line-height: 0; text-align: center; " width="600">
                                                <table style="padding:10px 5px 0px 5px; border-bottom: 1px solid #E1423B;"cellpadding="0" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td align="left">
                                                            <h5 style="margin-block-end: 0.5em; color: #E1423B;;">'.$datos_pago.'</h5>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </table>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #a5a5a5;">
                                    <td style="padding-left: 20px; padding-right: 20px; padding-bottom: 30px; ">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding:0px 5px 20px 5px; " class="mb-4">
                                            <tr>
                                                <td style=" line-height: 0;" width="290">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <h5 style="margin-block-end: 0.5em;">'.$n_mpego.'</h5>
                                                                <small>'.$method_payment.'</small>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style=" line-height: 0; " width="250">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <h5 style="margin-block-end: 0.5em;">'.$n_estado.'</h5>
                                                                <small>'.$typePayment.'</small>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style=" line-height: 0; " width="170">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                ';

                //Footer
                $template.= '
                            <div class="saltopagina"></div>
                            <table align="center"  cellpadding="0" cellspacing="0" width="700" class="table" id="table_ticket">
                                <tr>
                                    <td style="padding: 15px 10px 0 10px;" id="terms_conditions">
                                        '.$footer_letter.'
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td bgcolor="#414380" style="padding: 30px 30px 30px 30px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td width="75%" style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;">
                                                    <small>&reg; 2017 YAMEVI TRAVEL - Sistema de Agencias. Cancún Quintana Roo. México.</small><br/>
                                                    <small>Visitanos en <a href="https://www.yamevitravel.com/" style="color: #ffffff;"><font color="#ffffff">YameviTravel</font></a></small>
                                                </td>
                                                <td align="right">
                                                    <table border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>
                                                                <a href="http://www.instagram.com/">
                                                                    <img src="../assets/img/social/FontAwsome (instagram).png" alt="Instagram" width="25" height="25" style="display: block;" border="0" />
                                                                </a>
                                                            </td>
                                                            <td style="font-size: 0; line-height: 0;" width="20">
                                                                &nbsp;
                                                            </td>
                                                            <td>
                                                                <a href="http://www.facebook.com/">
                                                                <img src="../assets/img/social/FontAwsome (facebook).png" alt="Facebook" width="25" height="25" style="display: block;" border="0" />
                                                                </a>
                                                            </td>
                                                            <td style="font-size: 0; line-height: 0;" width="20">
                                                                &nbsp;
                                                            </td>
                                                            <td>
                                                                <a href="http://www.yamevitravel.com/">
                                                                <img src="../assets/img/social/FontAwsome (globe).png" alt="Pagina Web" width="25" height="25" style="display: block;" border="0" />
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>  
                            </table>
                        </body>
                    </html>
                ';
                if ($newticket == 'true') {
                    return $template;
                    exit;
                }
                
                //Send Mails
                $headerClient = 'MIME-Version:1.0'. "\r\n".
                'Content-Type: text/html; charset=UTF-8'."\r\n".
                'From: sales@yamevitravel.com' . "\r\n".
                'Reply-To: reservaciones@yamevitravel.com' . "\r\n";

                $headerSales = 'MIME-Version:1.0'. "\r\n".
                'Content-Type: text/html; charset=UTF-8'."\r\n".
                'From: sales@yamevitravel.com' . "\r\n".
                'Cc: luis.avila@yamevitravel.com.mx'. "\r\n".
                'Reply-To: '. $obj->email_client . "\r\n";


                if ($obj->method_payment == 'paypal') {
                    $headerPaypal = 'MIME-Version:1.0'. "\r\n".
                             'Content-Type: text/html; charset=UTF-8'."\r\n".
                             'From: sales@yamevitravel.com' . "\r\n".
                             'Reply-To: '. $obj->email_client . "\r\n";
                    if ($obj->status_reservation == 'RESERVED') {
                        return json_encode(array('invoice' => $obj->code_invoice, 'status' => 1));
                    }
                }
                if ($obj->method_payment == 'card') {
                    if ($obj->status_reservation == 'RESERVED') {
                        return json_encode(array('invoice' => $obj->code_invoice, 'status' => 1));
                    }
                    if ($obj->status_reservation == 'COMPLETED') {
                        //Cliente
                        //mail($obj->email_client, $subjectClient, $template, $headerClient);
                        //Ventas
                        //mail('reservaciones@yamevitravel.com', $subjectClient, $template, $headerSales);
                    }
                }else{
                    //mail($obj->email_client, $subjectClient, $template, $headerClient);
                    
                    //mail('reservaciones@yamevitravel.com', $subjectClient, $template,$headerSales);

                    return json_encode(array('invoice' => $obj->code_invoice, 'staus' => 1));
                }
            }
            //return $template;
        }
        
        function getFooterLetter($letter,$con){
            $letter_lang = mysqli_real_escape_string($con,$letter);
            $query ="SELECT * FROM letter WHERE language_type = '$letter_lang'";
            $resul = mysqli_query($con, $query);
            $footer = "0";
            if ($resul) {
                while ($row = mysqli_fetch_object($resul)) {
                    $footer = $row->footer;
                }
            }
            return $footer;
        }

        function getIcon($id_a,$con){
            if ($con != NULL) {
                $query = "SELECT icon_agency FROM agencies WHERE id_agency like $id_a";
                $result = mysqli_query($con, $query);
                $icon = "not_found.png";
                if ($result) {
                    while ($row =  mysqli_fetch_object($result)) {
                        $icon = $row->icon_agency;
                    }
                }
                return $icon;
            }
        }
        function changeStateSale($id, $sta){
            include('../config/conexion.php');
            $code_invoice = mysqli_real_escape_string($con, $id);
            $status = mysqli_real_escape_string($con, $sta);
            $response = false;
            $query = "UPDATE reservation SET status_reservation = $sta WHERE code_invoice like '$code_invoice'";
            $result = mysqli_query($con, $query);
            if ($result) {
                $response = true;
            }
            return $response;
        }
        function callToLetter($code_invoice, $letter_lang){
            include('../config/conexion.php');
            $id_reservation = $this->getIdReservation($code_invoice);
            $reservation = $this->createLetterConfirm($id_reservation,$letter_lang,$con,$ticket ="", $total="");
            return $reservation;
        }
        private function getIdReservation($invoice){
            include('../config/conexion.php');
            $code_invoice = mysqli_real_escape_string($con, $invoice);
            $query = "SELECT id_reservation FROM reservation WHERE code_invoice like '$code_invoice'";
            $result = mysqli_query($con, $query);
            if ($result) {
                $obj = mysqli_fetch_object($result_letter);
                $id_reservation = $obj->id_reservation;
            }
            return $id_reservation;
        }
        public function getLetterHtml($id_reservation, $total){
            $newtotal = 0;
            if ($total != '' || $total ==1) {
                $newtotal = $total;
            }
            include('../config/conexion.php');
            $new_id_res = MD5($id_reservation);
            $query = "SELECT id_reservation, type_language FROM reservations WHERE MD5(id_reservation) like '$new_id_res';";
            $result = mysqli_query($con, $query);
            if ($result) {
                $obj = mysqli_fetch_object($result);
                $id_reservation = $obj->id_reservation;
                $ticket = "true";
                return $this->createLetterConfirm($obj->id_reservation, $obj->type_language, $con, $ticket,$newtotal);
                exit;
            }
            return null;
        }
    }
?>