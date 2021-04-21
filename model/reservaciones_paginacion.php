<?php

	// Connect database 

	require_once('../config/conexion.php');

	$limit = 12;
    $id = $_POST['value'];
	$date_en = "";
	$date_ex = "";
	$search = 0;
	if (isset($id)) {
        $id_agency =  $id;
    }
	if (isset($_POST['page_no'])) {
		$page_no = $_POST['page_no'];
	}else{
	    $page_no = 1;
	}
	$query ="";
	$offset = ($page_no-1) * $limit;
	if ($_POST['date_en'] && $_POST['date_ex']) {
		$date_en = $_POST['date_en'];
		$date_ex = $_POST['date_ex'];
		$search = 1;
		$query ="SELECT * FROM reservations AS R INNER JOIN clients AS C ON R.id_client = C.id_client
		INNER JOIN reservation_details AS D ON D.id_reservation = R.id_reservation WHERE (R.id_agency = $id_agency)  AND (R.date_register_reservation >= '$date_en' AND R.date_register_reservation <= '$date_ex') ORDER BY R.id_reservation DESC LIMIT $offset, $limit";	
	}else{
		$query = "SELECT * FROM reservations AS R INNER JOIN clients AS C ON R.id_client = C.id_client
		INNER JOIN reservation_details AS D ON D.id_reservation = R.id_reservation WHERE R.id_agency = $id_agency ORDER BY R.id_reservation DESC LIMIT $offset, $limit";
		
	}
	$result = mysqli_query($con, $query);
	$output = "";
	$newrole ='';
	$newoutput = '';
	$today = date('Y-m-d');
    

	if ($result) {	
		if (mysqli_num_rows($result) > 0) {
			if ($search == 1) {
				$output.="
				<div class='w-100 pb-2'>
					<div class='row'>
						<div class='col-lg-8'>
							<p class='mb-0'>Resultados de reservaciones entre las fechas del <strong>$date_en</strong> al <strong>$date_ex</strong></p>
						</div>
						<div class='col-lg-4 text-right'>
							<a href='#' class='btn btn-sm btn-yamevi' data-animation='fadeInLeft' id='view_all_reservations' data-delay='.8s'>Todas las reservaciones</a><br>
						</div>
					</div>
				</div>
				";
			}
			$output.="<table class='table table-hover table-striped table-bordered table-sm' cellspacing='0' id='tableReservaciones'>
						<thead class='m-3'>
							<tr >
								<th>ID</th>
								<th>Cliente</th>
								<th>Traslado</th>
								<th>Servicio</th>
								<th>Pasajeros</th>
								<th>Total</th>
								<th>Metodo de Pago</th>
								<th>Estado</th>
								<th>Fecha de Reserva</th>
								<th></th>
								<th></th>
								<th></th>
								</tr>
						</thead>
						<tbody>";
			while ($row = mysqli_fetch_assoc($result)) {
					$newidreserva = MD5($row['id_reservation']);
					//QUITAR 
					$seccion_edit ="
					<a href='reservation_details.php?reservation={$newidreserva}&coinv={$row['code_invoice']}&reedit=1&typeser={$row['type_transfer']}' target='_blank'  id='amenity-edit' title='Editar Reservación' class='amenity-edit btn btn-yamevi_2 btn-sm' ><i class='fas fa-edit' ></i></a>
					";
					$seccion_status = "";
					if ($row['status_reservation'] != 'CANCELLED') {
						$seccion_status = '<select class="agencyCancelSale" data-sale="'.$row['id_reservation'].'">
								<option value="'.strtoupper($row['status_reservation']).'">'.strtoupper($row['status_reservation']).'</option>
								<option value="CANCELLED">CANCELLED</option>
						</select>';
					}else{
						$seccion_status = $row['status_reservation'];
					}
					if ($row['type_transfer'] == 'SEN/HA' && $today < $row['date_exit']) {
						$date_today = date_create($today);
						$date_exit = date_create($row['date_exit']);
						$date_differences = date_diff($date_today, $date_exit);
						if ($date_differences->days >= 2) {
							$seccion_edit ="
							<a href='reservation_details.php?reservation={$newidreserva}&coinv={$row['code_invoice']}&reedit=1&typeser={$row['type_transfer']}' target='_blank' id='amenity-edit' title='Editar Reservación' class='amenity-edit btn btn-yamevi_2 btn-sm' ><i class='fas fa-edit' ></i></a>
							";
						}
					}
					if ($today < $row['date_arrival']) {
						$date_today = date_create($today);
						$date_arrival = date_create($row['date_arrival']);
						$date_differences_arrival = date_diff($date_today, $date_arrival);
						if ($date_differences_arrival->days >= 2) {
							$seccion_edit ="
							<a href='reservation_details.php?reservation={$newidreserva}&coinv={$row['code_invoice']}&reedit=1&typeser={$row['type_transfer']}' target='_blank' id='amenity-edit' title='Editar Reservación' class='amenity-edit btn btn-yamevi_2 btn-sm' ><i class='fas fa-edit' ></i></a>
							";
						}
						
					}

					$new_id_reservation = md5($row['id_reservation']);

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
					$output.="<tr res-id='{$row['id_reservation']}'>	
							<td>{$row['code_invoice']}</td>
							<td>{$row['name_client']} {$row['last_name']}</td>
							<td>{$transfer}</td>
							<td>{$row['type_service']}</td>
							<td>{$row['number_adults']}</td>
							<td>$ {$row['total_cost_commision']}</td>
							<td>{$methodpayment}</td>
							<td>{$seccion_status}</td>
							<td>{$row['date_register_reservation']}</td>
							<td class='text-center'>
								<a href='#' id='amenity-edit' title='Detalles de Reservación' class='amenity-edit btn btn-secondary btn-sm' ><i class='fas fa-eye'></i></a>
							</td>
							<td class='text-center'>
								{$seccion_edit}
							</td>
							<td class='text-center'>
								<a href='#'id='get_pdf_req' data-toggle='modal' data-target='#myModal'  title='Descargar Ticket' class='btn btn-danger btn-sm '><i class='fas fa-file-pdf'></i></a>
							</td>
					</tr>";
			
			} 
			$output.="</tbody>
				</table>";
			if ($search == 1) {
				$sql = "SELECT * FROM reservations AS R INNER JOIN clients AS C ON R.id_client = C.id_client
				INNER JOIN reservation_details AS D ON D.id_reservation = R.id_reservation WHERE (R.id_agency = $id_agency)  AND (R.date_register_reservation >= '$date_en' AND R.date_register_reservation <= '$date_ex') ORDER BY R.id_reservation desc";
			}else{
			$sql = "SELECT * FROM reservations AS R INNER JOIN clients AS C ON R.id_client = C.id_client
            INNER JOIN reservation_details AS D ON D.id_reservation = R.id_reservation WHERE R.id_agency = $id_agency ORDER BY R.id_reservation desc";
			}
			$records = mysqli_query($con, $sql);
			$totalRecords = mysqli_num_rows($records);
			$totalPage = ceil($totalRecords/$limit);
			$output.="<ul class='pagination' style='margin:20px 0'>";
			for ($i=1; $i <= $totalPage ; $i++) { 
			if ($i == $page_no) {
				$active = "active ";
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
			$output="";
			if ($search == 1) {
				$output.="
				<div class='w-100 h-100'>
					<p>No se encontro ninguna reservación en las fechas del <strong>$date_en</strong> al <strong>$date_ex</strong></p>
					<a href='#' class='btn btn-yamevi' data-animation='fadeInLeft' id='view_all_reservations' data-delay='.8s'>Ver todas las reservaciones</a><br>
				</div>";
			}else{
			$output.="
            <div class='w-100 h-100'>
                <p>No se encontro ninguna reservación registrada</p>
				<a href='transfers.php' class='btn btn-yamevi' data-animation='fadeInLeft' data-delay='.8s'>Reservar Ahora</a><br>
            </div>";
			}
			echo $output;
		}
	}else{
		$output="";
		if ($search == 1) {
			$output.="
            <div class='w-100 h-100'>
			<p>No se encontro ninguna reservación en las fechas del <strong>$date_en</strong> al <strong>$date_ex</strong></p>
				<a href='#' class='btn btn-yamevi' data-animation='fadeInLeft' id='view_all_reservations' data-delay='.8s'>Ver todas las reservaciones</a><br>
            </div>";
		}else{
			$output.="
			<div class='w-100 h-100'>
				<p>No se encontro ninguna reservación registrada</p>
				<a href='transfers.php' class='btn btn-yamevi' data-animation='fadeInLeft' data-delay='.8s'>Reservar Ahora</a><br>
			</div>";
		}
		echo $output;
	}

?>