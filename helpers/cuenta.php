<?php
    include('../model/cuenta.php');
    $account = new Account();

    if (isset($_POST['get_data_account']) && $_POST['get_data_account'] == true) {
        $request = (object) $_POST;
        $req = json_encode($request);
        echo $account->get_data_account($req);
    }
    //Delete img
    if (isset($_POST['delete']) && $_POST['delete'] == 'delete_img') {
        $request = (object) $_POST;
         $req = json_encode($request);
         echo $account->deleteImg($req);
    }
    //Update data account
    if (isset($_POST['action']) && $_POST['action'] == 'update_data') {
        $request = (object) $_POST;
         $req = json_encode($request);
         echo $account->updateDatas($req);
    }
    //Update data account
    if (isset($_POST['action']) && $_POST['action'] == 'update_credentials') {
        $request = (object) $_POST;
         $req = json_encode($request);
         echo $account->updateCredentials($req);
    }

?>