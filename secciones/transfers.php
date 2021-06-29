
<?php
require_once '../../YameviTravel/config/conexion.php';
session_start();
if (isset($_SESSION['yt_id_agency'])) {
    $id_agency = $_SESSION['yt_id_agency'];
}else{
 header('location: ../helpers/logout_a.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YameviTravel - Traslados</title>
    <?php include('include/estilos_agencies.php')?>
</head>
<body id="body"> 

    <button  id="btnToTop" title="Go to top"><i class="fas fa-angle-up"></i></button>   
    <div class="backgound_img" data-background="../../assets/img/hero/h1_hero.jpg">
        <?php include('include/navigation_agencies.php');?>
        <?php
            include('../model/reservaciones.php');
            $reserva = new Reservation;

            $fast_access = json_decode($reserva->loadFastAccess($id_agency));

        ?>
        <input type="hidden" class="" value="<?php echo $_SESSION['yt_paypal']?>" id="inp_paypal"> 
        <input type="hidden" class="" value="<?php echo $_SESSION['yt_internal_yt']?>" id="inp_internal_yt"> 
        <input type="hidden" class="" value="<?php echo $_SESSION['yt_cash']?>" id="inp_cash">
        <input type="hidden" class="" value="<?php echo $_SESSION['yt_card']?>" id="inp_card">
        <input type="hidden" class="" value="<?php echo $_SESSION['yt_operadora']?>" id="inp_operadora">

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
        <div id="anuncio">
            <div  id="content-anuncio">
                <div class="anuncio-header p-2">                
                    <button type="button" id="close-anuncio" class="close" aria-hidden="true">&times;</button>
                </div>
                <div id="anuncio-body">
                    <h4>¡Aprovecha!</h4>
                    <p>Promoción tour Xcaret Plus desde: </p>
                    <p class="price-anuncio">$2376.00 MXN</p>
                    <div style="width:100%;">
                        <img src="../assets/img/tour xcaret.jpg" width="190" height="120" alt=""><br><br>

                    </div>
                    <a href="https://yamevi.com/?product=tour-xcaret-plus-mexicanos" target="_blank" class="btn-now-anuncio btn btn-yamevi">Reservar ahora!</a>
                </div>
            </div>
        </div>
        <div id="btn-anuncio">
            <a href="#" class="btn btn-yamevi">Promoción! <i class="fas fa-bell pl-2 pr-2"></i></a>
        </div>
        <!-- FORM FINAL DE DETALLES CLIENTE/VUELO -->
        <div class="container container_pages" id="details_reservation">
            <div class="row ">
                <div class="col-xl-12 col-md-12 content_steps">
                    <h3>PASO 3</h3>
                    <p>Rellene los siguientes datos del cliente, vuelo y metodo de pago para finalizar...</p>
                </div>
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">
                    <div class=" mt-2 mb-5">
                        <?php if($_SESSION['yt_internal_yt'] == 1) {?>
                        <div id="code_booking">
                            <div class="d-flex justify-content-center row" >
                                <div class="col-xl-12 col-md-12 pt-4 content_type_info">
                                    <h6>CODIGO DE RESERVA EXTERNA / (Agencias Yamevi)</h6>
                                </div>
                                <div class="col-xl-12 pt-3">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="">Codigo</label>
                                            <input type="text" class="form-control form-control-sm" id="inp_reserv_ex" placeholder="ID de reserva externa">
                                            
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Asesor</label>
                                            <input type="text" class="form-control form-control-sm" id="inp_asesor" placeholder="Nombre de Asesor de Venta">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">De la Agencia</label>
                                            <input list="agencies" name="agencies" id="inp_of_agency" type="text" class="form-control form-control-sm w-100" placeholder="Elige una agencia">
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
                            <div class="col-xl-12 col-md-12 pt-4 content_type_info">
                                <h6>DETALLES DE VUELO Y/O PICKUP</h6>
                            </div>
                            <div class="col-xl-12 col-md-12 pt-3">
                                <div class="form_details">

                                    <div class="form-row" id="inps_entrada">
                                        <div class="form-group col-md-4">
                                            <label for="">Aerolina Llegada</label>
                                            <input type="text" class="form-control form-control-sm" id="inp_airline_entry" placeholder="Nombre de aerolina">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Número de Vuelo</label>
                                            <input type="text" class="form-control form-control-sm" id="inp_nofly_entry" placeholder="Número de vuelo">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="row">
                                                <div class="col-md-12">                                            
                                                    <label for="">Hora de Llegada</label>
                                                </div>
                                                <div class="form-group col-xl-4 col-md-5 pr-1">
                                                    <select class="form-control form-control-sm" id="inp_hour_entry">
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
                                                    <select class="form-control form-control-sm" id="inp_minute_entry">
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
                                    <div class="form-row" id="inps_salida">
                                        <div class="form-group col-md-4">
                                            <label for="">Aerolina Salida</label>
                                            <input type="text" class="form-control form-control-sm" id="inp_airline_exit" placeholder="Nombre de aerolina">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Número de Vuelo</label>
                                            <input type="text" class="form-control form-control-sm" id="inp_nofly_exit" placeholder="Número de vuelo">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="row">
                                                <div class="col-md-12">                                            
                                                    <label for="exampleFormControlSelect1">Hora de Salida</label>
                                                </div>
                                                <div class="form-group col-xl-4 col-md-5 pr-1">
                                                    <select class="form-control form-control-sm" id="inp_hour_exit">
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
                                                    <select class="form-control form-control-sm" id="inp_minute_exit">
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
                                    <div class="form-row" id="inp_pickup">
                                        <div class="form-group col-md-5" id="inp_pickup_enter">
                                            <div class="row">
                                                <div class="col-md-12">                                            
                                                    <label for="exampleFormControlSelect1">Hora de Pickup <small>(Ida)</small></label>
                                                </div>
                                                <div class="form-group col-xl-4 col-md-5 pr-1">
                                                    <select class="form-control form-control-sm" id="inp_hour_pick">
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
                                                    <select class="form-control form-control-sm" id="inp_minute_pick">
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
                                        <div class="form-group col-md-5" id="inp_pickup_exit">
                                            <div class="row">
                                                <div class="col-md-12">                                            
                                                    <label for="exampleFormControlSelect1">Hora de Pickup <small>(Regreso)</small></label>
                                                </div>
                                                <div class="form-group col-xl-4 col-md-5 pr-1">
                                                    <select class="form-control form-control-sm" id="inp_hour_pick_inter">
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
                                                    <select class="form-control form-control-sm" id="inp_minute_pick_inter">
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
                                    <!-- Horarios  -->
                                    <div class="form-row pb-3" id="content_time_service">
                                        <div class="">
                                            <label for="" id="text_time_service">Hora de abordaje</label>
                                        </div>
                                        <div class="btn-group-toggle" data-toggle="buttons" id="content_check_btns">
                                            <label class="btn btn-outline-secondary btn-sm m-1">
                                                <input type="radio" name="options" class="options" autocomplete="off" value="08:00" active>08:00
                                            </label>
                                            <label class="btn btn-outline-secondary btn-sm m-1">
                                                <input type="radio" name="options" class="options" autocomplete="off" value="08:40"> 08:40
                                            </label>
                                            <label class="btn btn-outline-secondary btn-sm m-1">
                                                <input type="radio" name="options" class="options" autocomplete="off" value="09:20"> 09:20
                                            </label>
                                            <label class="btn btn-outline-secondary btn-sm m-1">
                                                <input type="radio" name="options" class="options" autocomplete="off" value="10:00">10:00
                                            </label>
                                            <label class="btn btn-outline-secondary btn-sm m-1">
                                                <input type="radio" name="options" class="options" autocomplete="off" value="10:40"> 10:40
                                            </label>
                                            <label class="btn btn-outline-secondary btn-sm m-1">
                                                <input type="radio" name="options" class="options" autocomplete="off" value="11:20"> 11:20
                                            </label>
                                            <label class="btn btn-outline-secondary btn-sm m-1">
                                                <input type="radio" name="options" class="options" autocomplete="off" value="12:00">12:00
                                            </label>
                                            <label class="btn btn-outline-secondary btn-sm m-1">
                                                <input type="radio" name="options" class="options"  autocomplete="off" value="12:40"> 12:40
                                            </label>
                                            <label class="btn btn-outline-secondary btn-sm m-1">
                                                <input type="radio" name="options" class="options" autocomplete="off" value="13:20"> 13:20
                                            </label>
                                            <label class="btn btn-outline-secondary btn-sm m-1">
                                                <input type="radio" name="options" class="options" autocomplete="off" value="14:00">14:00
                                            </label>
                                            <label class="btn btn-outline-secondary btn-sm m-1">
                                                <input type="radio" name="options" class="options" autocomplete="off" value="14:40"> 14:40
                                            </label>
                                            <label class="btn btn-outline-secondary btn-sm m-1">
                                                <input type="radio" name="options" class="options" autocomplete="off" value="14:40"> 15:20
                                            </label>
                                            <label class="btn btn-outline-secondary btn-sm m-1">
                                                <input type="radio" name="options" class="options" autocomplete="off" value="14:40"> 16:00
                                            </label>
                                            <label class="btn btn-outline-secondary btn-sm m-1">
                                                <input type="radio" name="options" class="options" autocomplete="off" value="14:40"> 16:40
                                            </label>
                                            <label class="btn btn-outline-secondary btn-sm m-1">
                                                <input type="radio" name="options" class="options" autocomplete="off" value="17:20"> 17:20
                                            </label>
                                            <label class="btn btn-outline-secondary btn-sm m-1">
                                                <input type="radio" name="options" class="options" autocomplete="off" value="18:00 HRS">18:00
                                            </label>
                                            <label class="btn btn-outline-secondary btn-sm m-1">
                                                <input type="radio" name="options" class="options" autocomplete="off" value="18:40 HRS"> 18:40
                                            </label>
                                            <label class="btn btn-outline-secondary btn-sm m-1">
                                                <input type="radio" name="options" class="options" autocomplete="off" value="19:20 HRS"> 19:20
                                            </label>
                                            <label class="btn btn-outline-secondary btn-sm m-1">
                                                <input type="radio" name="options" class="options" autocomplete="off" value="20:00 HRS"> 20:00
                                            </label>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="col-xl-12 col-md-12 content_type_info">
                                <h6>INFORMACIÓN DEL CLIENTE</h6>
                            </div>
                            <div class="col-xl-12 col-md-12 pt-3">
                                <div class="form_details">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="">Nombre (s)</label>
                                            <input type="text" class="form-control form-control-sm" id="inp_name_client" placeholder="Nombre del Cliente">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Apellido Paterno</label>
                                            <input type="text" class="form-control form-control-sm" id="inp_lastname_client" placeholder="Apellido Paterno del Cliente">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Apellido Materno</label>
                                            <input type="text" class="form-control form-control-sm" id="inp_mother_lastname" placeholder="Apellido Materno del Cliente">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="">Teléfono Celular</label>
                                            <input type="text" class="form-control form-control-sm" id="inp_phone_client" placeholder="Teléfono del Cliente">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputEmail4">Correo Electronico</label>
                                            <input type="email" class="form-control form-control-sm" id="inp_email_client" placeholder="Email del Cliente">
                                        </div>
                                        <div class="form-group col-md-4 pl-1">
                                            <label for="">País</label>
                                            <select class="form-control form-control-sm" id="inp_country_client">
                                                <option value="">Seleccione el País</option>
                                                <option value="Africa">Africa</option>
                                                <option value="Argentina">Argentina</option>
                                                <option value="Australia">Australia</option>
                                                <option value="Austria">Austria</option>
                                                <option value="Belgium">Belgium</option>
                                                <option value="Bolivia">Bolivia</option>
                                                <option value="Brazil">Brazil</option>
                                                <option value="Bulgaria">Bulgaria</option>
                                                <option value="Canada">Canada</option>
                                                <option value="Caribbean">Caribbean</option>
                                                <option value="Central America">Central America</option>
                                                <option value="Chile">Chile</option>
                                                <option value="China">China</option>
                                                <option value="Colombia">Colombia</option>
                                                <option value="Costa Rica">Costa Rica</option>
                                                <option value="Croatia">Croatia</option>
                                                <option value="Czech Republic">Czech Republic</option>
                                                <option value="Denmark">Denmark</option>
                                                <option value="Dominican Republic">Dominican Republic</option>
                                                <option value="Ecuador">Ecuador</option>
                                                <option value="El Salvador">El Salvador</option>
                                                <option value="Espana">España</option>
                                                <option value="Estonia">Estonia</option>
                                                <option value="Finland">Finland</option>
                                                <option value="France">France</option>
                                                <option value="Germany">Germany</option>
                                                <option value="Greece">Greece</option>
                                                <option value="Guatemala">Guatemala</option>
                                                <option value="Honduras">Honduras</option>
                                                <option value="Hong Kong">Hong Kong</option>
                                                <option value="Hungary">Hungary</option>
                                                <option value="India">India</option>
                                                <option value="Indonesia">Indonesia</option>
                                                <option value="Ireland">Ireland</option>
                                                <option value="Israel">Israel</option>
                                                <option value="Italy">Italy</option>
                                                <option value="Japan">Japan</option>
                                                <option value="Korea">Korea</option>
                                                <option value="Latvia">Latvia</option>
                                                <option value="Lithuania">Lithuania</option>
                                                <option value="Malaysia">Malaysia</option>
                                                <option value="Mexico">Mexico</option>
                                                <option value="Middle East">Middle East</option>
                                                <option value="Morocco">Morocco</option>
                                                <option value="Netherlands">Netherlands</option>
                                                <option value="New Zealand">New Zealand</option>
                                                <option value="Nicaragua">Nicaragua</option>
                                                <option value="Norway">Norway</option>
                                                <option value="Paraguay">Paraguay</option>
                                                <option value="Panama">Panama</option>
                                                <option value="Peru">Peru</option>
                                                <option value="Philippines">Philippines</option>
                                                <option value="Poland">Poland</option>
                                                <option value="Portugal">Portugal</option>
                                                <option value="Puerto Rico">Puerto Rico</option>
                                                <option value="Republica Dominicana">Republica Dominicana</option>
                                                <option value="Romania">Romania</option>
                                                <option value="Russian Federation">Russian Federation</option>
                                                <option value="Singapore">Singapore</option>
                                                <option value="Slovakia">Slovakia</option>
                                                <option value="Slovenia">Slovenia</option>
                                                <option value="South Africa">South Africa</option>
                                                <option value="Sweden">Sweden</option>
                                                <option value="Switzerland">Switzerland</option>
                                                <option value="Taiwan">Taiwan</option>
                                                <option value="Thailand">Thailand</option>
                                                <option value="Turkey">Turkey</option>
                                                <option value="Uruguay">Uruguay</option>
                                                <option value="Ukraine">Ukraine</option>
                                                <option value="United Kingdom">United Kingdom</option>
                                                <option value="United States">United States</option>
                                                <option value="Venezuela">Venezuela</option>
                                                <option value="Vietnam">Vietnam</option> 
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="">Peticiones Especiales</label>
                                            <textarea name="" class="form-control form-control-sm" id="inp_special_requests" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <!-- <div class="col-xl-12 col-md-12">
                                <div class="row form_details pt-4">
                                    <div class="col-md-8 text-right title_details">
                                        <span class="info_traslate">Traslados:</span><br>
                                        <span class="info_service">Servicios:</span><br>
                                        <span class="info_origin">Origen:</span><br>
                                        <span class="info_destiny">Destino:</span><br>
                                        <span class="info_passenger">Pasajeros:</span><br>
                                        <span class="info_date">Fecha:</span><br><br>
                                        <span class="info_payment">Método de Pago:</span><br><br>
                                        <span class="info_service_charge pt-1">Cargo por Servicio:</span><br><br>
                                        <span class="info_discount">Descuento:</span><br><br><br>
                                        <span class="info_import">Importe:</span><br>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <span class="info_traslate">Compartido</span><br>
                                        <span class="info_service">Redondo</span><br>
                                        <span class="info_origin">Riu Dunamar</span><br>
                                        <span class="info_destiny">Riu Palace Peninsula All Inclusive</span><br>
                                        <span class="info_passenger">2</span><br>
                                        <span class="info_date">30/03/2021</span><br><br>
                                        <select class="form-control form-control-sm mb-3 info_payment" id="">
											<option value="card">Tarjeta Crédito/Débito</option>
											<option value="transfer">Transferencia</option>
                                        </select>
                                        <input type="text" class="form-control form-control-sm info_service_charge mb-3" value="0.00" id="">
                                        <input type="text" class="form-control form-control-sm info_discount mb-1" id="" value="0.00" disabled><br>
                                        <div class="row ">
                                            <div class="col-md-7 text-right pr-0">
                                                <h2 class="info_import">340</h2>
                                            </div>
                                            <div class="col-md-5 text-right pr-0">
                                                <select class="form-control" id="">
                                                        <option value="mxn">MXN</option>
                                                        <option value="usd">USD</option>
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 pt-4 pr-1 pl-1">
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
                                <span><input type="text" class="form-control form-control-sm info_service_charge" onClick="this.setSelectionRange(0, this.value.length)" placeholder="0.00" id="cservicio_resumen"></span>
                            </div>
                            <div class="line_resumen content_descuento">
                                <small>Descuento por Método de Pago: </small>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control form-control-sm info_discount" id="descuento_resumen" placeholder="0.00" disabled>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text border border-light" id=""><span id="porcentaje"></span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="line_resumen content_descuento_operadora">
                                <small>Descuento por Operadora: </small>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control form-control-sm info_discount" id="descuento_resumen_operadora" placeholder="0.00" disabled>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text border border-light" id=""><span id="porcentaje_operadora"></span></span>
                                    </div>
                                </div>
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
                                    <div class="col-md-3 pl-0">                                
                                        <small>Total: </small>
                                    </div>
                                    <div class="col-md-5 text-right pr-0">
                                        <h2 id="info_import" data-ratemx="00" data-rateus="00" data-ratemx_c="00" data-rateus_c="00" data-discountmx="00" data-discountus="00" data-operator="0"  data-ratemx_ope_tp="00" data-rateus_ope_tp="00" data-discountmxope_tp="00" data-discountusope_tp="00" data-ratemx_ope="00" data-rateus_ope="00" data-discountmxope="00" data-discountusope="00" ></h2>
                                    </div>
                                    <div class="col-md-4 text-right pl-1 pr-0">
                                        <select class="form-control" id="select_type_change">
                                                <option value="mxn">MXN</option>
                                                <option value="usd">USD</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="line_resumen " id="content_descuento_electronic">
                                <small>Monedero Electrónico: </small>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control form-control-sm info_discount_electronic" id="inp_discount_electronic" placeholder="0.00" disabled>
                                </div>
                            </div>
                            <div class="pt-3 " id="content_electronic_purse">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="check_electronic_purse" required>
                                    <label class="custom-control-label" for="check_electronic_purse">Deseo utilizar el monedero electrónico.</label>
                                </div>
                            </div>
                            <div class="pt-1 " id="content_ceros">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="check_ceros" required>
                                    <label class="custom-control-label" for="check_ceros">Deseo que mi ticket se visuialice en $0.00</label>
                                </div>
                            </div>
                            <div class="pt-1 " id="content_terms_conditions">
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
                </div>
                <br>
                <!-- FORM RESERV -->
                <form id="inps_store" action="post">
                    <input type="text" name="_AGENCIE" id="_AGENCIE" value="<?php echo $_SESSION['yt_id_agency']?>">
                    <input type="text" name="_ORIGIN_HOTEL" id="_ORIGIN_HOTEL">
                    <input type="text" name="_DESTINY_HOTEL" id="_DESTINY_HOTEL">
                    <input type="text" name="_TYPE_TRANSFER" id="_TYPE_TRANSFER">
                    <input type="text" name="_TYPE_SERVICE" id="_TYPE_SERVICE">
                    <input type="text" name="_DATE_ENTRY" id="_DATE_ENTRY">
                    <input type="text" name="_DATE_EXIT" id="_DATE_EXIT">
                    <input type="text" name="_NUMBER_PAS" id="_NUMBER_PAS">
                    <input type="text" name="_TOTAL_MXN" id="_TOTAL_MXN">
                    <input type="text" name="_TOTAL_USD" id="_TOTAL_USD">
                    <!-- Inputs sin comision de tarjeta ni de agencia, TARIFA NETA -->
                    <input type="text" name="inp_amount_total_mxn" id="inp_amount_total_mxn">
                    <input type="text" name="inp_amount_total_usd" id="inp_amount_total_usd">
                    <input type="text" name="_PAYMENT" id="_PAYMENT">
                    <input type="text" name="_TYPE_CHANGE" id="_TYPE_CHANGE">
                    <input type="text" name="_TYPE_CURRENCY" id="_TYPE_CURRENCY" >
                    <input type="text" name="_TYPE_CHANGE_ALT" id="_TYPE_CHANGE_ATL" value="1">
                    <input type="text" name="_INVOICE" id="_INVOICE">
                    <input type="text" name="_NAME_CLIENT" id="_NAME_CLIENT">
                    <input type="text" name="_LAST_NAME" id="_LAST_NAME">
                    <input type="text" name="_CLIENT_EMAIL" id="_CLIENT_EMAIL">
                    <input type="text" name="_CLIENT_PHONE" id="_CLIENT_PHONE">
                    <input type="text" name="_LETTER_LANGUAGE" id="_LETTER_LANGUAGE">
                    <input type="text" name="_CHARGE_SERVICE" id="_CHARGE_SERVICE">
                    <input type="text" name="_AMOUNT_TOTAL" id="_AMOUNT_TOTAL">
                    <input type="text" name="_TYPE_PACKAGE" id="_TYPE_PACKAGE"> 
                </form>
                
                <!-- FORM PAYPAL -->
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" name="paypalPayment" id="paypalPayment">
                    <input type="hidden" name="cmd" id="cmd" value="_xclick">
                    <input type="hidden" name="business" id="business" value="arturoruiz75@hotmail.com">
                    <input type="hidden" name="item_name" id="p_itemname" value="">
                    <input type="hidden" name="amount" id="p_amount" value="">
                    <input type="hidden" name="invoice" id="p_invoice" value="">
                    <input type="hidden" name="no_shipping" value="1">
                    <input type="hidden" name="currency_code" id="p_currency" value="MXN">
                    <input type="hidden" name="rm" value="1">
                    <input type="hidden" name="return" value="https://wwww.yamevitravel.com/agencias/">
                    <input type="hidden" name="cancel_return" value="https://www.yamevitravel.com">
                    <input type="hidden" name="notify_url" value="https://www.yamevitravel.com/nativengine/models/ipnpaypal.php">
                </form>
            </div>
        </div>
        <!-- VISUALIZACION DE RESULTADOS -->
        <div id="content_results" class="pr-3 pl-3">
            <div class="row pr-3 pl-3">
                <div class="col-lg-12 col-md-12 col-sm-6 ">
                    <div class="card p-1" id="form_transfer_edit">
                        <div class="card-body">
                            <form id="form_reserva_edit" > 
                                <input type="hidden" class="" value="<?php echo $_SESSION['yt_todaysale']?>" id="inp_todaysale_edit">   
                                <input type="hidden" value="" id="inp_type_traslate"> 
                                <div class="form-row">
                                    <div class="form-inline col-md-3 content_hotel_1 ">
                                        <label for="inp_hotel" class="pr-2"><i class="fas fa-hotel"></i></label>
                                        <input list="encodings" id="inp_hotel_edit" name="inp_hotel_edit" placeholder="Ingresa el hotel" class="form-control form-control-plaintext form-control-sm ">
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
                                    <div class="form-inline col-md-2 content_interhotel_2">
                                        <label for="inp_hotel_2" class="pr-1"><i class="fas fa-hotel"></i></label>
                                        <input list="encodings" id="inp_hotel_edit_2" name="inp_hotel_edit_2" placeholder="Ingresa el hotel" class="form-control form-control-plaintext form-control-sm ">
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
                                    <div class="form-inline col-md-2 content_pasajeros">
                                        <label for="inp_pasajeros" ><i class="fas fa-user-friends"></i></label>
                                        <select class="custom-select custom-select-sm" id="inp_pasajeros_edit" name="inp_pasajeros_edit" placeholder="Seleccione núm. de pasajeros">
                                            <option value="">Seleccione núm. de pasajeros</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                            <option value="13">13</option>
                                            <option value="14">14</option>
                                            <option value="15">15</option>
                                            <option value="16">16</option>
                                        </select>
                                    </div>
                                    <div class="form-inline col-md-2">
                                        <label for="inp_traslado_edit" class="pr-2"><i class="fas fa-bus"></i></label>
                                        <select class="custom-select custom-select-sm " id="inp_traslado_edit" name="inp_traslado_edit">
                                            <option value="">Seleccione tipo de traslado</option>
                                            <option value="RED">Redondo</option>
                                            <option value="SEN/AH">Aeropuerto - Hotel</option>
                                            <option value="SEN/HA">Hotel - Aeropuerto</option>
                                            <option value="REDHH">Redondo / Hotel - Hotel</option>
                                            <option value="SEN/HH">Sencillo / Hotel - Hotel</option>
                                        </select>
                                    </div> 
                                    <div class="form-inline col-md-2" id="content_date_star_edit">
                                        <label id="label_date_star_edit" class=" pr-3" for="datepicker_star"><i id="icon_date_s" class="fas fa-calendar-alt"></i></label>
                                        <input type="text" id="datepicker_star_edit" name="datepicker_star_edit" autocomplete="off" placeholder="Selecciona una fecha" class="form-control form-control-plaintext form-control-sm" aria-describedby="date">
                                    </div>
                                    <div class="form-inline col-md-2" id="content_date_end_edit">
                                        <label for="datepicker_end" class="pr-3"><i id="icon_date_e" class="fas fa-calendar-minus"></i></label>
                                        <input type="text" id="datepicker_end_edit" name="datepicker_end_edit" autocomplete="off" placeholder="Selecciona una fecha" class="form-control form-control-plaintext form-control-sm" aria-describedby="date">
                                    </div> 
                                    <div class="form-inline col-md-1" id="content_btn_search">
                                        <button type="submit" class="btn_animation btn  btn-sm btn-block btn-yamevi_2"  id="btn_search_reserva_edit"><span>Buscar </span></button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-6">
                    <div class=" mt-2 mb-5">
                        <div class="d-flex justify-content-center row">
                            <div class="col-xl-12 col-md-12 content_steps">
                                <h3>PASO 2</h3>
                                <p>Elija el servicio de su preferencia y llene los detalles de su vuelo...</p>
                            </div>
                            <div class="col-xl-12 col-md-12 content_card_results pt-2" >
                                <!-- <div class="row mb-3 mt-3 p-2 bg-white border rounded">
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
                                                <small><strong>Riu Dunamar</strong></small><br>
                                                <small>Sencillo - Aeropuerto a Hotel</small><br>
                                                <small>Pasajeros: 2</small><br>
                                            </div>
                                            <div class="row mt-2 content_prices_results">
                                                <div class="col-xl-6 col-md-12 ">
                                                    <i class="fal fa-circle"></i>
                                                    <h5>SENCILLO</h5>
                                                    <h5 class="mt-1"><strong>$120 MXN</strong></h5>
                                                    <small>$15.30 USD</small>
                                                </div>
                                                <div class="col-xl-6 col-md-12">
                                                    <i class="fal fa-circle"></i>
                                                    <h5>REDONDO</h5>
                                                    <h5 class="mt-1"><strong>$350 MXN</strong></h5>
                                                    <small>$22.35 USD</small>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column mt-4">
                                                <p>NO DISPONIBLE</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 mt-3 p-2 bg-white border rounded mt-2">
                                    <div class="col-md-3 mt-1 text-center content_card_result_center">
                                        <div>
                                            <img class="img-fluid img-responsive rounded product-image" src="../assets/img/traslados/lujo.png">
                                            <br><br>
                                            <h5 style="text-transform: uppercase;">SERVICIO <span style="color: #E1423B;">LUJO</span></h5>
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
                                    <div class="col-xl-3 col-md-3 border-left mt-1 content_prices_card_resilt">
                                        <div class="w-100 text-center">
                                            <div class=" text-center align-items-center">
                                                <small><strong>Riu Dunamar</strong></small><br>
                                                <small>Sencillo - Aeropuerto a Hotel</small><br>
                                                <small>Pasajeros: 2</small><br>
                                                <h4 class="mt-1"><strong>$1900 MXN</strong></h4>
                                            </div>
                                            <div class="d-flex flex-column mt-4">
                                                <button type="submit" class="btn_animation_2 btn btn-block btn-yamevi"  ><span>Reservar </span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 mt-3 p-2 bg-white border rounded mt-2">
                                    <div class="col-md-3 mt-1 text-center content_card_result_center">
                                        <div>
                                            <img class="img-fluid img-responsive rounded product-image" src="../assets/img/traslados/priv_com.png">
                                            
                                            <br><br>
                                            <h5 style="text-transform: uppercase;">SERVICIO <span style="color: #E1423B;">COMPARTIDO</span></h5>
                                        </div>
                                    </div>
                                    <div class="xol-xl-6 col-md-6 mt-1 mb-1 content_rules_card_result">
                                        <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Incluye todos los impuestos y tasas aeroportuarias.</span></div>
                                        <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Seguro de viajero.</span></div>
                                        <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Recepción por uno de nuestros representantes.</span></div>
                                        <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> Servicio a la mayoría de los hoteles.</span></div>
                                        <div class="mt-1 mb-1 spec-1"><i class="fas fa-check"></i> <span> El servicio compartido sale de forma continua desde el aeropuerto. </span></div>
                                    </div>
                                    <div class="col-xl-3 col-md-3 border-left mt-1 content_prices_card_resilt">
                                        <div class="w-100 text-center">
                                            <div class=" text-center align-items-center">
                                                <small><strong>Riu Dunamar</strong></small><br>
                                                <small>Sencillo - Aeropuerto a Hotel</small><br>
                                                <small>Pasajeros: 2</small><br>
                                                <h4 class="mt-1"><strong>$360 MXN</strong></h4>
                                            </div>
                                            <div class="d-flex flex-column mt-4">
                                                <button class="btn btn-yamevi btn-sm" type="button">Reservar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- BUSQUEDA DE TRASLADO -->
        <div class="container container_pages" id="content_search">
            <div class="row">
                <div class="col-lg-5 col-md-6 col-sm-6 p-3 content_traslados_1">
                    <div class="card">
                        <div class="card_header text-center">
                            <h4><i class="fas fa-calendar-check pr-4"></i>R e s e r v a c i ó n</h4>
                        </div>
                        <div class="card-body">
                            <form id="form_reserva" > 
                                <input type="hidden" class="" value="<?php echo $_SESSION['yt_todaysale']?>" id="inp_todaysale">
                                <div class="form-group">
                                    <label for="inp_hotel">Hotel</label>
                                    <input list="encodings" value="" id="inp_hotel" name="inp_hotel" placeholder="Ingresa el hotel" class="form-control form-control-sm ">
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
                                <div class="form-group content_interhotel">
                                    <label for="inp_hotel_2">Hotel Destino</label>
                                    <input list="encodings" value="" id="inp_hotel_2" name="inp_hotel_2" placeholder="Ingresa el hotel" class="form-control form-control-sm ">
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
                                <div class="form-group">
                                    <label for="inp_traslado">Traslado</label>
                                    <select class="custom-select custom-select-sm " id="inp_traslado" name="inp_traslado">
                                        <option value="">Seleccione tipo de traslado</option>
                                        <option value="RED">Redondo</option>
                                        <option value="SEN/AH">Aeropuerto - Hotel</option>
                                        <option value="SEN/HA">Hotel - Aeropuerto</option>
                                        <option value="REDHH">Redondo / Hotel - Hotel</option>
                                        <option value="SEN/HH">Sencillo / Hotel - Hotel</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="inp_pasajeros">Pasajeros</label>
                                    <select class="custom-select custom-select-sm" id="inp_pasajeros" name="inp_pasajeros" placeholder="Seleccione núm. de pasajeros">
                                        <option value="">Seleccione núm. de pasajeros</option>
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
                                <div class="form-group" id="content_date_star">
                                    <label id="label_date_star" for="datepicker_star">Llegada</label>
                                    <div class="input-group">
                                        <input type="text" id="datepicker_star" name="datepicker_star" autocomplete="off" placeholder="Selecciona una fecha" class="form-control form-control-sm" aria-describedby="date">
                                        <div class="input-group-append mr-2">
                                            <span class="input-group-text" id="date"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group pb-2" id="content_date_end">
                                    <label for="datepicker_end">Salida</label>
                                    <div class="input-group">
                                        <input type="text" id="datepicker_end" name="datepicker_end" autocomplete="off" placeholder="Selecciona una fecha" class="form-control form-control-sm" aria-describedby="date">
                                        <div class="input-group-append mr-2">
                                            <span class="input-group-text" id="date"><i class="far fa-calendar-minus"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn_animation btn btn-block btn-yamevi_2"  id="btn_search_reserva"><span>B u s c a r </span></button>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-6 col-sm-6 p-3 content_traslados_2" >
                    <ul class="fast_access" data-animation="to-top">
                        <li>
                            <a href="users.php" title=" Ver Usuarios">
                            <span><p>Usuarios</p><h5><?php echo $fast_access->{'users'} ?></h5></span>
                            <span>
                            <i class="fas fa-user"  aria-hidden="true"></i>
                            </span>
                            </a>
                        </li>
                        <li>
                            <a href="reservations.php" title="Ver Reservaciones">
                            <span><p>Reservaciones</p><h5><?php echo $fast_access->{'reservations'} ?></h5></span>
                            <span>
                                <i class="fas fa-calendar-check" aria-hidden="true"></i>    
                            </span>
                            </a>
                        </li>
                        <li>
                            <a href="conciliations.php" id="btn_no_conciliations" title="Ver Pendientes de conciliar">
                            <span><p>Pte. Conciliar</p><h5><?php echo $fast_access->{'no_conciliations'} ?></h5></span>
                            <span>
                                <i class="fas fa-gavel" aria-hidden="true"></i>      
                            </span>
                            </a>
                        </li>
                        <li>
                            <a href="conciliations.php" title="Ver Conciliados">
                            <span><p>Conciliados</p><h5><?php echo $fast_access->{'conciliations'} ?></h5></span>
                            <span>
                                <i class="fas fa-handshake" aria-hidden="true"></i>    
                            </span>
                            </a>
                        </li>
                    </ul>
                    <br>
                    <div class="content_btn_cuentas">
                        <div>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-yamevi" title="Ver cuentas" data-toggle="modal" data-target="#exampleModal">
                            Cuentas para pagos
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- FORM BLOQUEADO POR FUERA DE HORARIO -->
        <div class="container" id="content_bloquee">
            <div class="row">
                <div class="col-lg-5 col-md-6 col-sm-6 p-3 content_traslados_1">
                    <div class="card">
                        <div class="card_header text-center">
                            <h4><i class="fas fa-calendar-check pr-4"></i>R e s e r v a c i ó n</h4>
                        </div>
                        <div class="card-body">
                            <form id="form_reserva_bloquee" > 
                                <div class="form-group">
                                    <label for="inp_hotel">Hotel</label>
                                    <input list="encodings" value=""  placeholder="Ingresa el hotel" class="form-control form-control-sm " disabled>
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
                                <div class="form-group content_interhotel">
                                    <label for="inp_hotel_2">Hotel Destino</label>
                                    <input list="encodings" value=""  placeholder="Ingresa el hotel" class="form-control form-control-sm " disabled>
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
                                <div class="form-group">
                                    <label for="inp_traslado">Traslado</label>
                                    <select class="custom-select custom-select-sm "  disabled>
                                        <option value="">Seleccione tipo de traslado</option>
                                        <option value="RED">Redondo</option>
                                        <option value="SEN/AH">Aeropuerto - Hotel</option>
                                        <option value="SEN/HA">Hotel - Aeropuerto</option>
                                        <option value="REDHH">Redondo / Hotel - Hotel</option>
                                        <option value="SEN/HH">Sencillo / Hotel - Hotel</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="inp_pasajeros">Pasajeros</label>
                                    <select class="custom-select custom-select-sm"  placeholder="Seleccione núm. de pasajeros" disabled>
                                        <option value="">Seleccione núm. de pasajeros</option>
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
                                <div class="form-group" id="content_date_star">
                                    <label id="label_date_star" for="datepicker_star">Llegada</label>
                                    <div class="input-group">
                                        <input type="text"  autocomplete="off" placeholder="Selecciona una fecha" class="form-control form-control-sm" aria-describedby="date" disabled>
                                        <div class="input-group-append mr-2">
                                            <span class="input-group-text" id="date"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group pb-2" id="content_date_end">
                                    <label for="datepicker_end">Salida</label>
                                    <div class="input-group">
                                        <input type="text"  autocomplete="off" placeholder="Selecciona una fecha" class="form-control form-control-sm" aria-describedby="date" disabled>
                                        <div class="input-group-append mr-2">
                                            <span class="input-group-text" id="date"><i class="far fa-calendar-minus"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <p  class="text_not_available reserva_disabled text-center"></p>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-6 col-sm-6 p-3 content_traslados_2" >
                <ul class="fast_access" data-animation="to-top">
                        <li>
                            <a href="users.php" title=" Ver Usuarios">
                            <span><p>Usuarios</p><h5><?php echo $fast_access->{'users'} ?></h5></span>
                            <span>
                            <i class="fas fa-user"  aria-hidden="true"></i>
                            </span>
                            </a>
                        </li>
                        <li>
                            <a href="reservations.php" title="Ver Reservaciones">
                            <span><p>Reservaciones</p><h5><?php echo $fast_access->{'reservations'} ?></h5></span>
                            <span>
                                <i class="fas fa-calendar-check" aria-hidden="true"></i>    
                            </span>
                            </a>
                        </li>
                        <li>
                            <a href="conciliations.php" title="Ver Pendientes de conciliar">
                            <span><p>Pte. Conciliar</p><h5><?php echo $fast_access->{'no_conciliations'} ?></h5></span>
                            <span>
                                <i class="fas fa-gavel" aria-hidden="true"></i>      
                            </span>
                            </a>
                        </li>
                        <li>
                            <a href="conciliations.php" title="Ver Conciliados">
                            <span><p>Conciliados</p><h5><?php echo $fast_access->{'conciliations'} ?></h5></span>
                            <span>
                                <i class="fas fa-handshake" aria-hidden="true"></i>    
                            </span>
                            </a>
                        </li>
                    </ul>
                    <br>
                    <div class="content_btn_cuentas">
                        <div>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-yamevi" title="Ver cuentas" data-toggle="modal" data-target="#exampleModal">
                            Cuentas para pagos
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        
        <!-- Modal -->
        <div class="modal fade " id="exampleModal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cuentas para pagos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <p>Cuentas en pesos MXN</p>
                                <h5>Banco Santender</h5>
                                <small>Cuenta: 65506503248</small><br>
                                <small>SANTANDER SUC 0268 AV TULUM NO. 173
                                    LOTES 14-15 MZ 3 SMZ 20
                                    VIAJES Y ACTIVIDADES EL COLETO SA DE CV
                                </small><br>
                                <small>RFC: VAC160624716</small>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <p>Transferencia o Pago</p>
                                <h5>OXXO</h5>
                                <small>Tarjeta de credito (Santander)</small><br>
                                <small>4913 2700 0074 0396</small>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <p>Cuenta en dolares USD</p>
                                <h5>Banco Santander</h5>
                                <small>Cuenta: 82500836211</small><br>
                                <small>Clabe: 014691825008362113</small><br>
                                <small>SANTANDER SUC 0268 AV TULUM NO. 173
                                    LOTES 14-15 MZ 3 SMZ 20
                                    VIAJES Y ACTIVIDADES EL COLETO SA DE CV
                                </small><br>
                                <small>RFC: VAC160624716</small>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <p>Cuenta colombia</p>
                                <h5>Banco Davivienda</h5>
                                <small>Cuenta: 476100093733</small><br>
                                <small>CHAPINORTE, BOGOTA – COLOMBIA
                                CALLE 67 No. 12 – 57
                                YAMEVI TRAVEL SAS</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Modal Success -->
        <div id="myModal"  class="modal fade"  data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-confirm">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <div class="icon-box">
                            <i class="material-icons">&#xE876;</i>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" onclick="window.location.href='transfers.php'" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body text-center">
                        <h4>Excelente!</h4>	
                        <p id="msj_success"></p>
                        <button class="btn btn-success" id="btn_succes_r"  onclick="window.location.href='reservations.php'" data-dismiss="modal"><span>Mis Reservaciones</span> <i class="material-icons">&#xE5C8;</i></button>
                    </div>
                </div>
            </div>
        </div>     

        <!-- Modal Error -->
        <div id="myModalerror" data-backdrop="static" data-keyboard="false" class="modal fade">
            <div class="modal-dialog modal-confirm">
                <div class="modal-content">
                    <div class="modal-header justify-content-center" id="header_error">
                        <div class="icon-box">
                            <i class="material-icons">&#xE5CD;</i>
                        </div>
                        <button type="button" class="close" data-dismiss="modal"  onclick="window.location.href='transfers.php'" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body text-center">
                        <h4>Ooops!</h4>	
                        <p>Hubo un error al realizar su reservacion. Intente más tarde.</p>
                        <button class="btn btn-success" data-dismiss="modal" onclick="window.location.href='transfers.php'"><span>Reservar</span> <i class="material-icons">&#xE5C8;</i></button>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</body>
    <?php include('include/footer_agencies.php')?>
    <?php include('include/scrips_agencies.php')?>
    <script src="../assets/js/agencies-transfers.js"></script>
<script>
    document.onkeydown = function(e){
        tecla = (document.all) ? e.keyCode : e.which;
        if (tecla == 116){
            if (confirm("Si refesca la pagina se limpiara los datos de la búsqueda, ¿Seguro que quieres refrescar la página? ") == true) {
                return true;
                } else {
                return false;
            }
        }
    }
</script>
</html>