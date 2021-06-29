<?php
    class Conciliation{
        function upload_documents($obj){
            include('../config/conexion.php');
            $path="../assets/docs/conciliaciones/";//server path
            $ins = json_decode($obj);
            $code_invoice = mysqli_real_escape_string($con,$ins->code_invoice);
            $id_reservation = mysqli_real_escape_string($con,$ins->id_reservation);
            $id_conciliation = mysqli_real_escape_string($con,$ins->id_conciliation);
            $id_agency = mysqli_real_escape_string($con,$ins->id_agency);
            $facture = mysqli_real_escape_string($con,$ins->facture);
            $today = date('Y-m-d H:i:s');
            date_default_timezone_set('America/Cancun');
            $status = 1;
            foreach($_FILES as $key){
                if($key['error'] == UPLOAD_ERR_OK ){                    
                    $name = $key['name'];
                    $new_name = $code_invoice.'_'.$name;
                    $temp = $key['tmp_name'];
                    $size= ($key['size'] / 1000)."Kb";
                    $ext = $key['type'];
                    if ($ext == "application/pdf" || $ext == "image/jpeg" || $ext == "image/jpg" || $ext == "image/png") {
                        $query_select= "SELECT * FROM conciliation_docs WHERE file_document like '$new_name' and id_conciliation like $id_conciliation;";
                        $result_select = mysqli_query($con, $query_select);
                        if ($result_select) {
                            if (mysqli_num_rows($result_select) > 0) {
                                echo "
                                    <div>
                                    <h12><strong>Archivo: $new_name</strong></h2><br />
                                    <h12><strong>Tamaño: $size</strong></h2><br />
                                    <hr>
                                    </div>
                                    <div class='text-center'>
                                        <p><small>Ya existe un archivo con el mismo nombre, favor de intentarlo más tarde</small> <i class='denied fas fa-times-circle text-danger'></i></p>
                                    </div>
            
                                ";
                                
                            }else{
                                $query = "INSERT INTO conciliation_docs(id_conciliation,file_document,register_date,facture)VALUES($id_conciliation, '$new_name', '$today', $facture);";
                                $result = mysqli_query($con, $query);
                                if ($result) {
                                    if (move_uploaded_file($temp, $path . $new_name)) {
                                    echo "
                                        <div>
                                            <h12><strong>Archivo: $new_name</strong></h2><br />
                                            <h12><strong>Tamaño: $size</strong></h2><br />
                                            <hr>
                                        </div>
                                        <div class='form-group text-center'>
                                                <p><small>El archivo a sido agregado correctamente </small> <i class='approved fas fa-check-circle text-success'></i></p>
                                                <p><small>Su reservacion se encuentra garantizada, en caso de haber un problema con su pago, nos contactaremos con usted.</p>
                                        </div>
                                        ";
                                    }
                                }else{
                                    echo "
                                        <div>
                                            <h12><strong>Archivo: $new_name</strong></h2><br />
                                            <h12><strong>Tamaño: $size</strong></h2><br />
                                            <hr>
                                        </div>
                                        <div class='text-center'>
                                            <p><small>Error al registrar el archivo </small> <i class='denied fas fa-times-circle text-danger'></i></p>
                                        </div>
                
                                    ";
                                }  
                            }
                        }
                    }else{
                        echo "
                        <div>
                            <h12><strong>Archivo: $new_name</strong></h2><br />
                            <h12><strong>Tamaño: $size</strong></h2><br />
                            <hr>
                        </div>
                        <div class='text-center'>
                            <p><small>El archivo tiene una extension que no es permitida</small> <i class='denied fas fa-times-circle'></i></p>
                        </div>
        
                        ";
                        
                    }
                }else{
                    echo $key['error'];
                }
            }
        }

        function upload_documents_multi($obj){
            include('../config/conexion.php');
            $path="../assets/docs/conciliaciones/";//server path
            $ins = json_decode($obj);
            $code_invoice = mysqli_real_escape_string($con,$ins->code_invoice);
            $id_reservation = mysqli_real_escape_string($con,$ins->id_reservation);
            $id_conciliation = mysqli_real_escape_string($con,$ins->id_conciliation);
            $id_agency = mysqli_real_escape_string($con,$ins->id_agency);
            $facture = mysqli_real_escape_string($con,$ins->facture);
            $key_u = mysqli_real_escape_string($con,$ins->key_u);
            $today = date('Y-m-d H:i:s');
            date_default_timezone_set('America/Cancun');
            foreach($_FILES as $key){
                if($key['error'] == UPLOAD_ERR_OK ){                    
                    $name = $key['name'];
                    $new_name = $code_invoice.'_'.$name;
                    $temp = $key['tmp_name'];
                    $size= ($key['size'] / 1000)."Kb";
                    $ext = $key['type'];
                    if ($ext == "application/pdf" || $ext == "image/jpeg" || $ext == "image/jpg" || $ext == "image/png") {
                        $query_select= "SELECT * FROM conciliation_docs WHERE file_document like '$new_name' and id_conciliation like $id_conciliation;";
                        $result_select = mysqli_query($con, $query_select);
                        if ($result_select) {
                            if (mysqli_num_rows($result_select) > 0) {
                                echo "
                                    <div>
                                    <h12><strong>Archivo: $new_name</strong></h2><br />
                                    <h12><strong>Tamaño: $size</strong></h2><br />
                                    <hr>
                                    </div>
                                    <div class='text-center'>
                                        <p><small>Ya existe un archivo con el mismo nombre, favor de intentarlo más tarde</small> <i class='denied fas fa-times-circle text-danger'></i></p>
                                    </div>
            
                                ";
                                
                            }else{
                                $query = "INSERT INTO conciliation_docs(id_conciliation,file_document,register_date,facture,conciliation_multiple)VALUES($id_conciliation, '$new_name', '$today', $facture, '$key_u');";
                                $result = mysqli_query($con, $query);
                                if ($result) {
                                    if (move_uploaded_file($temp, $path . $new_name)) {
                                    echo "
                                        <div>
                                            <h12><strong>Archivo: $new_name</strong></h2><br />
                                            <h12><strong>Tamaño: $size</strong></h2><br />
                                            <hr>
                                        </div>
                                        <div class='form-group text-center'>
                                                <p><small>El archivo a sido agregado correctamente </small> <i class='approved fas fa-check-circle text-success'></i></p>
                                                <p><small>Su reservacion se encuentra garantizada, en caso de haber un problema con su pago, nos contactaremos con usted.</p>
                                        </div>
                                        ";
                                    }
                                }else{
                                    echo "
                                        <div>
                                            <h12><strong>Archivo: $new_name</strong></h2><br />
                                            <h12><strong>Tamaño: $size</strong></h2><br />
                                            <hr>
                                        </div>
                                        <div class='text-center'>
                                            <p><small>Error al registrar el archivo </small> <i class='denied fas fa-times-circle text-danger'></i></p>
                                        </div>
                
                                    ";
                                }  
                            }
                        }
                    }else{
                        echo "
                        <div>
                            <h12><strong>Archivo: $new_name</strong></h2><br />
                            <h12><strong>Tamaño: $size</strong></h2><br />
                            <hr>
                        </div>
                        <div class='text-center'>
                            <p><small>El archivo tiene una extension que no es permitida</small> <i class='denied fas fa-times-circle'></i></p>
                        </div>
        
                        ";
                        
                    }
                }else{
                    echo $key['error'];
                }
            }
        }

        function load_documents($obj){
            $ins = json_decode($obj);
            include('../config/conexion.php');
            $id = mysqli_real_escape_string($con,$ins->{'id_agency'});
            $id_conciliation = $ins->{'id_conciliation'};
            $query = "SELECT * FROM conciliation AS C INNER JOIN conciliation_docs AS CD ON C.id_conciliation = CD.id_conciliation WHERE CD.id_conciliation = $id_conciliation;";
            $json = array();
            $result = mysqli_query($con, $query);
            if (!$result) {
                $json="No tiene documentos registrados";
            }
            if (mysqli_num_rows($result)> 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $new_name_doc = substr($row['file_document'],0,43);
                    $json[] = array('id_concidocs' => $row['id_concidocs'], 'file_document' => $new_name_doc, 'file_document_completed' => $row['file_document'], 'register_date' => $row['register_date'], 'id_agency' => $row['id_agency'], 'facture' => $row['facture']);
                }
            }
            $jsonString = json_encode($json);
            return $jsonString;
        }

        function delete_documents($obj){
            $ins = json_decode($obj);
            include('../config/conexion.php');
            $id_conciliation = mysqli_real_escape_string($con,$ins->{'id'});
            $id_agency = mysqli_real_escape_string($con,$ins->{'id_agency'});
            $name_doc = mysqli_real_escape_string($con,$ins->{'name_doc'});
            $directorio = "../assets/docs/conciliaciones/$name_doc";
            $query = "DELETE FROM conciliation_docs WHERE id_concidocs = $id_conciliation";
            $result = mysqli_query($con, $query);
            if (!$result) {
                die('Error al eliminar la agencia');
                $message = "
                <div class='text-center'>
                    <p><small>Error al eliminar el documento</small> <i class='denied fas fa-times-circle text-danger'></i></p>
                </div>";
            }

            unlink($directorio);
            $message = "<div class='text-center'>
                    <p><small>El archivo $name_doc a sido eliminado correctamente</small> <i class='approved fas fa-check-circle text-success'></i></p>
                </div>";
            return $message;
        }
    }
?>