<?php

	// Connect database 

	require_once('../config/conexion.php');

	$limit = 12;
    $id = $_POST['value'];
	$type = $_POST['type'];
	$code = "";
	$search = 0;
	if (isset($id)) {
        $id_agency =  $id;
    }
	if (isset($_POST['page_no'])) {
		$page_no = $_POST['page_no'];
	}else{
	    $page_no = 1;
	}
	$query = "";
	$offset = ($page_no-1) * $limit;
	if ($_POST['code']) {
		$code = mysqli_real_escape_string($con,$_POST['code']);
		$search = 1;
		$query = "SELECT * FROM conciliation AS C INNER JOIN reservations AS R ON C.id_reservation = R.id_reservation INNER JOIN clients AS CL ON R.id_client = CL.id_client
		INNER JOIN reservation_details AS RD ON C.id_reservation = RD.id_reservation WHERE R.id_agency = $id_agency AND C.`status` = $type AND R.code_invoice = '$code' ORDER BY C.id_reservation DESC LIMIT $offset, $limit";
	
	}else{
		$query = "SELECT * FROM conciliation AS C INNER JOIN reservations AS R ON C.id_reservation = R.id_reservation INNER JOIN clients AS CL ON R.id_client = CL.id_client
		INNER JOIN reservation_details AS RD ON C.id_reservation = RD.id_reservation WHERE R.id_agency = $id_agency AND C.`status` = $type ORDER BY C.id_reservation DESC LIMIT $offset, $limit";
	}
	
	$result = mysqli_query($con, $query);
	$output = "";
	$newrole ='';
	$newoutput = '';
    

	if ($result) {	
		if (mysqli_num_rows($result) > 0) {
			
			if ($search == 1 && $type == 0) {
				$output.="
				<div class='w-100 pb-2'>
					<div class='row'>
						<div class='col-lg-8'>
							<p class='mb-0'>Resultados encontrados con el ID <strong>$code</strong> </p>
						</div>
						<div class='col-lg-4 text-right'>
							<a href='#' class='btn btn-sm btn-yamevi' data-animation='fadeInLeft' id='view_all_reservations_noc' data-delay='.8s'><i class='fas fa-times'></i></a><br>
						</div>
					</div>
				</div>
				";
			}
			if ($search == 1 && $type == 1) {
				$output.="
				<div class='w-100 pb-2'>
					<div class='row'>
						<div class='col-lg-8'>
							<p class='mb-0'>Resultados encontrados con el ID <strong>$code</strong> </p>
						</div>
						<div class='col-lg-4 text-right'>
							<a href='#' class='btn btn-sm btn-yamevi' data-animation='fadeInLeft' id='view_all_reservations_con' data-delay='.8s'><i class='fas fa-times'></i></a><br>
						</div>
					</div>
				</div>
				";
			}
			$output.="
					
					
					<table class='table table-hover table-striped table-bordered table-sm' cellspacing='0' id='tablaConciliaciones'>
						<thead class='m-3'>
							<tr >
								<th class='column_mult table-yamevi'>CM</th>
								<th>ID</th>
								<th>Cliente</th>
								<th>Traslado</th>
								<th>Servicio</th>
								<th>Pasajeros</th>
								<th class='hidden-sm'>Tarifa</th>
								<th>Total</th>
								<th class='hidden-sm'>Metodo de Pago</th>
								<th class='hidden-sm'>Estado</th>
								<th>Fecha de Llegada</th>
								<th>Fecha de Salida</th>
								<th class='column_only'>Archivo</th>
								</tr>
						</thead>
						<tbody>";
			while ($row = mysqli_fetch_assoc($result)) {
					$methodpayment = "";
					$class_conciliation = 'btn-outline-yamevi_2';
					$id_conci =  $row['id_conciliation'] ;
					$query_docs = "SELECT * FROM reservations AS R inner join conciliation AS C ON R.id_reservation = C.id_reservation INNER JOIN conciliation_docs as CD on C.id_conciliation = CD.id_conciliation WHERE CD.id_conciliation = $id_conci and R.id_agency = $id_agency AND C.`status` = $type;";
					$result_c =  mysqli_query($con, $query_docs);
					if ($result_c) {
						$ins = mysqli_fetch_object($result_c);
						$id_c = "";
						if (isset($ins->id_conciliation)) {
							$id_c = $ins->id_conciliation;
							if ($row['id_conciliation'] == $id_c) {
								$class_conciliation = "btn-yamevi_2";
							}
						}
					}
					
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
					$date_arrival = $row['date_arrival'];
					$date_exit = $row['date_exit'];
					if($row['date_arrival'] == '' || $row['date_arrival'] == '0000-00-00' ){
						$date_arrival ="";
					}
					if ($row['date_exit'] == '' || $row['date_exit'] == '0000-00-00') {
						$date_exit = "";
					}
					$output.="
					<tr reserva-re='{$row['id_reservation']}' code-invoice={$row['code_invoice']} reserva-con={$row['id_conciliation']}>
							<td class='pl-2 pr-1 column_mult '>
								<div>
								<input type='checkbox' id='dia1' class='mult_conci' name='dia1' value='{$row['code_invoice']}'  reserva-re='{$row['id_reservation']}' reserva-con={$row['id_conciliation']} />
								<label class='text-white' for='dia1'></label>
								</div>
							</td>
							<td>{$row['code_invoice']}</td>
							<td>{$row['name_client']} {$row['last_name']} {$row['mother_lastname']}</td>
							<td>{$transfer}</td>
							<td>{$row['type_service']}</td>
							<td>{$row['number_adults']}</td>
							<td class='hidden-sm'>$ {$row['total_cost']} {$currency}</td>
							<td>$ {$row['total_cost_commision']} {$currency}</td>
							<td class='hidden-sm' >{$methodpayment}</td>
							<td class='hidden-sm' >{$row['status_reservation']}</td>
							<td>{$date_arrival}</td>
							<td>{$date_exit}</td>
							<td class='text-center column_only'>
								<a href='#' id='btn_upload_file' reserva='{$row['id_reservation']}'  conciliation='{$row['id_conciliation']}' code='{$row['code_invoice']}' type_conci='{$type}' class=' btn $class_conciliation btn-sm' data-toggle='modal' data-target='#upload_conliation'><i class='fas fa-file-upload'></i></a>
							</td>
							
					</tr>";
			
			} 
			$output.="</tbody>
				</table>";
			if ($search == 1) {
				$sql = "SELECT * FROM conciliation AS C INNER JOIN reservations AS R ON C.id_reservation = R.id_reservation INNER JOIN clients AS CL ON R.id_client = CL.id_client
				INNER JOIN reservation_details AS RD ON C.id_reservation = RD.id_reservation WHERE R.id_agency = $id_agency AND C.`status` = $type AND R.code_invoice = '$code' ORDER BY C.id_reservation desc";
			}else {
				$sql = "SELECT * FROM conciliation AS C INNER JOIN reservations AS R ON C.id_reservation = R.id_reservation INNER JOIN clients AS CL ON R.id_client = CL.id_client
				INNER JOIN reservation_details AS RD ON C.id_reservation = RD.id_reservation WHERE R.id_agency = $id_agency AND C.`status` = $type ORDER BY C.id_reservation desc";
			}
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