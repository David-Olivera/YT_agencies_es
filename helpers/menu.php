<?php
    include('../model/menu.php');
    $navigation = new Navigation();

    //Load Electronic Purse
    if (isset($_POST['action']) && $_POST['action'] == 'get_electronic_purse') {
        $request = (object) $_POST;
         $req = json_encode($request);
         echo $navigation->load_electronic_purse($req);
    }
    //get exchange
    if (isset($_POST['action']) && $_POST['action'] == 'get_exchange_rate') {
        $request = (object) $_POST;
         $req = json_encode($request);
         echo $navigation->getExchangeRate($req);
    }

?>