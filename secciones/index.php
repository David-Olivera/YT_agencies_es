    <?php  
    session_start();  

    if (isset($_SESSION['yt_id_agency'])) {
        header('location: home.php');
    }else{
    }
    
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="../assets/img/icon/yamevIcon.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YameviTravel - Inicio de sesión</title>
	<!-- GOOGLE FONTS -->
    <link rel="stylesheet" href="../assets/css/style2.css">
	<!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
	<!-- BOOTSTRAP -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   <div id="loading">
    <div class="loader">
    </div> 
   </div>
</head>
<body>	
	<div class="sidenav_agencies">
        <div class="login-main-text">
            <h4>YameviTravel</h4>
            <h1>Agencias Afiliadas</h1>
            <small>Al ser miembro de nuestro programa tienes acceso al sistema y al amplio catalogo de servicios para optimizar y aumentar tus ventas.</small>
        </div>
    </div>
    <div class="main">
        <div class="col-md-6 col-sm-12">
            <div class="login-form">
              <form method="POST" name="login" id="login">
                 <div class="form-group title-login-agen">
                    <h2>Iniciar Sesión</h2>
                 </div>
                 <div class="form-group">
                    <label>Email / Usuario</label>
                    <input type="text" class="form-control" name="email" id="email" value=""  placeholder="Email" >
                 </div>
                 <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password"  id="password" value="" placeholder="Password" >
                 </div>
                 <div class="form-group">
                   <a href="#"><i>Olvidaste tu contraseña?</i></a>
                 </div>
                 <div class="form-group">
                  <div class="row">
                       <div class="col-lg-6">
			  	        	      <button type="submit" id="btn_login" class="btn btn-login-agencies btn-block">Ingresar</button>
                           <div class=" btn_load btn_load_black btn-block mt-0">
                                <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                           </div>
                       </div>
                        <div class="col-lg-6">
                           <a href="../../index.php" class="btn btn-block btn-outline-primary">Regresar</a>
                           
                        </div>
                    </div>
                 </div>
                 <div class="form-group" id="error_msg">
                 </div>
				<!--<div class="d-flex">
					<a href="#">Forgot your password?</a>
				</div>-->
              </form>
            </div>
        </div>
    </div>
</body>    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    
    <script src="../assets/css/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="../assets/js/login.js"></script>
</html>