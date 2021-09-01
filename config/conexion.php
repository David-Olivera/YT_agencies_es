<?php
    $servername = "localhost";
    $database = "yamevi_bd";
    $username = "root";
    $password = "";
    // Create connection
    $con = mysqli_connect($servername, $username, $password, $database);
    // Check connection
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($con, 'utf8');
    // <!-- 
    //     $servername = "yamevitravelcom.ipagemysql.com";
    //     $database = "yame_travel_bd";
    //     $username = "";
    //     $password = "YamTrav$$2021";
    
    // $count = date("i"); // Minutos dentro de una hora
    //     switch (true) {
    //         case $count <= 15: // primeros 16 minutos
    //             $username = 'yame_travel_bd_x'; // primer usuario
    //             break;
    
    //         case $count <= 30:
    //             $username = 'yame_travel_bd_y'; // segundo usuario
    //             break;
    
    //         case $count <= 45:
    //             $username = 'yame_travel_bd_z'; // tercer usuario
    //             break;
    
    //         default:
    //             $username = 'yame_admin_trav'; // usuario por defecto
    //             break;
    //     }
        
    //     // Create connection
    //     $con = mysqli_connect($servername, $username, $password, $database);
    
    // /* verificar la conexión */
    // if (mysqli_connect_errno()) {
    //     printf("Falló la conexión: %s\n", mysqli_connect_error());
    //     exit();
    // }
    
    
    // /* cambiar el conjunto de caracteres a utf8 */
    // if (!mysqli_set_charset($con, "utf8")) {
    //     printf("Error cargando el conjunto de caracteres utf8: %s\n", mysqli_error($con));
    //     exit();
    // }
    //  -->
?>