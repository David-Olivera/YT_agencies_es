<?php 
    ob_start();
    session_start();

    $path = "https://www.yamevitravel.com/es/";

    $page = basename($_SERVER['SCRIPT_NAME']);
    $route = $_SERVER['PHP_SELF'];

    if(!isset($_SESSION['yt_id_agency'])){
        header('Location: '.$path.'');
    }    

?>