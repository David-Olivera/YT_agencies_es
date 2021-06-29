<?php 
    class Login{
        private $fileConn = '../../YameviTravel/config/conexion.php';

        public function login_access($obj){
            session_start();
            include(''.$this->fileConn.'');
            $req =json_decode($obj);
            $newemail =$req->{'username'};
            $newpassword = $req->{'password'};
            $myemail = mysqli_real_escape_string($con,$newemail);
            $mypassword = mysqli_real_escape_string($con,$newpassword); 
            $passmd5 = MD5($mypassword);
            $sql = "SELECT * FROM agencies  WHERE (email_agency = '$myemail' or username = '$myemail') and password = '$passmd5';";
            $result = mysqli_query($con,$sql);
            $status =0;
            $message = '
               <div class=" d-flex justify-content-center">
                  <div class="alert alert-danger alert-error alert-dismissible">
                     <button type="button" class="close" data-dismiss="alert">&times;</button>
                     <strong>Ups!</strong> El email o contraseña es incorrecto.
                  </div>
               </div>
            ' ;
            $json=array();
            if ($result) {     
                $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
                $count = mysqli_num_rows($result);
                if (($myemail != '') && ($newpassword !='')) {
                      if ($count == 1) {
                        if ($row['password'] == $passmd5) {
                            $_SESSION['yt_id_agency'] = $row['id_agency'];
                            $_SESSION['yt_name_agency'] = $row['name_agency'];
                            $_SESSION['yt_username'] =  $row['username'];

                            
                           //CONFIG GLOBALS
                           $conf = json_decode($this->getConfigAgency($row['id_agency'], $con));
                            $_SESSION['yt_todaysale'] = $conf->{'todaysale'};
                            $_SESSION['yt_paypal'] = $conf->{'paypal'};
                            $_SESSION['yt_cash'] = $conf->{'cash'};
                            $_SESSION['yt_card'] = $conf->{'card'};
                            $_SESSION['yt_operadora'] = $conf->{'operadora'};
                            $_SESSION['yt_internal_yt'] = $conf->{'internal_yt'};
                           if($_SESSION){
                              $status = 1 ;
                           }else{
                              $status =0;
                              $message = '
                                 <div class=" d-flex justify-content-center">
                                    <div class="alert alert-danger alert-error alert-dismissible">
                                       <button type="button" class="close" data-dismiss="alert">&times;</button>
                                       <strong>Ups!</strong> Error al buscar los datos de la agencia.
                                    </div>
                                 </div>
                              ' ;
                           }
                         }else{
                             $status = 0;
                            $message = '
                            <div class=" d-flex justify-content-center">
                               <div class="alert alert-danger alert-error alert-dismissible">
                                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                                  <strong>Error!</strong> Verifique su contraseña.
                               </div>
                            </div>
                         ' ;
                        }
                      }else{
                        $query_u = "SELECT * FROM users AS U INNER JOIN agencies AS A ON U.id_agency = A.id_agency where (U.email_user = '$myemail' or U.username = '$myemail') and U.password = '$passmd5';"; 
                        $result_u = mysqli_query($con,$query_u);
                        if ($result_u) {     
                           $row = mysqli_fetch_array($result_u,MYSQLI_ASSOC);
                           $count = mysqli_num_rows($result_u);
                           if (($myemail != '') && ($newpassword !='')) {
                              if ($count == 1){
                                    $_SESSION['yt_id_agency'] = $row['id_agency'];
                                    $_SESSION['yt_name_agency'] = $row['name_agency'];
                                    $_SESSION['yt_username'] =  $row['username'];
        
                                    
                                   //CONFIG GLOBALS
                                   $conf = json_decode($this->getConfigAgency($row['id_agency'], $con));
                                    $_SESSION['yt_todaysale'] = $conf->{'todaysale'};
                                    $_SESSION['yt_paypal'] = $conf->{'paypal'};
                                    $_SESSION['yt_cash'] = $conf->{'cash'};
                                    $_SESSION['yt_card'] = $conf->{'card'};
                                    $_SESSION['yt_operadora'] = $conf->{'operadora'};
                                    $_SESSION['yt_internal_yt'] = $conf->{'internal_yt'};
                                   if($_SESSION){
                                      $status = 1 ;
                                   }else{
                                      $status =0;
                                      $message = '
                                         <div class=" d-flex justify-content-center">
                                            <div class="alert alert-danger alert-error alert-dismissible">
                                               <button type="button" class="close" data-dismiss="alert">&times;</button>
                                               <strong>Ups!</strong> Error al buscar los datos de la agencia.
                                            </div>
                                         </div>
                                      ' ;
                                   }
                              }
                           }
                        }else {
                           $status = 0;
                           $message = '
                           <div class=" d-flex justify-content-center">
                              <div class="alert alert-danger alert-error alert-dismissible">
                                 <button type="button" class="close" data-dismiss="alert">&times;</button>
                                 <strong>Ups!</strong> El email o contraseña es incorrecto.
                              </div>
                           </div>
                        ' ;
                        }
                      }
                }else{
                    $status =0;
                   $message = '
                      <div class=" d-flex justify-content-center">
                         <div class="alert alert-danger alert-error alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Ups!</strong> Debe llenar todos los campos.
                         </div>
                      </div>
                   ' ;
                }
            }else{
                 $status = 0;
                $message = '
                <div class=" d-flex justify-content-center">
                   <div class="alert alert-danger alert-error alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>Ups!</strong> El email o contraseña es incorrecto.
                   </div>
                </div>
             ' ;
            }
             $json[]=array(
                'msg' =>$message, 
                'status' => $status
             );
            mysqli_close($con);
            $jsonStrig = json_encode($json[0]);
            echo $jsonStrig; 
        }
        
        private function getConfigAgency($id_agency, $con){
           $query = "SELECT * FROM agency_payment WHERE id_agency = $id_agency;";
           $result = mysqli_query($con,$query);
           $obj= "";
           if ($result) {
               $ins_sql = mysqli_fetch_object($result);
               $obj = array('cash' => $ins_sql->cash, 'card' => $ins_sql->card, 'paypal' => $ins_sql->paypal, 'todaysale' => $ins_sql->todaysale, 'operadora' => $ins_sql->operadora, 'internal_yt' => $ins_sql->internal_yt);
               $con = null;
               return json_encode($obj);
           }
        }
    }
?>