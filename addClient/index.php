<!--Extract session-->
    <?php
        session_start();
    ?>
<!--/Extract session-->

<!DOCTYPE HTML>
<html lang="es">
	<head>

	    <meta charset="UTF-8">
	    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">

		<!-- --------------------------------------------------------------------------------------------- -->
		<link rel="stylesheet" type="text/css" href="../css/main.css"> 
		<!-- --------------------------------------------------------------------------------------------- -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<!-- --------------------------------------------------------------------------------------------- -->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
		<!-- --------------------------------------------------------------------------------------------- -->
	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

		<title>Inicio</title>

	</head>
	<body>

		<!-- Establish connection with DB -->
			<?php
                include('../connectDB.php');
                $db = connectDb();
            ?>
		<!-- /Establish connection with DB -->

		<!-- Restrictions -->
			<?php
                if(!isset($_SESSION['email']) or $_SESSION == ""){
					header("location: ../login/");
				}
				
				date_default_timezone_set('Europe/Madrid');
			?>
		<!-- /Restrictions -->

		<!-- Extract client data -->
			<?php
				$workerData = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM worker WHERE email = '$_SESSION[email]'"));
			?>
		<!-- /Extract client data -->

		<div class="container-fluid">
			<div class="mainBox">
				<div class="row">

					<!-- Add client button -->
						<div class="col-3 addClientBox">
							
						</div>
					<!-- /Add client button -->

					<!-- Welcome message -->
						<div class="col-9 welcomeMessage">
							<?php
								echo "<h1>Crear cliente</h1>";
							?>
						</div>
					<!-- /Welcome message -->

				</div>

				<div class="row">
					<div class="col-3">

						<!-- Lateral NavBar client list from DB -->
							<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
								
								<a class="nav-link" href="myTasks/">Mis tareas</a>
								<?php
									$clientsQuery = mysqli_query($db, "SELECT * FROM client");

									if($row = mysqli_fetch_array($clientsQuery)){ 
										do{
											if(isset($_GET['client'])){
												if($_GET['client'] == $row['client_ID']){
													echo "<a class='nav-link active' href='../index.php?client='$row[client_ID]'>".$row['name']."</a>";
												}else{
													echo "<a class='nav-link' href='../index.php?client=$row[client_ID]'>".$row['name']."</a>";
												}
											}else{
												echo "<a class='nav-link' href='../index.php?client=$row[client_ID]'>".$row['name']."</a>";
											}

										}while($row = mysqli_fetch_array($clientsQuery));
									}
								?>
								<a class="nav-link" href="../login/logout.php">Logout</a>

							</div>
						<!-- /Lateral NavBar client list from DB -->

					</div>

					<!-- Main content -->
						<div class="col-9">
							<form>
								<div class="row">
									<div class="col-5" style="border: solid 3px black">
										<h2 style="text-align: center">Datos del cliente</h2>
										<div class="form-row">
											<div class="form-group col-md-4">
												<label for="name">Nombre</label>
												<input type="text" class="form-control" id="name" placeholder="Nombre">
											</div>
											<div class="form-group col-md-4">
												<label for="inputPassword4">Dirección postal</label>
												<input type="password" class="form-control" id="inputPassword4" placeholder="Dirección postal">
											</div>
											<div class="form-group col-md-4">
												<label for="inputPassword4">Teléfono</label>
												<input type="password" class="form-control" id="inputPassword4" placeholder="Teléfono">
											</div>
										</div>
										<div class="form-row">
											<div class="form-group col-md-4">
												<label for="name">Email</label>
												<input type="text" class="form-control" id="name" placeholder="Email">
											</div>
											<div class="form-group col-md-4">
												<label for="inputPassword4">Datos fiscales</label>
												<input type="password" class="form-control" id="inputPassword4" placeholder="Datos fiscales">
											</div>
											<div class="form-group col-md-4">
												<label for="inputPassword4">Web</label>
												<input type="password" class="form-control" id="inputPassword4" placeholder="Web">
											</div>
										</div>
									</div>

									<div class="col-5 offset-1" style="border: solid 3px black">
										<h2 style="text-align: center">Datos del mercado</h2>
										<div class="form-row">
											<div class="form-group col-md-6">
												<label for="name">Tendencia del mercado</label>
												<input type="text" class="form-control" id="name" placeholder="Tendencia del mercado">
											</div>
											<div class="form-group col-md-6">
												<label for="inputPassword4">Tamaño del mercado</label>
												<input type="password" class="form-control" id="inputPassword4" placeholder="Tamaño del mercado">
											</div>
										</div>
										<div class="form-row">
											<div class="form-group col-md-6">
												<label for="name">Competencia</label>
												<input type="text" class="form-control" id="name" placeholder="Competencia">
											</div>
											<div class="form-group col-md-6">
												<label for="inputPassword4">Debilidades</label>
												<input type="password" class="form-control" id="inputPassword4" placeholder="Debilidades">
											</div>
										</div>
									</div>

									<div class="col-5" style="border: solid 3px black; margin-top:20px">
										<h2 style="text-align: center">Datos del negocio</h2>
										<div class="form-row">
											<div class="form-group col-md-6">
												<label for="name">Nombre</label>
												<input type="text" class="form-control" id="name" placeholder="Nombre">
											</div>
											<div class="form-group col-md-6">
												<label for="inputPassword4">Teléfono</label>
												<input type="password" class="form-control" id="inputPassword4" placeholder="Teléfono">
											</div>
										</div>
										<div class="form-row">
											<div class="form-group col-md-6">
												<label for="inputPassword4">Descripción</label>
												<input type="password" class="form-control" id="inputPassword4" placeholder="Descripción">
											</div>
											<div class="form-group col-md-6">
												<label for="inputPassword4">Objetivos generales</label>
												<input type="password" class="form-control" id="inputPassword4" placeholder="Objetivos generales">
											</div>
										</div>
										<div class="form-row">
											<div class="form-group col-md-6">
												<label for="inputPassword4">Color corporativo</label>
												<input type="password" class="form-control" id="inputPassword4" placeholder="Color corporativo">
											</div>
											<div class="form-group col-md-6">
												<label for="inputPassword4">Slogan</label>
												<input type="password" class="form-control" id="inputPassword4" placeholder="Slogan">
											</div>
										</div>
										<div class="form-row">
											<div class="form-group col-md-6">
												<label for="inputPassword4">Hastag</label>
												<input type="password" class="form-control" id="inputPassword4" placeholder="Hastag">
											</div>
											<div class="form-group col-md-6">
												<label for="inputPassword4">Tipografía</label>
												<input type="password" class="form-control" id="inputPassword4" placeholder="Tipografía">
											</div>
										</div>
										<div class="form-row">
											<div class="form-group col-md-6">
												<label for="inputPassword4">Tono de comunicación</label>
												<input type="password" class="form-control" id="inputPassword4" placeholder="Tono de comunicación">
											</div>
											<div class="form-group col-md-6">
												<label for="inputPassword4">Fecha de creación</label>
												<input type="date" class="form-control" id="inputPassword4" placeholder="Fecha de creación">
											</div>
										</div>
										<div class="form-row">
											<div class="form-group col-md-12">
												<label for="inputPassword4">Valores</label>
												<input type="password" class="form-control" id="inputPassword4" placeholder="Valores">
											</div>
										</div>
									</div>
									
								</div>
								<br>
								<input type="submit" class="btn btn-primary" value="Crear">
							</form>
						</div>
					<!-- Main content -->

				</div>
			</div>
		</div>

		<!-- Bootstrap JS -->
			<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
			<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<!-- /Bootstrap JS -->

	</body>
</html>