<?php
    include('../model/reservaciones.php');
    $reservation = new Reservation();

    if (isset($_POST['action']) && $_POST['action'] == 'get_pdf') {
        $id =  $_POST['id'];
        $letter = $_POST['letter_lang'];
        $con = $_POST['con'];
        echo $reservation->get_pdf($id, $letter,$con);
    }
    if (isset($_POST['update_traslado']) && $_POST['update_traslado'] == true) {
        $request = (object) $_POST;
        $req = json_encode($request);
        echo $reservation->update_traslado($req);
    }
    
    if (isset($_POST['get_data_reserva']) && $_POST['get_data_reserva'] == true) {
        $request = (object) $_POST;
        $req = json_encode($request);
        echo $reservation->getDetailsReservation($req);
    }
    
    if (isset($_POST['action']) && $_POST['action'] == 'update_reservation_state') {
        $request = (object) $_POST;
        $req = json_encode($request);
        echo $reservation->updateReservationState($req);
    }
?>