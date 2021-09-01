<?php

	// Connect database 

	require_once('../config/conexion.php');

	$limit = 12;
    $id = $_POST['value'];
	if (isset($id)) {
        $id_agency =  $id;
    }
	if (isset($_POST['page_no'])) {
		$page_no = $_POST['page_no'];
	}else{
	    $page_no = 1;
	}
	$offset = ($page_no-1) * $limit;
	$query = "SELECT * FROM users  WHERE id_agency = $id ORDER BY id_user DESC LIMIT $offset, $limit";
	$result = mysqli_query($con, $query);
	$output = "";
	$newrole ='';
	$newoutput = '';
    

	if ($result) {	
		if (mysqli_num_rows($result) > 0) {
			$output.="
			
					<a href='#' data-toggle='modal' data-target='#modal_add_user' class='btn btn-yamevi_2 btn-sm mb-3' data-animation='fadeInLeft' data-delay='.8s'>Nuevo Usuario</a>
					<table class='table table-hover table-striped table-bordered table-sm' cellspacing='0' id='tablaUsuarios'>
						<thead class='m-3'>
							<tr >
								<th>Nombre</th>
								<th>Email</th>
								<th>Teléfono</th>
								<th>Username</th>
								<th></th>
								<th></th>
								</tr>
						</thead>
						<tbody>";
			while ($row = mysqli_fetch_assoc($result)) {
					
					$output.="
					
	  
					<tr user-us='{$row['id_user']}'>
							<td>{$row['first_name']} {$row['last_name']} </td>
							<td>{$row['email_user']}</td>
							<td>{$row['phone_user']}</td>
							<td>{$row['username']}</td>
							<td class='text-center '>
								<a href='#' class=' btn btn-yamevi_2 btn-sm' id='btn_edit_user' data-toggle='modal' data-target='#modal_add_user'><i class='fas fa-edit'></i></a>
							</td>
							<td class='text-center '>
								<a href='#' class=' btn btn-yamevi btn-sm' id='btn_delete_user' data-toggle='modal' data-target='#myModaldelete' user-name='{$row['first_name']} {$row['last_name']}' ><i class='fas fa-trash-alt'></i></a>
							</td>
							
					</tr>";
			
			} 
			$output.="</tbody>
				</table>";

			$sql = "SELECT * FROM users  WHERE id_agency = $id ORDER BY id_user desc";
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

			$con = null;
			echo $output;

		}else{
			$output.="
            <div class='w-100 h-100'>
                <p>No se encontro ningún usuario registrado</p>
				<a href='#' data-toggle='modal' data-target='#modal_add_user' class='btn btn-yamevi' data-animation='fadeInLeft' data-delay='.8s'>Agregar Usuario</a><br>
            </div>";
			$con = null;
			echo $output;
		}
	}else{
		$output.="
        <div class='w-100 h-100'>
            <p>No se encontro ningún usuario registrado</p>
			<a href='#' data-toggle='modal' data-target='#modal_add_user' class='btn btn-yamevi' data-animation='fadeInLeft' data-delay='.8s'>Agregar Usuario</a><br>
        </div>";
		$con = null;
		echo $output;
	}

?>