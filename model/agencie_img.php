<?php
    require_once '../config/conexion.php';
        $name_ame_img = $_POST['name_age_img'];
        $nombre_archivo_temporar=$_FILES["imagen"]["tmp_name"];		
        $nombre_archivo_original=$_FILES["imagen"]["name"];
        $query="SELECT * FROM agencies WHERE icon_agency = '$name_ame_img';";
        $result2 = mysqli_query($con, $query);
        $message = 0;
            if ($result2) {
               if (mysqli_num_rows($result2) > 0) {    
                    $message = 0;      
               }else{
                    $id_agencie = mysqli_real_escape_string($con, $_POST['id_agencie_img']);
        
                    $carpeta="../assets/img/agencias/";
            
                    if (move_uploaded_file($nombre_archivo_temporar,"$carpeta/$name_ame_img")) {
                        $sql = "UPDATE agencies SET icon_agency = '$name_ame_img' WHERE id_agency = '$id_agencie';";
                        $result = mysqli_query($con, $sql);
                        if(!$result) {
                            $message = 0;
                        }
                        $message =1;
                    }
               }
                echo $message;
            }
            
    
?>