<?php
    include('path.php');
    $id_agency = $_SESSION['yt_id_agency'];
    echo '
        <nav class="navbar navbar-expand-lg" id="nav_agencies">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>                
            <a class="navbar-brand nav_icon" href="#">
                <img src="../assets/img/icon/icon.png" alt="">
            </a>               
            <a class="navbar-brand nav_icon_movil" href="#">
                <img src="../assets/img/icon/icon_25.png" alt="">
            </a>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li  '.(($page=='home.php')?'class="current nav-item "':'class="nav-item "').'>
                        <a class="nav-link" href="home.php">Inicio</a>
                    </li>
                    <li '.(($page=='transfers.php')?'class="current nav-item "':'class="nav-item "').'>
                        <a class="nav-link" href="transfers.php">Traslados</a>
                    </li>
                    <li '.(($page=='reservations.php')?'class="current nav-item "':'class="nav-item "').'>
                        <a class="nav-link" href="reservations.php">Reservas</a>
                    </li>
                    <li '.(($page=='conciliations.php')?'class="current nav-item "':'class="nav-item "').'>
                        <a class="nav-link " href="conciliations.php">Conciliaciones</a>
                    </li>
                    <li '.(($page=='users.php')?'class="current nav-item "':'class="nav-item "').'>
                        <a class="nav-link " href="users.php">Usuarios</a>
                    </li>
                </ul>                
                <ul class="navbar-nav ml-md-auto mt-2 mt-lg-0">
                    
                    <li>
                        <a href="#" class="nav-link " data-toggle="modal" id="btn_electronic_purse" data-target="#electronicPurseModal">Monedero Electrónico - <span class="text-success" id="value_electronic_purse"></span></a> 
                        <input type="hidden" name="" id="inp_electronic" value="">
                    </li>
                    <li '.(($page=='account.php')?'class="current nav-item "':'class="nav-item "').'>
                    <a class="nav-link " href="account.php?a='.$id_agency.'">'.$_SESSION['yt_username'].' - '.$_SESSION['yt_id_agency'].' </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " title="Salir" href="../helpers/logout_a.php"><i class="fas fa-sign-out-alt"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
        <input type="hidden" name="" id="inp_id_agency" value="'.$_SESSION['yt_id_agency'].'">
        <input type="hidden" name="" id="inp_change_type" value="">
    ';
?>