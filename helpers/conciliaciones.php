<?php
    include('../model/conciliaciones.php');
    $conciliation = new Conciliation();

    if (isset($_POST['action']) && $_POST['action'] == 'upload_docs') {
        $request = (object) $_POST;
        $req = json_encode($request);
        echo $conciliation->upload_documents($req);
    }
    if (isset($_POST['action']) && $_POST['action'] == 'upload_docs_multi') {
        $request = (object) $_POST;
        $req = json_encode($request);
        echo $conciliation->upload_documents_multi($req);
    }

    if (isset($_POST['action']) && $_POST['action'] == 'load_docs') {
        $request = (object) $_POST;
        $req = json_encode($request);
        echo $conciliation->load_documents($req);
    }

    if (isset($_POST['action']) && $_POST['action'] == 'delete_doc') {
        $request = (object) $_POST;
        $req = json_encode($request);
        echo $conciliation->delete_documents($req);
    }

?>