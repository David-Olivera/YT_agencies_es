<?php

	// Connect database 

	require_once('../config/conexion.php');

	$limit = 12;
    $id = $_POST['value'];
	$type = $_POST['type'];
	if (isset($id)) {
        $id_agency =  $id;
    }
	if (isset($_POST['page_no'])) {
		$page_no = $_POST['page_no'];
	}else{
	    $page_no = 1;
	}
	$offset = ($page_no-1) * $limit;
	$query = "SELECT * FROM conciliation AS C INNER JOIN reservations AS R ON C.id_reservation = R.id_reservation INNER JOIN clients AS CL ON R.id_client = CL.id_client
	INNER JOIN reservation_details AS RD ON C.id_reservation = RD.id_reservation WHERE R.id_agency = $id_agency AND C.`status` = $type ORDER BY C.id_reservation DESC LIMIT $offset, $limit";
	$result = mysqli_query($con, $query);
	$output = "";
	$newrole ='';
	$newoutput = '';
    

	if ($result) {	
		if (mysqli_num_rows($result) > 0) {
			$output.="
					
					
					<table class='table table-hover table-striped table-bordered table-sm' cellspacing='0' id='tablaAmenidades'>
						<thead class='m-3'>
							<tr >
								<th class='column_mult'>CM</th>
								<th>ID</th>
								<th>ID</th>
								<th>Cliente</th>
								<th>Traslado</th>
								<th>Servicio</th>
								<th>Pasajeros</th>
								<th>Tarifa</th>
								<th>Total</th>
								<th>Metodo de Pago</th>
								<th>Estado</th>
								<th class='column_only'></th>
								</tr>
						</thead>
						<tbody>";
			while ($row = mysqli_fetch_assoc($result)) {
					$methodpayment = "";
                    //Transfer
                    switch ($row['type_transfer']) {
                        case 'RED':
                            $transfer = 'Redondo';
                            break;
                        case 'SEN/AH':
                            $transfer = 'Sencillo, Aeropuerto a Hotel';
                            break;
                        case 'SEN/HA';
                            $transfer = 'Sencillo, Hotel a Aeropuerto';
                            break;
                        case 'REDHH':
                            $transfer = 'Redondo, Hotel a Hotel';
                            break;
                        case 'SEN/HH':
                            $transfer = 'Sencillo, Hotel a Hotel';
                            break;
                    }
                    switch ($row['method_payment']) {
                        case 'card':
                            $methodpayment = 'Tarjeta';
                            break;
                        case 'transfer':
                            $methodpayment = 'Transferencia';
                            break;
                        case 'paypal';
                            $methodpayment = 'Paypal';
                            break;
                        case 'airport':
                            $methodpayment = 'Pago al Abordar';
                            break;
                    }
					switch ($row['type_currency']) {
						case 'mx':
							$currency ="MXN";
							break;
						
						case 'us':
							$currency ="USD";
							break;
					}
					$output.="
					
	  
					<tr reserva-re='{$row['id_reservation']}'>
							<td class='pl-2 pr-1 column_mult'>
								<div>
								<input type='checkbox' id='dia1' class='mult_conci' name='dia1' value='{$row['id_reservation']}' />
								<label for='dia1'>-</label>
								</div>
							</td>
							<td>{$row['id_reservation']}</td>
							<td>{$row['code_invoice']}</td>
							<td>{$row['name_client']} {$row['last_name']}</td>
							<td>{$transfer}</td>
							<td>{$row['type_service']}</td>
							<td>{$row['number_adults']}</td>
							<td>$ {$row['total_cost']} {$currency}</td>
							<td>$ {$row['total_cost_commision']} {$currency}</td>
							<td>{$methodpayment}</td>
							<td>{$row['status_reservation']}</td>
							<td class='text-center column_only'>
								<a href='#' id='amenity-edit' class='amenity-edit btn btn-yamevi_2 btn-sm' ><i class='fas fa-file-upload'></i></a>
							</td>
							
					</tr>";
			
			} 
			$output.="</tbody>
				</table>";

			$sql = "SELECT * FROM conciliation AS C INNER JOIN reservations AS R ON C.id_reservation = R.id_reservation INNER JOIN clients AS CL ON R.id_client = CL.id_client
			INNER JOIN reservation_details AS RD ON C.id_reservation = RD.id_reservation WHERE R.id_agency = $id_agency AND C.`status` = $type ORDER BY C.id_reservation desc";
			$records = mysqli_query($con, $sql);
			$totalRecords = mysqli_num_rows($records);
			$totalPage = ceil($totalRecords/$limit);
			$output.="<ul class='pagination' style='margin:20px 0'>";
			for ($i=1; $i <= $totalPage ; $i++) { 
			if ($i == $page_no) {
				$active = "active";
				$btn = "btn-yamevi_2";
			}else{
				$active = "";
				$btn = "";
			}
				$output.="<li class='page-item $active'><a class='page-link $btn' id='$i' href=''>$i</a></li>";
			}
			$output .= "</ul>";

			echo $output;

		}else{
			$output.="
            <div class='w-100 h-100'>
                <p>No se encontro ninguna conciliación realizada</p>
				<a href='transfers.php' class='btn btn-yamevi' data-animation='fadeInLeft' data-delay='.8s'>Reservar Ahora</a><br>
            </div>";
			echo $output;
		}
	}else{
		$output.="
        <div class='w-100 h-100'>
            <p>No se encontro ninguna conciliación realizada</p>
			<a href='transfers.php' class='btn btn-yamevi' data-animation='fadeInLeft' data-delay='.8s'>Reservar Ahora</a><br>
        </div>";
		echo $output;
	}

?>