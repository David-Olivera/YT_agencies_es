<?php
    include('../model/usuarios.php');
    $usuarios = new User();

    if (isset($_POST['action']) && $_POST['action'] == 'add_user') {
        $request = (object) $_POST;
        $req = json_encode($request);
        echo $usuarios->new_user($req);
    }
    if (isset($_POST['action']) && $_POST['action'] == 'get_user') {
        $request = (object) $_POST;
        $req = json_encode($request);
        echo $usuarios->get_user($req);
    }
    if (isset($_POST['action']) && $_POST['action'] == 'edit_user') {
        $request = (object) $_POST;
        $req = json_encode($request);
        echo $usuarios->edit_user($req);
    }
    if (isset($_POST['action']) && $_POST['action'] == 'delete_user') {
        $request = (object) $_POST;
        $req = json_encode($request);
        echo $usuarios->delete_user($req);
    }
?>