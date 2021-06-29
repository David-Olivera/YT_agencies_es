<?php
    class Account{
        public function get_data_account($obj){
            include('../config/conexion.php');
            $ins = json_decode($obj);
            $id = $ins->id;
            $new_id_agency = mysqli_real_escape_string($con,$id);
            $query = "SELECT * FROM agencies WHERE id_agency = $new_id_agency;";
            $result = mysqli_query($con, $query);
            if (!$result) {
                $mej ="Error al traer los datos  de la cuenta";
                return $mej;
            }
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $jsonString = json_encode($row);
            mysqli_close($con);
            return $jsonString;
        }
        //Delete amenidad img
        public function deleteImg($obj){
            $ins = json_decode($obj);
            include('../config/conexion.php');
            $message = 0;
            if (isset( $ins->{'id'})) {
                $id =  $ins->{'id'};
                $status = 0;
                $query = "UPDATE agencies SET icon_agency = '' WHERE id_agency = $id";
                $result = mysqli_query($con, $query);
                if (!$result) {
                    $message = 0;
                }
                $message = 1;
                return $message;
            }
        }

        //Updata datas account
        public function updateDatas($obj){
            $ins = json_decode($obj);
            include('../config/conexion.php');
            $new_id = mysqli_real_escape_string($con, $ins->id);
            $new_name_agencie = mysqli_real_escape_string($con, $ins->name_agency);
            $new_name_contect = mysqli_real_escape_string($con, $ins->name_contect);
            $new_last_name = mysqli_real_escape_string($con, $ins->last_name);
            $new_email_contact = mysqli_real_escape_string($con, $ins->email_contact);
            $new_email_pay = mysqli_real_escape_string($con, $ins->email_pay);
            $new_phone_agency = mysqli_real_escape_string($con, $ins->phone_agency);
            $status = 0;
            $query = "UPDATE agencies SET name_agency = '$new_name_agencie', email_agency = '$new_email_contact', email_pay_agency = '$new_email_pay', phone_agency = '$new_phone_agency', name_contact = '$new_name_contect', last_name_contact = '$new_last_name' WHERE id_agency = $new_id;";
            $result = mysqli_query($con, $query);
            if (!$result) {
                $status = 0;
            }
            $status = 1;
            return $status;
        }

        //Update credentials account
        public function updateCredentials($obj){
            $ins = json_decode($obj);
            include('../config/conexion.php');
            $new_id = mysqli_real_escape_string($con, $ins->id);
            $new_username = mysqli_real_escape_string($con, $ins->username);
            $new_password = mysqli_real_escape_string($con, $ins->password);
            $status = 0;
            $query = "";
            if($new_password != ''){
                $md5_pass = md5($new_password);
                $query = "UPDATE agencies SET username = '$new_username', password = '$md5_pass' WHERE id_agency = $new_id;";
            }else{
                $query = "UPDATE agencies SET username = '$new_username' WHERE id_agency = $new_id;";
            }
            $result = mysqli_query($con, $query);
            if (!$result) {
                $status = 0;
            }
            $status = 1;
            return $status;
        }

    }

?>