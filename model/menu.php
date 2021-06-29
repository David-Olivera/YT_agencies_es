<?php 
    class Navigation{
        public function load_electronic_purse($obj){
            include('../config/conexion.php');
            $ins = json_decode($obj);
            $id_agency = mysqli_real_escape_string($con,$ins->id_agency);
            $query = "SELECT SUM(amount_electronic) as total FROM electronic_purse  WHERE id_agency = $id_agency;";
            $result = mysqli_query($con, $query);
            if ($result){
                $fila = mysqli_fetch_assoc($result);
                return $fila['total'];
            }
        }
        //Get Exchange
        public function getExchangeRate($obj){
            include('../config/conexion.php');
            $query = "SELECT * FROM exchange_rate WHERE status = 1;";
            $result = mysqli_query($con, $query);
            if ($result) {
                $ins = mysqli_fetch_object($result);
                return $ins->amount_change;
            }
        }
    }

?>