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
		
		<link rel="stylesheet" type="text/css" href="../css/main.css"> 
		<!-- --------------------------------------------------------------------------------------------- -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<!-- --------------------------------------------------------------------------------------------- -->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
		<!-- --------------------------------------------------------------------------------------------- -->
	    <title>Inicio</title>
	</head>
	<body>
		
		<!-- Establish connection with DB -->
			<?php
                include('../connectDB.php');
                $db = connectDb();
                //$id = collectID($db, 'trabajadores');
            ?>
		<!-- /Establish connection with DB -->

		<!-- Restrictions -->
			<?php
                if(!isset($_SESSION['login_ok'])){
					header("location: ../notAllowed.php");
				}
			?>
		<!-- /Restrictions -->
		
		<!-- Extract client data -->
			<?php
				$workerData = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM trabajadores WHERE Email = '$_SESSION[email]'"));
			?>
		<!-- /Extract client data -->
	
		<div class="container-fluid">
			<div class="mainBox">
				<div class="row">

					<!-- Add client button -->
						<div class="col-3 addClientBox">
							<a href="#"><i class="fas fa-plus-circle addClientBtn"></i></a>
						</div>
					<!-- /Add client button -->

					<!-- Welcome message -->
						<div class="col-9 welcomeMessage">
							<h1><?php echo $workerData['Nombre']." ".$workerData['Apellidos']; ?></h1>
						</div>
					<!-- /Welcome message -->

				</div>

				<div class="row">
					<div class="col-3">

						<!-- Lateral NavBar client list from DB -->
							<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
								<a class="nav-link active" href="myTasks.php">Mis tareas</a>
								<?php
									$clientsQuery = mysqli_query($db, "SELECT * FROM clientes");

									if($row = mysqli_fetch_array($clientsQuery)){ 
										do{
											if(isset($_GET['client'])){
												if($_GET['client'] == $row['ID_cliente']){
													echo "<a class='nav-link' href='../index.php?client='$row[ID_cliente]'>".$row['Nombre']."</a>";
												}else{
													echo "<a class='nav-link' href='../index.php?client=$row[ID_cliente]'>".$row['Nombre']."</a>";
												}
											}else{
												echo "<a class='nav-link' href='../index.php?client=$row[ID_cliente]'>".$row['Nombre']."</a>";
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
						<?php
						
							/* 
								Crear un array bidimensional: sacamos todas las tareas ordenadas por id de cliente de manera descentente,
								sacamos el primer id de cliente que haya (será el id de cliente más alto) y se crea un array con ese 
								número de posiciones. Cada posición irá rellena con todas las tareas que haya para ese cliente
							*/
						
						?>
					</div>
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