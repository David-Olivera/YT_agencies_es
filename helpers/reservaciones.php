<?php
    include('../model/reservaciones.php');
    $traslado = new Reservation();

    if (isset($_POST['action']) && $_POST['action'] == 'get_pdf') {
        $id =  $_POST['id'];
        $letter = $_POST['letter_lang'];
        $con = $_POST['con'];
        echo $traslado->get_pdf($id, $letter,$con);
    }
    if (isset($_POST['update_traslado']) && $_POST['update_traslado'] == true) {
        $request = (object) $_POST;
        $req = json_encode($request);
        echo $traslado->update_traslado($req);
    }
?>