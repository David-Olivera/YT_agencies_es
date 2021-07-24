
<?php
require_once '../../YameviTravel/config/conexion.php';
session_start();
$internal_yt = $_SESSION['yt_internal_yt'];
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
                <div id="content_edit_reserva" class="container pb-3">
                    <h4 id="title_reservation"></h4>
                    <div class="form_edit_reserva">
                        <input type="hidden" name="" id="inp_code_invoice_edit" >
                        <input type="hidden" name="" id="inp_id_reservation">
                        <input type="hidden" name="" id="inp_id_agencie" value="<?php echo $_SESSION['yt_id_agency']?>">
                        <div class="p-2"  id="close_edit_reserva">
                            <button type="button" class="close pr-3 pl-3 pt-2 pb-2 close_content_edit_reserva">&times;</button>
                        </div>
                        <form id="form-content-edit-agencie">
                            <input type="hidden" class="form-control form-control-sm" id="inp_code_invoice" placeholder="ID de reserva externa" >
                            <?php if($internal_yt == 1) {?>
                            <div id="code_booking">
                                <div class="d-flex justify-content-center row" >
                                    <div class="col-xl-12 col-md-12 content_type_info">
                                        <h6>DATOS DE CODIGO DE RESERVA EXTERNA / (Solo Yamevi)</h6>
                                    </div>
                                    <div class="col-xl-12 pt-3">
                                                <div class="form-row">
                                                    <div class="form-group col-md-3" id="content_inp_code_client">
                                                        <label for="">Localizador</label>
                                                        <input type="text" class="form-control form-control-sm" id="inp_code_client_edit" placeholder="ID de reserva externa" >
                                                    </div>
                                                    <div class="form-group col-md-3" id="content_inp_asesor">
                                                        <label for="">Asesor</label>
                                                        <input type="text" class="form-control form-control-sm" id="inp_asesor_edit" placeholder="Nombre de Asesor de Venta" >
                                                    </div>
                                                    <div class="form-group col-md-3" id="content_inp_ofagencie">
                                                        <label for="">De la Agencia</label>
                                                        <input list="agencies" name="agencies" id="inp_ofagency_edit" type="text" class="form-control form-control-sm w-100" placeholder="Selaña la agencia" >
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
                            <?php }?>
                            <div class="d-flex justify-content-center row">
                                <div class="col-xl-12 col-md-12 content_type_info">
                                    <h6>DATOS DE TRASLADO</h6>
                                </div>
                                <div class="col-xl-12 pt-2">
                                            <div class="form_details">
                                                <div class="form-row">
                                                    <div class="form-group col-md-3">
                                                        <label for="">Hotel</label>
                                                        <input list="encodings" id="inp_hotel_edit" name="inp_hotel_edit" placeholder="Ingresa el hotel" class="form-control form-control-sm" >
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
                                                    <div class="form-group col-md-3" id="content_inp_interhotel">
                                                        <label for="">Hotel Interhotel</label>
                                                        <input list="encodings" id="inp_hotel_interhotel_edit" name="inp_hotel_interhotel_edit" placeholder="Ingresa el hotel" class="form-control form-control-sm" >
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
                                                    <div class="form-group col-md-2">
                                                        <label for="">Traslado</label>
                                                        <select class="custom-select custom-select-sm " id="inp_traslado_up" name="inp_traslado_edit" >
                                                            <option value="RED">Redondo</option>
                                                            <option value="SEN/AH">Aeropuerto - Hotel</option>
                                                            <option value="SEN/HA">Hotel - Aeropuerto</option>
                                                            <option value="REDHH">Redondo / Hotel - Hotel</option>
                                                            <option value="SEN/HH">Sencillo / Hotel - Hotel</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label for="">Servicio</label>
                                                        <select class="custom-select custom-select-sm " id="inp_servicio_edit" name="inp_servicio_edit">
                                                            <option id="compartido_ts" value="compartido">Compartido</option>
                                                            <option value="privado">Privado</option> 
                                                            <option value="lujo">Lujo</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-1">
                                                        <label for="">Pasajeros</label>
                                                        <select class="custom-select custom-select-sm" id="inp_pasajeros_edit" name="inp_pasajeros_edit" placeholder="Seleccione núm. de pasajeros">
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                            <option value="6">6</option>
                                                            <option class="num_px_pri" value="7">7</option>
                                                            <option class="num_px_pri" value="8">8</option>
                                                            <option class="num_px_pri" value="9">9</option>
                                                            <option class="num_px_pri" value="10">10</option>
                                                            <option class="num_px_pri" value="11">11</option>
                                                            <option class="num_px_pri" value="12">12</option>
                                                            <option class="num_px_pri" value="13">13</option>
                                                            <option class="num_px_pri" value="14">14</option>
                                                            <option class="num_px_pri" value="15">15</option>
                                                            <option class="num_px_pri" value="16">16</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                </div>
                                <div class="col-xl-12 col-md-12  pt-2 content_type_info">
                                    <h6>DATOS DE VUELO Y/O PICKUP</h6>
                                </div>
                                <div class="col-xl-12 pt-2">
                                            <div class="form_details">
                                        
                                                <div class="form-row" id="inps_entrada_edit">
                                                    <div class="form-group mb-0 col-md-3">
                                                        <label id="label_date_star" for="datepicker_star">Llegada</label>
                                                        <div class="input-group">
                                                            <input type="text" id="datepicker_arrival_edit" name="datepicker_arrival_edit" autocomplete="off" placeholder="Selecciona una fecha" class="form-control form-control-sm"  aria-describedby="date" >
                                                            <div class="input-group-append mr-2">
                                                                <span class="input-group-text" id="date"><i class="far fa-calendar-alt"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-0 col-md-3">
                                                        <label for="">Aerolina</label>
                                                        <input type="text" class="form-control form-control-sm" id="inp_airline_entry_edit" placeholder="Nombre de aerolina" >
                                                    </div>
                                                    <div class="form-group mb-0 col-md-3">
                                                        <label for="">Número de Vuelo</label>
                                                        <input type="text" class="form-control form-control-sm" id="inp_nofly_entry_edit" placeholder="Número de vuelo" >
                                                    </div>
                                                    <div class="form-group mb-0 col-md-3">
                                                        <div class="row">
                                                            <div class="col-md-12">                                            
                                                                <label for="">Hora</label>
                                                            </div>
                                                            <div class="form-group col-xl-4 col-md-5 pr-1">
                                                                <select class="form-control form-control-sm" id="inp_hour_entry_edit">
                                                                    <option>01</option>
                                                                    <option>02</option>
                                                                    <option>03</option>
                                                                    <option>04</option>
                                                                    <option>05</option>
                                                                    <option>06</option>
                                                                    <option>07</option>
                                                                    <option>08</option>
                                                                    <option>09</option>
                                                                    <option>10</option>
                                                                    <option>11</option>
                                                                    <option>12</option>
                                                                    <option>13</option>
                                                                    <option>14</option>
                                                                    <option>15</option>
                                                                    <option>16</option>
                                                                    <option>17</option>
                                                                    <option>18</option>
                                                                    <option>19</option>
                                                                    <option>20</option>
                                                                    <option>21</option>
                                                                    <option>22</option>
                                                                    <option>23</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-1 p-1 text-center">
                                                                <span>:</span>
                                                            </div>
                                                            <div class="form-group col-xl-4 col-md-5 pl-1">
                                                                <select class="form-control form-control-sm" id="inp_minute_entry_edit">
                                                                    <option>00</option>
                                                                    <option>01</option>
                                                                    <option>02</option>
                                                                    <option>03</option>
                                                                    <option>04</option>
                                                                    <option>05</option>
                                                                    <option>06</option>
                                                                    <option>07</option>
                                                                    <option>08</option>
                                                                    <option>09</option>
                                                                    <option>10</option>
                                                                    <option>11</option>
                                                                    <option>12</option>
                                                                    <option>13</option>
                                                                    <option>14</option>
                                                                    <option>15</option>
                                                                    <option>16</option>
                                                                    <option>17</option>
                                                                    <option>18</option>
                                                                    <option>19</option>
                                                                    <option>20</option>
                                                                    <option>21</option>
                                                                    <option>22</option>
                                                                    <option>23</option>
                                                                    <option>24</option>
                                                                    <option>25</option>
                                                                    <option>26</option>
                                                                    <option>27</option>
                                                                    <option>28</option>
                                                                    <option>29</option>
                                                                    <option>30</option>
                                                                    <option>31</option>
                                                                    <option>32</option>
                                                                    <option>33</option>
                                                                    <option>34</option>
                                                                    <option>35</option>
                                                                    <option>36</option>
                                                                    <option>37</option>
                                                                    <option>38</option>
                                                                    <option>39</option>
                                                                    <option>40</option>
                                                                    <option>41</option>
                                                                    <option>42</option>
                                                                    <option>43</option>
                                                                    <option>44</option>
                                                                    <option>45</option>
                                                                    <option>46</option>
                                                                    <option>47</option>
                                                                    <option>48</option>
                                                                    <option>49</option>
                                                                    <option>50</option>
                                                                    <option>51</option>
                                                                    <option>52</option>
                                                                    <option>53</option>
                                                                    <option>54</option>
                                                                    <option>55</option>
                                                                    <option>56</option>
                                                                    <option>57</option>
                                                                    <option>58</option>
                                                                    <option>59</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-1 p-1 text-center">
                                                                <span>Hrs</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row" id="inps_salida_edit">
                                                    <div class="form-group mb-0 col-md-3">
                                                        <div class="form-group pb-2" id="content_date_end">
                                                            <label for="datepicker_end">Salida</label>
                                                            <div class="input-group">
                                                                <input type="text" id="datepicker_exit_edit" name="datepicker_exit_edit" autocomplete="off" placeholder="Selecciona una fecha" class="form-control form-control-sm" aria-describedby="date" >
                                                                <div class="input-group-append mr-2">
                                                                    <span class="input-group-text" id="date"><i class="far fa-calendar-minus"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-0 col-md-3">
                                                        <label for="">Aerolina</label>
                                                        <input type="text" class="form-control form-control-sm" id="inp_airline_exit_edit" placeholder="Nombre de aerolina" >
                                                    </div>
                                                    <div class="form-group mb-0 col-md-3">
                                                        <label for="">Número de Vuelo</label>
                                                        <input type="text" class="form-control form-control-sm" id="inp_nofly_exit_edit" placeholder="Número de vuelo" >
                                                    </div>
                                                    <div class="form-group  mb-0 col-md-3">
                                                        <div class="row">
                                                            <div class="col-md-12">                                            
                                                                <label for="exampleFormControlSelect1">Hora</label>
                                                            </div>
                                                            <div class="form-group col-xl-4 col-md-5 pr-1">
                                                                <select class="form-control form-control-sm" id="inp_hour_exit_edit">
                                                                    <option>01</option>
                                                                    <option>02</option>
                                                                    <option>03</option>
                                                                    <option>04</option>
                                                                    <option>05</option>
                                                                    <option>06</option>
                                                                    <option>07</option>
                                                                    <option>08</option>
                                                                    <option>09</option>
                                                                    <option>10</option>
                                                                    <option>11</option>
                                                                    <option>12</option>
                                                                    <option>13</option>
                                                                    <option>14</option>
                                                                    <option>15</option>
                                                                    <option>16</option>
                                                                    <option>17</option>
                                                                    <option>18</option>
                                                                    <option>19</option>
                                                                    <option>20</option>
                                                                    <option>21</option>
                                                                    <option>22</option>
                                                                    <option>23</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-1 p-1 text-center">
                                                                <span>:</span>
                                                            </div>
                                                            <div class="form-group col-xl-4 col-md-5 pl-1">
                                                                <select class="form-control form-control-sm" id="inp_minute_exit_edit">
                                                                    <option>00</option>
                                                                    <option>01</option>
                                                                    <option>02</option>
                                                                    <option>03</option>
                                                                    <option>04</option>
                                                                    <option>05</option>
                                                                    <option>06</option>
                                                                    <option>07</option>
                                                                    <option>08</option>
                                                                    <option>09</option>
                                                                    <option>10</option>
                                                                    <option>11</option>
                                                                    <option>12</option>
                                                                    <option>13</option>
                                                                    <option>14</option>
                                                                    <option>15</option>
                                                                    <option>16</option>
                                                                    <option>17</option>
                                                                    <option>18</option>
                                                                    <option>19</option>
                                                                    <option>20</option>
                                                                    <option>21</option>
                                                                    <option>22</option>
                                                                    <option>23</option>
                                                                    <option>24</option>
                                                                    <option>25</option>
                                                                    <option>26</option>
                                                                    <option>27</option>
                                                                    <option>28</option>
                                                                    <option>29</option>
                                                                    <option>30</option>
                                                                    <option>31</option>
                                                                    <option>32</option>
                                                                    <option>33</option>
                                                                    <option>34</option>
                                                                    <option>35</option>
                                                                    <option>36</option>
                                                                    <option>37</option>
                                                                    <option>38</option>
                                                                    <option>39</option>
                                                                    <option>40</option>
                                                                    <option>41</option>
                                                                    <option>42</option>
                                                                    <option>43</option>
                                                                    <option>44</option>
                                                                    <option>45</option>
                                                                    <option>46</option>
                                                                    <option>47</option>
                                                                    <option>48</option>
                                                                    <option>49</option>
                                                                    <option>50</option>
                                                                    <option>51</option>
                                                                    <option>52</option>
                                                                    <option>53</option>
                                                                    <option>54</option>
                                                                    <option>55</option>
                                                                    <option>56</option>
                                                                    <option>57</option>
                                                                    <option>58</option>
                                                                    <option>59</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-1 p-1 text-center">
                                                                <span>Hrs</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>  

                                                <div class="form-row" id="inp_pickup_edit">
                                                    <div id="pick_up_arrival" class="col-md-6">
                                                        <div class="form-row">
                                                            <div class="form-group mb-0 col-md-6">
                                                                <label id="label_date_star" for="datepicker_star">Fecha de Servicio</label>
                                                                <div class="input-group">
                                                                    <input type="text" id="datepicker_pickup_arrival_edit" autocomplete="off" placeholder="Selecciona una fecha" class="form-control form-control-sm"  aria-describedby="date" >
                                                                    <div class="input-group-append mr-2">
                                                                        <span class="input-group-text" id="date"><i class="far fa-calendar-alt"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-0 col-md-6" id="inp_pickup_enter_edit">
                                                                <div class="row">
                                                                    <div class="col-md-12">                                            
                                                                        <label for="exampleFormControlSelect1">Hora de Pickup <small>(Ida)</small></label>
                                                                    </div>
                                                                    <div class="form-group mb-0 col-xl-4 col-md-5 pr-1">
                                                                        <select class="form-control form-control-sm" id="inp_hour_pick_edit">
                                                                            <option>01</option>
                                                                            <option>02</option>
                                                                            <option>03</option>
                                                                            <option>04</option>
                                                                            <option>05</option>
                                                                            <option>06</option>
                                                                            <option>07</option>
                                                                            <option>08</option>
                                                                            <option>09</option>
                                                                            <option>10</option>
                                                                            <option>11</option>
                                                                            <option>12</option>
                                                                            <option>13</option>
                                                                            <option>14</option>
                                                                            <option>15</option>
                                                                            <option>16</option>
                                                                            <option>17</option>
                                                                            <option>18</option>
                                                                            <option>19</option>
                                                                            <option>20</option>
                                                                            <option>21</option>
                                                                            <option>22</option>
                                                                            <option>23</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-1 p-1 text-center">
                                                                        <span>:</span>
                                                                    </div>
                                                                    <div class="form-group mb-0 col-xl-4 col-md-5 pl-1">
                                                                        <select class="form-control form-control-sm" id="inp_minute_pick_edit">
                                                                            <option>00</option>
                                                                            <option>01</option>
                                                                            <option>02</option>
                                                                            <option>03</option>
                                                                            <option>04</option>
                                                                            <option>05</option>
                                                                            <option>06</option>
                                                                            <option>07</option>
                                                                            <option>08</option>
                                                                            <option>09</option>
                                                                            <option>10</option>
                                                                            <option>11</option>
                                                                            <option>12</option>
                                                                            <option>13</option>
                                                                            <option>14</option>
                                                                            <option>15</option>
                                                                            <option>16</option>
                                                                            <option>17</option>
                                                                            <option>18</option>
                                                                            <option>19</option>
                                                                            <option>20</option>
                                                                            <option>21</option>
                                                                            <option>22</option>
                                                                            <option>23</option>
                                                                            <option>24</option>
                                                                            <option>25</option>
                                                                            <option>26</option>
                                                                            <option>27</option>
                                                                            <option>28</option>
                                                                            <option>29</option>
                                                                            <option>30</option>
                                                                            <option>31</option>
                                                                            <option>32</option>
                                                                            <option>33</option>
                                                                            <option>34</option>
                                                                            <option>35</option>
                                                                            <option>36</option>
                                                                            <option>37</option>
                                                                            <option>38</option>
                                                                            <option>39</option>
                                                                            <option>40</option>
                                                                            <option>41</option>
                                                                            <option>42</option>
                                                                            <option>43</option>
                                                                            <option>44</option>
                                                                            <option>45</option>
                                                                            <option>46</option>
                                                                            <option>47</option>
                                                                            <option>48</option>
                                                                            <option>49</option>
                                                                            <option>50</option>
                                                                            <option>51</option>
                                                                            <option>52</option>
                                                                            <option>53</option>
                                                                            <option>54</option>
                                                                            <option>55</option>
                                                                            <option>56</option>
                                                                            <option>57</option>
                                                                            <option>58</option>
                                                                            <option>59</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-1 p-1 text-center">
                                                                        <span>Hrs</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="pick_up_exit" class="col-md-6">
                                                        <div class="form-row">
                                                            <div class="form-group mb-0 col-md-6">
                                                                <div class="form-group mb-0 pb-2" id="content_date_end">
                                                                    <label for="datepicker_end">Salida</label>
                                                                    <div class="input-group">
                                                                        <input type="text" id="datepicker_pickup_exit_edit" name="datepicker_end_edit" autocomplete="off" placeholder="Selecciona una fecha" class="form-control form-control-sm" aria-describedby="date" >
                                                                        <div class="input-group-append mr-2">
                                                                            <span class="input-group-text" id="date"><i class="far fa-calendar-minus"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-0 col-md-6" id="inp_pickup_exit_edit">
                                                                <div class="row">
                                                                    <div class="col-md-12">                                            
                                                                        <label for="exampleFormControlSelect1">Hora de Pickup <small>(Regreso)</small></label>
                                                                    </div>
                                                                    <div class="form-group mb-0 col-xl-4 col-md-5 pr-1">
                                                                        <select class="form-control form-control-sm" id="inp_hour_pick_inter_edit">
                                                                            <option>01</option>
                                                                            <option>02</option>
                                                                            <option>03</option>
                                                                            <option>04</option>
                                                                            <option>05</option>
                                                                            <option>06</option>
                                                                            <option>07</option>
                                                                            <option>08</option>
                                                                            <option>09</option>
                                                                            <option>10</option>
                                                                            <option>11</option>
                                                                            <option>12</option>
                                                                            <option>13</option>
                                                                            <option>14</option>
                                                                            <option>15</option>
                                                                            <option>16</option>
                                                                            <option>17</option>
                                                                            <option>18</option>
                                                                            <option>19</option>
                                                                            <option>20</option>
                                                                            <option>21</option>
                                                                            <option>22</option>
                                                                            <option>23</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-1 p-1 text-center">
                                                                        <span>:</span>
                                                                    </div>
                                                                    <div class="form-group mb-0 col-xl-4 col-md-5 pl-1">
                                                                        <select class="form-control form-control-sm" id="inp_minute_pick_inter_edit">
                                                                            <option>00</option>
                                                                            <option>01</option>
                                                                            <option>02</option>
                                                                            <option>03</option>
                                                                            <option>04</option>
                                                                            <option>05</option>
                                                                            <option>06</option>
                                                                            <option>07</option>
                                                                            <option>08</option>
                                                                            <option>09</option>
                                                                            <option>10</option>
                                                                            <option>11</option>
                                                                            <option>12</option>
                                                                            <option>13</option>
                                                                            <option>14</option>
                                                                            <option>15</option>
                                                                            <option>16</option>
                                                                            <option>17</option>
                                                                            <option>18</option>
                                                                            <option>19</option>
                                                                            <option>20</option>
                                                                            <option>21</option>
                                                                            <option>22</option>
                                                                            <option>23</option>
                                                                            <option>24</option>
                                                                            <option>25</option>
                                                                            <option>26</option>
                                                                            <option>27</option>
                                                                            <option>28</option>
                                                                            <option>29</option>
                                                                            <option>30</option>
                                                                            <option>31</option>
                                                                            <option>32</option>
                                                                            <option>33</option>
                                                                            <option>34</option>
                                                                            <option>35</option>
                                                                            <option>36</option>
                                                                            <option>37</option>
                                                                            <option>38</option>
                                                                            <option>39</option>
                                                                            <option>40</option>
                                                                            <option>41</option>
                                                                            <option>42</option>
                                                                            <option>43</option>
                                                                            <option>44</option>
                                                                            <option>45</option>
                                                                            <option>46</option>
                                                                            <option>47</option>
                                                                            <option>48</option>
                                                                            <option>49</option>
                                                                            <option>50</option>
                                                                            <option>51</option>
                                                                            <option>52</option>
                                                                            <option>53</option>
                                                                            <option>54</option>
                                                                            <option>55</option>
                                                                            <option>56</option>
                                                                            <option>57</option>
                                                                            <option>58</option>
                                                                            <option>59</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-1 p-1 text-center">
                                                                        <span>Hrs</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row" id="inp_time_service_edit">
                                                    <div class="form-group mb-0 col-md-3">
                                                        <label id="" for="">Hora de servicio</label>
                                                        <div class="form-group col-xl-12 col-md-12 p-0">
                                                                <select class="form-control form-control-sm" id="inp_time_service">
                                                                    <option value="">Seleccione la hora del servicio</option>
                                                                    <option value="08:00:00">08:00</option>
                                                                    <option value="08:40:00">08:40</option>
                                                                    <option value="09:20:00">09:20</option>
                                                                    <option value="10:00:00">10:00</option>
                                                                    <option value="10:40:00">10:40</option>
                                                                    <option value="11:20:00">11:20</option>
                                                                    <option value="12:00:00">12:00</option>
                                                                    <option value="12:40:00">12:40</option>
                                                                    <option value="13:20:00">13:20</option>
                                                                    <option value="14:00:00">14:00</option>
                                                                    <option value="14:40:00">14:40</option>
                                                                    <option value="17:20:00">17:20</option>
                                                                    <option value="18:00:00">18:00</option>
                                                                    <option value="18:40:00">18:40</option>
                                                                    <option value="19:20:00">19:20</option>
                                                                    <option value="20:00:00">20:00</option>
                                                                </select>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                </div>
                                <br>
                                <div class="col-xl-12 col-md-12 pt-2 content_type_info">
                                    <h6>DATOS DE PAGO Y ESTADO</h6>
                                </div>
                                <div class="col-xl-12 pt-2">
                                            <div class="form_details">
                                                <div class="form-row">
                                                    <div class="form-group mb-0 col-md-2">
                                                        <label for="">Fecha de Reservación</label>
                                                        <input type="text" class="form-control form-control-sm" id="inp_date_register_res_edit" placeholder="Fecha de Registro de Reservación" disabled>
                                                    </div>
                                                    <div class="form-group mb-0 col-md-2">
                                                        <label for="">Estado</label>
                                                        <input type="text" class="form-control form-control-sm" id="inp_status_reserva_edit" placeholder="Estado de la Reservación" disabled>
                                                    </div>
                                                    <div class="form-group mb-0 col-md-2">
                                                        <label for="inputEmail4">Método de Pago</label>
                                                        <select class="custom-select custom-select-sm " id="inp_method_payment_edit" name="inp_method_payment_edit" >
                                                            <option id="transfer" value="transfer">TRANSFERENCIA</option>
                                                            <option id="card" value="card">TARJETA</option>
                                                            <option id="paypal" value="paypal">PAYPAL</option>
                                                            <option id="airport" value="airport">PAGO AL ABORDAR</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group mb-0 col-md-2 pl-1" id="content_subtotal">
                                                        <label for="">Subtotal</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control form-control-sm" id="inp_total_cost_edit" placeholder="Subtotal" disabled >
                                                            <div class="input-group-append mr-2">
                                                                <span class="input-group-text" ><small class="currency" ></small></span>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" class="form-control form-control-sm" id="inp_total_cost_b" placeholder="Subtota"  disabled ><br>
                                                    </div>
                                                    <div class="form-group mb-0 col-md-2" id="content_comission_agency">
                                                        <label for="">Comisión</label>
                                                        <input type="text" class="form-control form-control-sm" id="inp_agency_commision_edit" placeholder="Comisión"  >
                                                    </div>
                                                    <div class="form-group mb-0 col-md-2 pl-1" id="content_total_commision">
                                                        <label for="">Total</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control form-control-sm" id="inp_total_cost_commesion_edit" placeholder="Costo Total"  disabled >
                                                            <div class="input-group-append mr-2">
                                                                <span class="input-group-text" ><small class="currency" id="currency"></small></span>
                                                            </div>
                                                            <input type="hidden" class="form-control form-control-sm" id="inp_total_cost_before" placeholder="Costo Total"  disabled >
                                                        </div>
                                                            <input type="hidden" class="form-control form-control-sm" id="inp_total_cost_commesion_b" placeholder="Costo Total"  disabled ><br>
                                                    </div>
                                                </div>
                                            </div>
                                </div>
                                <br>
                                <div class="col-xl-12 col-md-12 content_type_info pt-2">
                                    <h6>DATOS DEL CLIENTE</h6>
                                </div>
                                <div class="col-xl-12 pt-2">
                                            <div class="form_details">
                                                <div class="form-row">
                                                    <div class="form-group mb-0 col-md-2">
                                                        <label for="">Nombre (s)</label>
                                                        <input type="text" class="form-control form-control-sm" id="inp_name_client_edit" placeholder="Nombre del Cliente"  >
                                                    </div>
                                                    <div class="form-group mb-0 col-md-2">
                                                        <label for="">Apellido Paterno</label>
                                                        <input type="text" class="form-control form-control-sm" id="inp_lastname_client_edit" placeholder="Apellido del Cliente"  >
                                                    </div>
                                                    <div class="form-group mb-0 col-md-2">
                                                        <label for="">Apellido Materno</label>
                                                        <input type="text" class="form-control form-control-sm" id="inp_mother_lastname_edit" placeholder="Apellido del Cliente"  >
                                                    </div>
                                                    <div class="form-group mb-0 col-md-2">
                                                        <label for="inputEmail4">Correo Electronico</label>
                                                        <input type="email" class="form-control form-control-sm" id="inp_email_client_edit" placeholder="Email del Cliente"  >
                                                    </div>
                                                    <div class="form-group mb-0 col-md-2">
                                                        <label for="">Teléfono Celular</label>
                                                        <input type="text" class="form-control form-control-sm" id="inp_phone_client_edit" placeholder="Teléfono del Cliente" >
                                                    </div>
                                                    <div class="form-group mb-0 col-md-2 pl-1">
                                                        <label for="">País</label>
                                                        <input type="text" class="form-control form-control-sm" id="inp_country_client_edit" placeholder="País del Cliente" disabled >
                                                    </div>
                                                    <div class="form-group mb-0 col-md-12">
                                                        <label for="">Peticiones Especiales</label>
                                                        <textarea name="" class="form-control form-control-sm" id="inp_special_requests_edit" rows="3" ></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                </div>
                                <br>
                                <div class="col-xl-12 pt-3" id="content_btns"> 
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <a href="#" class="btn btn-yamevi btn-block pt-2 pb-2" id="update_details_reservation">G U A R D A R</a>
                                        </div>
                                        <div class="col-lg-6">
                                            <a href="#" class="btn btn-secondary btn-block close_content_edit_reserva">C A N C E L A R</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="content_reservs_search">
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