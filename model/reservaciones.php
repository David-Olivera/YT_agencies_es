<?php
    class Reservation{

        function loadFastAccess($id_agency){
            include('../config/conexion.php');
            $query_usuarios = "SELECT COUNT(*) as total FROM users WHERE id_agency = $id_agency;";
            $rs_u = mysqli_query($con, $query_usuarios);
            $row_u = mysqli_fetch_assoc($rs_u);

            $query_reservas = "SELECT COUNT(*) as total FROM reservations AS R INNER JOIN clients AS C ON R.id_client = C.id_client 
            INNER JOIN reservation_details AS D ON D.id_reservation = R.id_reservation 
            WHERE R.id_agency = $id_agency;";
            $rs_r = mysqli_query($con, $query_reservas);
            $row_r = mysqli_fetch_assoc($rs_r);

            $query_conci = "SELECT COUNT(*) as total FROM conciliation WHERE id_agency = $id_agency AND `status` = 1; ";
            $rs_con = mysqli_query($con, $query_conci);
            $row_c = mysqli_fetch_assoc($rs_con);

            $query_noconci = "SELECT COUNT(*) as total FROM conciliation WHERE id_agency = 1811 AND `status` = 0;";
            $rs_nocon = mysqli_query($con,$query_noconci);
            $row_nc = mysqli_fetch_assoc($rs_nocon);

            return json_encode(array('users' => $row_u['total'], 'reservations' => $row_r['total'], 'conciliations' => $row_c['total'], 'no_conciliations' => $row_nc['total']));
        }

        function get_pdf($id, $letter, $con){
            return $id.$letter;
        }
        //Get datas reservation
        public function getDetailsReservation($obj){
            include('../config/conexion.php');
            if ($obj) {
                $query = "SELECT * FROM clients as C
                INNER JOIN reservations AS R ON C.id_client = R.id_client
                INNER JOIN reservation_details AS D ON D.id_reservation = R.id_reservation
                WHERE md5(R.id_reservation) = '$obj';";
                $result = mysqli_query($con, $query);
                if (!$result) {
                    die('Error de consulta'. mysqli_error($con));
                }
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $jsonString = json_encode($row);
                mysqli_close($con);

                return $jsonString;
            }
        }

        public function update_traslado($obj){
            $ins = json_decode($obj);
            include('../config/conexion.php');
            $code_invoice = $ins->{'code_invoice'};
            echo $code_invoice;
        }
    }
?>