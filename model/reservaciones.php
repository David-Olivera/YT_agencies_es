<?php
    class Reservation{

        function loadFastAccess($id_agency){
            include('../config/conexion.php');
            $query_usuarios = "SELECT COUNT(*) as total FROM users WHERE id_agency = $id_agency;";
            $rs_u = mysqli_query($con, $query_usuarios);
            $row_u = mysqli_fetch_assoc($rs_u);

            $query_reservas = "SELECT COUNT(*) as total FROM reservations AS R INNER JOIN clients AS C ON R.id_client = C.id_client 
            INNER JOIN reservation_details AS D ON D.id_reservation = R.id_reservation 
            WHERE R.id_agency = $id_agency;";
            $rs_r = mysqli_query($con, $query_reservas);
            $row_r = mysqli_fetch_assoc($rs_r);

            $query_conci = "SELECT COUNT(*) as total FROM conciliation WHERE id_agency = $id_agency AND `status` = 1; ";
            $rs_con = mysqli_query($con, $query_conci);
            $row_c = mysqli_fetch_assoc($rs_con);

            $query_noconci = "SELECT COUNT(*) as total FROM conciliation WHERE id_agency =  $id_agency AND `status` = 0;";
            $rs_nocon = mysqli_query($con,$query_noconci);
            $row_nc = mysqli_fetch_assoc($rs_nocon);

            return json_encode(array('users' => $row_u['total'], 'reservations' => $row_r['total'], 'conciliations' => $row_c['total'], 'no_conciliations' => $row_nc['total']));
        }

        function get_pdf($id, $letter, $con){
            return $id.$letter;
        }
        //Get datas reservation
        public function getDetailsReservation($obj){
            $ins = json_decode($obj);
            include('../config/conexion.php');
            $newid= $ins->id;
            if ($obj) {
                $query = "SELECT * FROM clients as C
                INNER JOIN reservations AS R ON C.id_client = R.id_client
                INNER JOIN reservation_details AS D ON D.id_reservation = R.id_reservation
                WHERE R.id_reservation = $newid;";
                $result = mysqli_query($con, $query);
                if (!$result) {
                    die('Error de consulta'. mysqli_error($con));
                }
                $json=array();
                while($row=mysqli_fetch_array($result)){
                    
                    // PICKUP INTERHOTEL
                    $arrivalTimeArgs = explode(' ', $row['time_arrival']);
                    $arrivalTimeArgs = explode(':', $arrivalTimeArgs[0]);
    
                    $arrivalTimeArgs_ex = explode(' ', $row['time_exit']);
                    $arrivalTimeArgs_ex = explode(':', $arrivalTimeArgs_ex[0]);
    
 
                    $json[]= array(
                        'code_invoice' => $row['code_invoice'],
                        'type_currency' => $row['type_currency'],
                        'method_payment' => $row['method_payment'],
                        'code_client' => $row['code_client'],
                        'name_advisor' => $row['name_advisor'],
                        'id_agency' => $row['id_agency'],
                        'of_the_agency' => $row['of_the_agency'],
                        'transfer_destiny' => $row['transfer_destiny'],
                        'destiny_interhotel' => $row['destiny_interhotel'],
                        'type_transfer' => $row['type_transfer'],
                        'type_service' => $row['type_service'],
                        'number_adults' => $row['number_adults'],
                        'airline_in' => $row['airline_in'],
                        'no_fly' => $row['no_fly'],
                        'airline_out' => $row['airline_out'],
                        'no_flyout' => $row['no_flyout'],
                        'date_arrival' => $row['date_arrival'],
                        'date_exit' => $row['date_exit'],
                        'time_hour_arrival' => $arrivalTimeArgs[0],
                        'time_min_arrival' =>$arrivalTimeArgs[1],
                        'time_hour_exit' =>$arrivalTimeArgs_ex[0],
                        'time_min_exit' => $arrivalTimeArgs_ex[1],
                        'time_service' => $row['time_service'],
                        'date_register_reservation' => $row['date_register_reservation'],
                        'status_reservation' => $row['status_reservation'],
                        'agency_commision' => $row['agency_commision'],
                        'total_cost_commision' => $row['total_cost_commision'],
                        'total_cost' => $row['total_cost'],
                        'name_client' => $row['name_client'],
                        'last_name' => $row['last_name'],
                        'mother_lastname' => $row['mother_lastname'],
                        'phone_client' => $row['phone_client'],
                        'email_client' => $row['email_client'],
                        'country_client' => $row['country_client'],
                        'comments_client' => $row['comments_client']
                    );
                }
                $jsonStrig = json_encode($json[0]);
                echo $jsonStrig; 
            }
        }
        public function updateReservationState($obj){
            $ins = json_decode($obj);
            include('../config/conexion.php');
            $id_reservation = $ins->{'id_reservation'};
            $state = $ins->{'state'};
            $status = 0;
            $query = "UPDATE reservations SET status_reservation = '$state' WHERE MD5(id_reservation) = '$id_reservation';";
            $result = mysqli_query($con, $query);
            if ($result) {
                $status = 1;
            }
            return $status;
        }

        public function update_traslado($obj){
            $ins = json_decode($obj);
            include('../config/conexion.php');
            $id_reservation = $ins->{'id_reservation'};
            $code_invoice = $ins->{'code_invoice'};
            $co_yt = $ins->{'co_yt'}; 
            $code_client= $ins->{'code_client'}; 
            $name_asesor = $ins->{'name_asesor'};  
            $of_the_agency = $ins->{'of_the_agency'};
            $name_hotel = mysqli_real_escape_string($con,$ins->{'name_hotel'});
            $name_hotel_interhotel = mysqli_real_escape_string($con,$ins->{'name_hotel_interhotel'});
            $type_traslado = $ins->{'type_traslado'};
            $type_service = $ins->{'type_service'};
            $num_pasajeros = $ins->{'num_pasajeros'};
            $date_arrival = $ins->{'date_arrival'};
            $airline_arrival = $ins->{'airline_arrival'};
            $no_fly_arrival = $ins->{'no_fly_arrival'};
            $time_entry = mysqli_real_escape_string($con,$ins->{'time'});
            $time_exit = mysqli_real_escape_string($con,$ins->{'time_exit'});
            $time_hour_arrival = $ins->{'time_hour_arrival'};
            $time_minute_arrival = $ins->{'time_minute_arrival'};
            $date_exit = $ins->{'date_exit'};
            $airline_exit =  $ins->{'airline_exit'};
            $time_service = $ins->{'time_service'};
            $no_fly_exit = $ins->{'no_fly_exit'};
            $time_hour_exit =  $ins->{'time_hour_exit'};
            $time_minute_exit = $ins->{'time_minute_exit'}; 
            $time_pickup = $ins->{'time_pickup'};
            $time_pickup_inter = $ins->{'time_pickup_inter'};
            $method_payment = $ins->{'method_payment'};
            $sub_total = $ins->{'sub_total'};
            $commission = $ins->{'commission'};
            $total_cost_comision = $ins->{'total_cost_comision'};
            $currency = $ins->{'currency'};
            $name_client = mysqli_real_escape_string($con,$ins->{'name_client'});
            $last_name = mysqli_real_escape_string($con,$ins->{'last_name'});
            $mother_lastname = mysqli_real_escape_string($con,$ins->{'mother_lastname'});
            $email_client = mysqli_real_escape_string($con,$ins->{'email_client'}); 
            $phone_client = mysqli_real_escape_string($con,$ins->{'phone_client'});
            $special_request = mysqli_real_escape_string($con,$ins->{'special_request'});
            // Con comision
            $newvalue = "";
            // Sin comision neta
            $new_cost ="";
            $error = 0;
            //Validamos si es Inter Hotel
            if ($type_traslado == 'REDHH' || $type_traslado == 'SEN/HH') {
                return $this->getServiceListHotelHotel($ins, $con);
                exit;
            }
            //Verificamos existencia de hotel
            if ($this->verifyDestionation($name_hotel, $con) == false) {
                return NULL;
                exit;
            }
            //Obetnemos el tipo de moneda
            $moneda = $this->getDivisa('mxn', $con);
            //Verificacion de tipo de servicio de traslado
            switch ($ins->{'type_traslado'}) {
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
            $new_time_en = "";
            $new_time_ex = "";
            $new_date_en = "";
            $new_date_ex = "";
            if ($type_traslado == 'SEN/HA' ) {
                $new_time_en = $time_entry;
                $new_time_ex = $time_exit;
                $new_date_ex = $date_exit;
                $new_date_en = "";

            }
            if ($type_traslado == 'RED') {
                $new_date_en = $date_arrival;
                $new_date_ex = $date_exit;
                $new_time_en = $time_entry;
                $new_time_ex = $time_exit;

            }
            if ($type_traslado == 'SEN/AH' ) {
                $new_time_en = $time_entry;
                $new_time_ex = $time_exit;
                $new_date_ex = "";
                $new_date_en = $date_arrival;
            }
            if ($type_traslado == 'SEN/HH' ) {
                $new_time_en = $time_pickup;
                $new_time_ex = $time_pickup_inter;
                $new_date_ex = "";
                $new_date_en = $date_arrival;
            }
            if ($type_traslado == 'REDHH') {
                $new_time_en = $time_pickup;
                $new_time_ex = $time_pickup_inter;
                $new_date_ex = $date_exit;
                $new_date_en = $date_arrival;

            }
            //Obtenemos zona de destino
            $zona = json_decode($this->getAreaDestination($name_hotel, $con));
            //Obtenemos la tarifa de la zona
            $rates = json_decode($this->getRateArea($zona->{'id_zone'}, $con));  
            $div_price = "";
            //Compartido
            if ($type_service == 'compartido') {
                if(intval($rates[0]->{'shared'}->{'oneway'}) > 0 && $rates[0]->{'shared'}->{'oneway'} != NULL ) {    
                    $rates_shared_rt =  "";
                    $rates_shared_ow =  "";
                    $div_prices_shared = "";
                    if ($type_traslado == 'RED') {
                        $rates_shared_ow = $rates[0]->{'shared'}->{'oneway'};
                        $rates_shared_rt = $rates[0]->{'shared'}->{'roundtrip'};
                        $rate_service_rt = $rates_shared_rt * $num_pasajeros;
                        $rate_service_ow = $rates_shared_ow * $num_pasajeros;
                        if ($currency == 'mx') {
                            $div_price = round($rate_service_rt, 2);
                        }
                        if ($currency == 'us') {
                            $div_price = round($rate_service_rt / $moneda,0);
                        }
                    }else{
                        $rates_shared_ow = $rates[0]->{'shared'}->{'oneway'};
                        $rates_shared_rt = $rates[0]->{'shared'}->{'roundtrip'};
                        $rate_service_rt = $rates_shared_rt * $num_pasajeros;
                        $rate_service_ow = $rates_shared_ow * $num_pasajeros;
                        if ($currency == 'mx') {
                            $div_price = round($rate_service_ow, 2);
                        }
                        if ($currency == 'us') {
                            $div_price = round($rate_service_ow / $moneda,0);
                        }
                    }
                }
            }
            //Privado
            if ($type_service == 'privado') {
                if (intval($rates[0]->{'private'}->{'privado_ow_1'}) > 0 && $rates[0]->{'private'}->{'privado_ow_1'} != NULL) {
                    $rates_private_ow = "";
                    $rates_private_rt = "";
                    $div_prices_private = "";
                    if ($num_pasajeros >=1 && $num_pasajeros <=4) {
                        $rates_private_ow = $rates[0]->{'private'}->{'privado_ow_1'} ;
                        $rates_private_rt = $rates[0]->{'private'}->{'privado_rt_1'};
                    }
                    if ($num_pasajeros >=5 && $num_pasajeros <=6) {
                        $rates_private_ow = $rates[0]->{'private'}->{'privado_ow_2'} ;
                        $rates_private_rt = $rates[0]->{'private'}->{'privado_rt_2'};
                    }
                    if ($num_pasajeros >=7 && $num_pasajeros <=8) {
                        $rates_private_ow = $rates[0]->{'private'}->{'privado_ow_3'} ;
                        $rates_private_rt = $rates[0]->{'private'}->{'privado_rt_3'};
                    }
                    if ($num_pasajeros >=9 && $num_pasajeros <=10) {
                        $rates_private_ow = $rates[0]->{'private'}->{'privado_ow_4'} ;
                        $rates_private_rt = $rates[0]->{'private'}->{'privado_rt_4'};
                    }
                    if ($num_pasajeros >10 && $num_pasajeros <=11) {
                        $rates_private_ow = $rates[0]->{'private'}->{'privado_ow_5'} ;
                        $rates_private_rt = $rates[0]->{'private'}->{'privado_rt_5'};
                    }
                    if ($num_pasajeros >=12 && $num_pasajeros <=16) {
                        $rates_private_ow = $rates[0]->{'private'}->{'privado_ow_6'} ;
                        $rates_private_rt = $rates[0]->{'private'}->{'privado_rt_6'};
                    }
                    if ($type_traslado == 'RED') {
                        if ($currency == 'mx') {
                            $div_price = round($rates_private_rt, 2);
                        }
                        if ($currency == 'us') {
                            $div_price = round($rates_private_rt / $moneda,0);
                        }
                    }else{
                        if ($currency == 'mx') {
                            $div_price = round($rates_private_ow, 2);
                        }
                        if ($currency == 'us') {
                            $div_price = round($rates_private_ow / $moneda,0);
                        }
                    }
                }
            }
            //Lujo
            if ($type_service == 'lujo') {
                if (intval($rates[0]->{'luxury'}->{'lujo_ow_1'}) > 0 && $rates[0]->{'luxury'}->{'lujo_ow_1'} != NULL && $num_pasajeros <=6) {
                    $rates_luxury_ow = "";
                    $rates_luxury_rt = "";
                    $div_prices_luxury = "";
                    if ($num_pasajeros >=1 && $num_pasajeros <=6) {
                        $rates_luxury_ow = $rates[0]->{'luxury'}->{'lujo_ow_1'} ;
                        $rates_luxury_rt = $rates[0]->{'luxury'}->{'lujo_rt_1'};
                    }
                    if ($type_traslado == 'RED') {
                        
                        if ($currency == 'mx') {
                            $div_price = round($rates_luxury_rt, 2);
                        }
                        if ($currency == 'us') {
                            $div_price = round($rates_luxury_rt / $moneda,0);
                        }
                    }else{
                        if ($currency == 'mx') {
                            $div_price = round($rates_luxury_ow, 2);
                        }
                        if ($currency == 'us') {
                            $div_price = round($rates_luxury_ow / $moneda,0);
                        }
                    }
                }
            }
            if ($method_payment == 'card' || $method_payment == 'paypal') {
                
                $cargo = 0.95;
                $add_cargo = $div_price / $cargo;
                $sum = $commission + $add_cargo;
                $new_cost = $div_price;
                $newvalue = number_format($sum, 2, '.', '');
            }else{            
                $new_cost = number_format($div_price, 2, '.', '');
                $newvalue = number_format($div_price, 2, '.', '');
            }
            $update_oftheagency = "";
            if ($of_the_agency) {
                $update_oftheagency = ",of_the_agency = $of_the_agency";
            }
            $query = "SELECT * FROM reservations AS R INNER JOIN reservation_details AS RD ON R.id_reservation = RD.id_reservation
            INNER JOIN clients AS C ON R.id_client = C.id_client WHERE R.id_reservation = $id_reservation;";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_assoc($result);
            $id_client_e = $row['id_client'];
            $json = array();
            if ($newvalue != "" || $new_cost != "") {
                //Insertamos datos Clientes
                $query_client = "UPDATE clients SET code_client= '$code_client', name_advisor = '$name_asesor',name_client = '$name_client',last_name = '$last_name',mother_lastname = '$mother_lastname',email_client = '$email_client',phone_client = '$phone_client',comments_client = '$special_request' WHERE id_client = $id_client_e;";
                $result_client = mysqli_query($con, $query_client);
                //Insertamos datos Reserva
                $query_reserva = "UPDATE reservations SET type_transfer = '$type_traslado', airline_in = '$airline_arrival', no_fly = '$no_fly_arrival', airline_out = '$airline_exit', no_flyout = '$no_fly_exit', transfer_destiny = '$name_hotel',destiny_interhotel = '$name_hotel_interhotel' $update_oftheagency where id_reservation = $id_reservation;";
                $result_reserv = mysqli_query($con, $query_reserva);
                //Insertamos datos Detalles Reserva
                $query_detalles = "UPDATE reservation_details SET date_arrival = '$new_date_en',date_exit = '$new_date_ex', time_arrival = '$new_time_en', time_exit = '$new_time_ex', time_service = '$time_service', number_adults = $num_pasajeros, agency_commision = '$commission', total_cost_commision = $newvalue, total_cost = $new_cost, type_service = '$type_service' , method_payment = '$method_payment'  WHERE id_reservation = $id_reservation;";
                $result_detalles = mysqli_query($con, $query_detalles);
                //Insertamos datos Conciliacion.
                $status_c = 0;
                $query = "";
                $sql_uconci = "";
                $query_res = "";
                $status_reserva = "";
                
                //COMPROBAMOS SI YA ESTA CONCILIADO
                $query_com_ope = "SELECT * FROM conciliation WHERE id_reservation = $id_reservation;";
                $reseult_com_ope = mysqli_query($con, $query_com_ope);
                $row_com_ope = mysqli_fetch_assoc($reseult_com_ope);
                if ($row_com_ope['status'] == 1) {
                    if ($method_payment =='card' || $method_payment == 'paypal') {
                        if ($newvalue > $total_cost_comision || $new_cost > $total_cost_comision) {
                            $status_c = 0;
                            $status_reserva = "RESERVED";
                        }
                        if ($newvalue <= $total_cost_comision || $new_cost <= $total_cost_comision || $newvalue == $total_cost_comision || $new_cost == $total_cost_comision) {
                            $status_c = 1;
                            $status_reserva = "COMPLETED";
                        }
                        $query_conci = "SELECT * FROM conciliation WHERE id_reservation = $id_reservation;";
                        $result_conci = mysqli_query($con, $query_conci);
                        if ($result_conci) {
                            $ins_sql = mysqli_fetch_object($result_conci);
                            $sql_uconci = "UPDATE conciliation SET status = $status_c WHERE id_reservation = $id_reservation;";
                            $result_uconci = mysqli_query($con, $sql_uconci);
                            $query_res = "UPDATE reservations SET status_reservation = '$status_reserva' WHERE id_reservation like $id_reservation;";
                            $result_res = mysqli_query($con, $query_res);
                                
                        }
                    }else{
                        if ($newvalue > $sub_total || $new_cost > $sub_total) {
                            $status_c = 0;
                            $status_reserva = "RESERVED";
                        }
                        if ($newvalue <= $sub_total || $new_cost <= $sub_total) {
                            $status_c = 1;
                            $status_reserva = "COMPLETED";
                        }
                        $query_conci = "SELECT * FROM conciliation WHERE id_reservation = $id_reservation;";
                        $result_conci = mysqli_query($con, $query_conci);
                        if ($result_conci) {
                            $ins_sql = mysqli_fetch_object($result_conci);
                            $sql_uconci = "UPDATE conciliation SET status = $status_c WHERE id_reservation = $id_reservation;";
                            $result_uconci = mysqli_query($con, $sql_uconci);
                            $query_res = "UPDATE reservations SET status_reservation = '$status_reserva' WHERE id_reservation like $id_reservation;";
                            $result_res = mysqli_query($con, $query_res);
                        }
    
                    }
                }
                $error = 1;
                $json = array(
                    'total_cost_commision' => $newvalue,
                    'total_cost' => $new_cost,
                    'error' => $error,
                    'sql' => $query_reserva
                );
                $jsonString = json_encode($json);
                echo $jsonString;
            }else{               
                $json = array(
                    'total_cost_commision' => '0',
                    'total_cost' => '0',
                    'error' => $error,
                    'sql' => $query_reserva
                );
                $jsonString = json_encode($json);
                echo $jsonString;
            }
            /* Cierra la conexión */
            mysqli_close($con);
        }
        function getServiceListHotelHotel($ins, $con){
            include('../config/conexion.php');
            $id_reservation = $ins->{'id_reservation'};
            $code_invoice = $ins->{'code_invoice'};
            $co_yt = $ins->{'co_yt'}; 
            $code_client= $ins->{'code_client'}; 
            $name_asesor = $ins->{'name_asesor'};  
            $of_the_agency = $ins->{'of_the_agency'};
            $name_hotel = mysqli_real_escape_string($con,$ins->{'name_hotel'});
            $name_hotel_interhotel = mysqli_real_escape_string($con,$ins->{'name_hotel_interhotel'});
            $type_traslado = $ins->{'type_traslado'};
            $type_service = $ins->{'type_service'};
            $num_pasajeros = $ins->{'num_pasajeros'};
            $date_arrival = $ins->{'date_arrival'};
            $airline_arrival = $ins->{'airline_arrival'};
            $no_fly_arrival = $ins->{'no_fly_arrival'};
            $time_entry = mysqli_real_escape_string($con,$ins->{'time'});
            $time_exit = mysqli_real_escape_string($con,$ins->{'time_exit'});
            $time_hour_arrival = $ins->{'time_hour_arrival'};
            $time_minute_arrival = $ins->{'time_minute_arrival'};
            $date_exit = $ins->{'date_exit'};
            $airline_exit =  $ins->{'airline_exit'};
            $no_fly_exit = $ins->{'no_fly_exit'};
            $time_hour_exit =  $ins->{'time_hour_exit'};
            $time_minute_exit = $ins->{'time_minute_exit'}; 
            $time_pickup = $ins->{'time_pickup'};
            $time_pickup_inter = $ins->{'time_pickup_inter'};
            $time_service = $ins->{'time_service'};
            $method_payment = $ins->{'method_payment'};
            $sub_total = $ins->{'sub_total'};
            $commission = $ins->{'commission'};
            $total_cost_comision = $ins->{'total_cost_comision'};
            $currency = $ins->{'currency'};
            $name_client = mysqli_real_escape_string($con,$ins->{'name_client'});
            $last_name = mysqli_real_escape_string($con,$ins->{'last_name'});
            $mother_lastname = mysqli_real_escape_string($con,$ins->{'mother_lastname'});
            $email_client = mysqli_real_escape_string($con,$ins->{'email_client'}); 
            $phone_client = mysqli_real_escape_string($con,$ins->{'phone_client'});
            $special_request = mysqli_real_escape_string($con,$ins->{'special_request'});
            $newvalue = 0;
            $error = 0;
            $new_cost =0;
            $div_price ="";
            //Obetnemos el tipo de moneda
            $moneda = $this->getDivisa('mxn', $con);
             
            //Verificacion de tipo de servicio de traslado
            switch ($ins->{'type_traslado'}) {
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

           $new_time_en = "";
           $new_time_ex = "";
           $new_date_en = "";
           $new_date_ex = "";
           if ($type_traslado == 'SEN/HA' ) {
               $new_time_en = $time_entry;
               $new_time_ex = $time_exit;
               $new_date_ex = $date_exit;
               $new_date_en = "";

           }
           if ($type_traslado == 'RED') {
               $new_date_en = $date_arrival;
               $new_date_ex = $date_exit;
               $new_time_en = $time_entry;
               $new_time_ex = $time_exit;

           }
           if ($type_traslado == 'SEN/AH' ) {
               $new_time_en = $time_entry;
               $new_time_ex = $time_exit;
               $new_date_ex = "";
               $new_date_en = $date_arrival;
           }
           if ($type_traslado == 'SEN/HH' ) {
               $new_time_en = $time_pickup;
               $new_time_ex = $time_pickup_inter;
               $new_date_ex = "";
               $new_date_en = $date_arrival;
           }
           if ($type_traslado == 'REDHH') {
               $new_time_en = $time_pickup;
               $new_time_ex = $time_pickup_inter;
               $new_date_ex = $date_exit;
               $new_date_en = $date_arrival;

           }
            //Obtenemos zona de origen
            $zona = json_decode($this->getAreaDestination($ins->{'name_hotel'}, $con));
            //Obtenemos la tarifa de la zona
            $rates = json_decode($this->getRateArea($zona->{'id_zone'}, $con));  
             
            $zona_interhotel = '';
            $rates_interhotel = '';
            if ($ins->{'name_hotel_interhotel'}) {
                //Obtenemos zona de destino
                $zona_interhotel = json_decode($this->getAreaDestination($ins->{'name_hotel_interhotel'}, $con));
                //Obtenemos la tarifa de la zona
                $rates_interhotel = json_decode($this->getRateArea($zona_interhotel->{'id_zone'}, $con));  
                
            }
            //Cargo adicional al encontrarse a una distancia muy larga de 20%
            $additional_charge = 0;
            if ($zona->{'additional_charge'} != $zona_interhotel->{'additional_charge'}) {
                $additional_charge = 0.80;
            }

            //Privado
            if ($type_service == 'privado') {
                if (intval($rates[0]->{'private'}->{'privado_ow_1'}) > 0 && $rates[0]->{'private'}->{'privado_ow_1'} != NULL) {
                    $rates_private_rt =  "";
                    $rates_private_ow =  "";
                    $rates_private_rt_2 =  "";
                    $rates_private_ow_2 =  "";
                    $div_prices_private = "";
                    $new_rate_rt = '';
                    $new_rate_ow = '';
                    if ($num_pasajeros >=1 && $num_pasajeros <=4) {
                        //Hotel 1
                        $rates_private_ow = $rates[0]->{'private'}->{'privado_ow_1'} ;
                        $rates_private_rt = $rates[0]->{'private'}->{'privado_rt_1'};
                        //Hotel 2
                        $rates_private_ow_2 = $rates_interhotel[0]->{'private'}->{'privado_ow_1'};
                        $rates_private_rt_2 = $rates_interhotel[0]->{'private'}->{'privado_rt_1'};
    
                    }
                    if ($num_pasajeros >=5 && $num_pasajeros <=6) {
                        $rates_private_ow = $rates[0]->{'private'}->{'privado_ow_2'} ;
                        $rates_private_rt = $rates[0]->{'private'}->{'privado_rt_2'};
                        
                        $rates_private_ow_2 = $rates_interhotel[0]->{'private'}->{'privado_ow_2'} ;
                        $rates_private_rt_2 = $rates_interhotel[0]->{'private'}->{'privado_rt_2'};
                    }
                    if ($num_pasajeros >=7 && $num_pasajeros <=8) {
                        $rates_private_ow = $rates[0]->{'private'}->{'privado_ow_3'} ;
                        $rates_private_rt = $rates[0]->{'private'}->{'privado_rt_3'};
                        
                        $rates_private_ow_2 = $rates_interhotel[0]->{'private'}->{'privado_ow_3'} ;
                        $rates_private_rt_2 = $rates_interhotel[0]->{'private'}->{'privado_rt_3'};
                    }
                    if ($num_pasajeros >=9 && $num_pasajeros <=10) {
                        $rates_private_ow = $rates[0]->{'private'}->{'privado_ow_4'} ;
                        $rates_private_rt = $rates[0]->{'private'}->{'privado_rt_4'};
                        
                        $rates_private_ow_2 = $rates_interhotel[0]->{'private'}->{'privado_ow_4'} ;
                        $rates_private_rt_2 = $rates_interhotel[0]->{'private'}->{'privado_rt_4'};
                    }
                    if ($num_pasajeros >10 && $num_pasajeros <=11) {
                        $rates_private_ow = $rates[0]->{'private'}->{'privado_ow_5'} ;
                        $rates_private_rt = $rates[0]->{'private'}->{'privado_rt_5'};
                        
                        $rates_private_ow_2 = $rates_interhotel[0]->{'private'}->{'privado_ow_5'} ;
                        $rates_private_rt_2 = $rates_interhotel[0]->{'private'}->{'privado_rt_5'};
                    }
                    if ($num_pasajeros >=12 && $num_pasajeros <=16) {
                        $rates_private_ow = $rates[0]->{'private'}->{'privado_ow_6'} ;
                        $rates_private_rt = $rates[0]->{'private'}->{'privado_rt_6'};
                        
                        $rates_private_ow_2 = $rates_interhotel[0]->{'private'}->{'privado_ow_6'} ;
                        $rates_private_rt_2 = $rates_interhotel[0]->{'private'}->{'privado_rt_6'};
                    }
                    if ($type_traslado == 'REDHH') {
                        if ($currency == 'mx') {
                            $div_price = round($rates_private_rt, 2);
                        }
                        if ($currency == 'us') {
                            $div_price = round($rates_private_rt / $moneda,0);
                        }
                    }else{
                        if ($currency == 'mx') {
                            $div_price = round($rates_private_ow, 2);
                        }
                        if ($currency == 'us') {
                            $div_price = round($rates_private_ow / $moneda,0);
                        }
                    }
                    if ($type_traslado == 'REDHH') {
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
                        if ($currency == 'mx') {
                            $div_price = round($new_rate_additional_charge_rt, 2);
                        }
                        if ($currency == 'us') {
                            $div_price = round($new_rate_additional_charge_rt / $moneda,0);
                        }
                        
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
                        if ($currency == 'mx') {
                            $div_price = round($new_rate_additional_charge_ow, 2);
                        }
                        if ($currency == 'us') {
                            $div_price = round($new_rate_additional_charge_ow / $moneda,0);
                        }
                    }
                }
            }

            //Lujo
            if ($type_service == 'lujo') {
                if (intval($rates[0]->{'luxury'}->{'lujo_ow_1'}) > 0 && $rates[0]->{'luxury'}->{'lujo_ow_1'} != NULL && $num_pasajeros <=6) {
                    $rates_luxury_ow = "";
                    $rates_luxury_rt = "";
                    $rates_luxury_ow_2 = "";
                    $rates_luxury_rt_2 = "";
                    $div_prices_luxury = "";
                    if ($num_pasajeros >=1 && $num_pasajeros <=6) {
                        $rates_luxury_ow = $rates[0]->{'luxury'}->{'lujo_ow_1'} ;
                        $rates_luxury_rt = $rates[0]->{'luxury'}->{'lujo_rt_1'};
    
                        $rates_luxury_ow_2 = $rates_interhotel[0]->{'luxury'}->{'lujo_ow_1'} ;
                        $rates_luxury_rt_2 = $rates_interhotel[0]->{'luxury'}->{'lujo_rt_1'};
                    }
                    if ($type_traslado == 'REDHH') {
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
                        
                        if ($currency == 'mx') {
                            $div_price = round($new_rate_additional_charge_rt, 2);
                        }
                        if ($currency == 'us') {
                            $div_price = round($new_rate_additional_charge_rt / $moneda,0);
                        }
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
                        if ($currency == 'mx') {
                            $div_price = round($new_rate_additional_charge_ow, 2);
                        }
                        if ($currency == 'us') {
                            $div_price = round($new_rate_additional_charge_ow / $moneda,0);
                        }
                    }
                }
            }
            
            if ($method_payment == 'card' || $method_payment == 'paypal') {
                $sum = $commission + $div_price;
                $new_cost = $div_price;
                $newvalue = number_format($sum, 2, '.', '');
            }else{            
                $new_cost = number_format($div_price, 2, '.', '');
                $newvalue = number_format($div_price, 2, '.', '');
            }
            
            $query = "SELECT * FROM reservations AS R INNER JOIN reservation_details AS RD ON R.id_reservation = RD.id_reservation
            INNER JOIN clients AS C ON R.id_client = C.id_client WHERE R.id_reservation = $id_reservation;";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_assoc($result);
            $id_client_e = $row['id_client'];
            $json = array();
            if ($newvalue != 0 || $new_cost != 0) {
                //Insertamos datos Clientes
                $query_client = "UPDATE clients SET code_client= '$code_client', name_advisor = '$name_asesor',name_client = '$name_client',last_name = '$last_name',mother_lastname = '$mother_lastname',email_client = '$email_client',phone_client = '$phone_client',comments_client = '$special_request' WHERE id_client = $id_client_e;";
                $result_client = mysqli_query($con, $query_client);
                //Insertamos datos Reserva
                $query_reserva = "UPDATE reservations SET type_transfer = '$type_traslado', airline_in = '$airline_arrival', no_fly = '$no_fly_arrival', airline_out = '$airline_exit', no_flyout = '$no_fly_exit', transfer_destiny = '$name_hotel',destiny_interhotel = '$name_hotel_interhotel',of_the_agency = $of_the_agency where id_reservation = $id_reservation;";
                $result_reserv = mysqli_query($con, $query_reserva);
                //Insertamos datos Detalles Reserva
                $query_detalles = "UPDATE reservation_details SET date_arrival = '$new_date_en',date_exit = '$new_date_ex', time_arrival = '$new_time_en', time_exit = '$new_time_ex', time_service = '$time_service', number_adults = $num_pasajeros, agency_commision = '$commission', total_cost_commision = '$newvalue', total_cost = '$new_cost', type_service = '$type_service', method_payment = '$method_payment' ,pickup_entry = '$time_pickup',pickup= '$time_pickup_inter' WHERE id_reservation = $id_reservation;";
                $result_detalles = mysqli_query($con, $query_detalles);
                //Insertamos datos Conciliacion
                $status_c = 0;
                $query = "";
                $sql_uconci = "";
                $query_res = "";
                $status_reserva = "";

                //COMPROBAMOS SI YA ESTA CONCILIADO
                $query_com_ope = "SELECT * FROM conciliation WHERE id_reservation like $id_reservation;";
                $reseult_com_ope = mysqli_query($con, $query_com_ope);
                $row_com_ope = mysqli_fetch_assoc($reseult_com_ope);
                if ($row_com_ope['status'] == 1) {

                    if ($method_payment =='card' || $method_payment == 'paypal') {
                        if ($newvalue > $total_cost_comision || $new_cost > $total_cost_comision) {
                            $status_c = 0;
                            $status_reserva = "RESERVED";
                        }
                        if ($newvalue < $total_cost_comision || $new_cost < $total_cost_comision || $newvalue == $total_cost_comision || $new_cost == $total_cost_comision) {
                            $status_c = 1;
                            $status_reserva = "COMPLETED";
                        }
                        $query_conci = "SELECT * FROM conciliation WHERE id_reservation = $id_reservation;";
                        $result_conci = mysqli_query($con, $query_conci);
                        if ($result_conci) {
                            $sql_uconci = "UPDATE conciliation SET status = $status_c WHERE id_reservation = $id_reservation;";
                            $result_uconci = mysqli_query($con, $sql_uconci);
                            $query_res = "UPDATE reservations SET status_reservation = '$status_reserva' WHERE id_reservation like $id_reservation;";
                            $result_res = mysqli_query($con, $query_res);
                        }
                    }else{
                        if ($newvalue > $sub_total || $new_cost > $sub_total) {
                            $status_c = 0;
                            $status_reserva = "RESERVED";
                        }
                        if ($newvalue <= $sub_total || $new_cost <= $sub_total) {
                            $status_c = 1;
                            $status_reserva = "COMPLETED";
                        }
                        $query_conci = "SELECT * FROM conciliation WHERE id_reservation = $id_reservation;";
                        $result_conci = mysqli_query($con, $query_conci);
                        if ($result_conci) {
                            $sql_uconci = "UPDATE conciliation SET status = $status_c WHERE id_reservation = $id_reservation;";
                            $result_uconci = mysqli_query($con, $sql_uconci);
                            $query_res = "UPDATE reservations SET status_reservation = '$status_reserva' WHERE id_reservation like $id_reservation;";
                            $result_res = mysqli_query($con, $query_res);
                                
                        }
    
                    }
                }


                $error = 1;
                $json = array(
                    'total_cost_commision' => $newvalue,
                    'total_cost' => $new_cost,
                    'error' => $error,
                    'sql' => $query_detalles
                );
                $jsonString = json_encode($json);
                echo $jsonString;
            }else{               
                $json = array(
                    'total_cost_commision' => '0',
                    'total_cost' => '0',
                    'error' => $error,
                    'sql' => $query_detalles
                );
                $jsonString = json_encode($json);
                echo $jsonString;
            }
            /* Cierra la conexión */
            mysqli_close($con);
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
    }
?>