<?php
    class User{
        function get_user($obj){
            $ins = json_decode($obj);
            include('../config/conexion.php');
            $id_user = mysqli_real_escape_string($con,$ins->id_user);
            $query ="SELECT * FROM users WHERE id_user = $id_user;";
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

        function new_user($obj){
            $ins = json_decode($obj);
            include('../config/conexion.php');
            $id_agency = mysqli_real_escape_string($con,$ins->id_agency);
            $user_name = mysqli_real_escape_string($con,$ins->name_user);
            $user_lastname = mysqli_real_escape_string($con,$ins->last_name);
            $user_phone = mysqli_real_escape_string($con,$ins->phone_user);
            $user_email = mysqli_real_escape_string($con,$ins->email_user);
            $user_username = mysqli_real_escape_string($con,$ins->username);
            $user_password = mysqli_real_escape_string($con,$ins->password);
            $md5_pass = md5($user_password);
            $user_password_confirm = mysqli_real_escape_string($con,$ins->password_confirm);
            $status= 0;
            $query = "INSERT INTO users(first_name,last_name,email_user,phone_user,username,password,id_agency,id_role)VALUES('$user_name', '$user_lastname', '$user_email', '$user_phone','$user_username','$md5_pass',$id_agency,5);";
            $result = mysqli_query($con, $query);
            if($result){
                $status = 1;
                echo $status;
            }else {
                echo $status;
            }

            
        }

        function edit_user($obj){
            $ins = json_decode($obj);
            include('../config/conexion.php');
            $id_user = mysqli_real_escape_string($con,$ins->id_user);
            $id_agency = mysqli_real_escape_string($con,$ins->id_agency);
            $user_name = mysqli_real_escape_string($con,$ins->name_user);
            $user_lastname = mysqli_real_escape_string($con,$ins->last_name);
            $user_phone = mysqli_real_escape_string($con,$ins->phone_user);
            $user_email = mysqli_real_escape_string($con,$ins->email_user);
            $user_username = mysqli_real_escape_string($con,$ins->username);
            $user_password = mysqli_real_escape_string($con,$ins->password);
            $user_password_confirm = mysqli_real_escape_string($con,$ins->password_confirm);
            $status= 0;
            $query="";
            if($user_password != ''){
                $md5_pass = md5($user_password);
                $query ="UPDATE users SET first_name = '$user_name', last_name = '$user_lastname', email_user = '$user_email', phone_user = '$user_phone', username = '$user_username', password = '$md5_pass' WHERE id_user = $id_user;";
            }else{
                $query ="UPDATE users SET first_name = '$user_name', last_name = '$user_lastname', email_user = '$user_email', phone_user = '$user_phone', username = '$user_username' WHERE id_user = $id_user;";
            }
            $result = mysqli_query($con, $query);
            if($result){
                $status = 1;
                echo $status;
            }else {
                echo $status;
            }
        }

        function delete_user($obj){
            $ins = json_decode($obj);
            include('../config/conexion.php');
            $status = 0;
            $id_user = mysqli_real_escape_string($con,$ins->id);
            $query = "DELETE FROM users WHERE id_user = $id_user;";
            $result = mysqli_query($con, $query);
            if($result){
                $status = 1;
                echo $status;
            }else{
                echo $status;
            }
        }
    }
?>