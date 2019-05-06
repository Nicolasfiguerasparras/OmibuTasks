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
		
		<link rel="stylesheet" type="text/css" href="css/main.css"> 
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
                include('connectDB.php');
                $db = connectDb();
                //$id = collectID($db, 'trabajadores');
            ?>
		<!-- /Establish connection with DB -->

		<!-- Restrictions -->
			<?php
                if(!isset($_SESSION['login_ok'])){
					header("location: notAllowed.php");
				}
				
				if(isset($_GET['client']) && $_GET['client'] == ""){
					header("location: index.php");
				}

				date_default_timezone_set('Europe/Madrid');
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
							<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Action
							</button>
							<div class="dropdown-menu">
								<a class="dropdown-item" href="#">Action</a>
								<a class="dropdown-item" href="#">Another action</a>
								<a class="dropdown-item" href="#">Something else here</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="#">Separated link</a>
							</div>
						</div>
					<!-- /Add client button -->

					<!-- Welcome message -->
						<div class="col-9 welcomeMessage">
							<?php
								if(isset($_GET['client'])){
									$welcomeMessage = $workerData['Nombre']." ".$workerData['Apellidos'];
								}else{
									$welcomeMessage = "Bienvenido, ".$workerData['Nombre']." ".$workerData['Apellidos'];
								}

								echo "<h1>".$welcomeMessage."</h1>";
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
									$clientsQuery = mysqli_query($db, "SELECT * FROM clientes");

									if($row = mysqli_fetch_array($clientsQuery)){ 
										do{
											if(isset($_GET['client'])){
												if($_GET['client'] == $row['ID_cliente']){
													echo "<a class='nav-link active' href='index.php?client='$row[ID_cliente]'>".$row['Nombre']."</a>";
												}else{
													echo "<a class='nav-link' href='index.php?client=$row[ID_cliente]'>".$row['Nombre']."</a>";
												}
											}else{
												echo "<a class='nav-link' href='index.php?client=$row[ID_cliente]'>".$row['Nombre']."</a>";
											}
											
										}while($row = mysqli_fetch_array($clientsQuery));
									}
								?>
								<a class="nav-link" href="login/logout.php">Logout</a>
							</div>
						<!-- /Lateral NavBar client list from DB -->

					</div>

					<!-- Main content -->
					<div class="col-9">
						<?php
							// Fill main DIV if isset clientID on URL
							if(isset($_GET['client'])){
								// Get clientID of actual section
								$actualID = $_GET['client'];
						?>
								<div class="tab-content" id="v-pills-tabContent">
									<div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
										<nav>
											<div class="nav nav-tabs" id="nav-tab" role="tablist">
												<a class="nav-item nav-link active" id="genericView" data-toggle="tab" href="#nav-first" role="tab" aria-controls="genericView" aria-selected="true">Vista general</a>
												<a class="nav-item nav-link" id="highPriority" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="false">Prioridad alta</a>
												<a class="nav-item nav-link" id="mediumPriority" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Prioridad media</a>
												<a class="nav-item nav-link" id="lowPriority" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Prioridad baja</a>
												<a class="nav-item nav-link" id="options" data-toggle="tab" href="#nav-contact2" role="tab" aria-controls="nav-contact2" aria-selected="false">Opciones</a>
											</div>
										</nav>

										<?php
											$taskQuery = mysqli_query($db, "SELECT * FROM tareas WHERE trabajador = $_SESSION[ID] and Cliente = $_GET[client]");
											
											$lowPriority = $mediumPriority = $highPriority = Array();

											if($row = mysqli_fetch_array($taskQuery)){ 
												do{
													if($row['Prioridad'] == 1){
														$highPriority[] = $row;
													}elseif($row['Prioridad'] == 2){
														$mediumPriority[] = $row;
													}elseif($row['Prioridad'] == 3){
														$lowPriority[] = $row;
													}
												}while($row = mysqli_fetch_array($taskQuery));
											}
										?>
										<div class="tab-content" id="nav-tabContent">

											<!-- Generic view -->
												<div class="tab-pane fade show active" id="nav-first" role="tabpanel" aria-labelledby="genericView">

													<table class="table col-11">

														<thead>
															<tr class="table-primary">
																<th scope="col">Prioridad</th>
																<th scope="col">Título</th>
																<th scope="col">Descripción</th>
																<th scope="col">Fecha límite</th>
															</tr>
														</thead>
														
														<tbody>

															<!-- High priority tasks -->
																<?php
																	for($i=0; $i<sizeof($highPriority); $i++){
																		$auxArray = $highPriority[$i];
																		echo "<tr class='table-danger'>";
																			echo "<td>Alta</td>";
																			echo "<td>".$auxArray['Nombre']."</td>";
																			echo "<td>".$auxArray['Descripcion']."</td>";
																			$date = date("F j, Y,", strtotime("$auxArray[Fecha]"));
																			echo "<td>".$date."</td>";
																		echo "</tr>";
																	}
																?>
															<!-- /High priority tasks -->

															<!-- Medium priority tasks -->
																<?php
																	for($i=0; $i<sizeof($mediumPriority); $i++){
																		$auxArray = $mediumPriority[$i];
																		echo "<tr class='table-warning'>";
																			echo "<td>Media</td>";
																			echo "<td>".$auxArray['Nombre']."</td>";
																			echo "<td>".$auxArray['Descripcion']."</td>";
																			$date = date("F j, Y,", strtotime("$auxArray[Fecha]"));
																			echo "<td>".$date."</td>";
																		echo "</tr>";
																	}
																?>
															<!-- /Medium priority tasks -->

															<!-- Low priority tasks -->
																<?php
																	for($i=0; $i<sizeof($lowPriority); $i++){
																		$auxArray = $lowPriority[$i];
																		echo "<tr class='table-info'>";
																			echo "<td>Baja</td>";
																			echo "<td>".$auxArray['Nombre']."</td>";
																			echo "<td>".$auxArray['Descripcion']."</td>";
																			$date = date("F j, Y,", strtotime("$auxArray[Fecha]"));
																			echo "<td>".$date."</td>";
																		echo "</tr>";
																	}
																	
																?>
															<!-- /Low priority tasks -->

														</tbody>

														<tfoot>
															<tr class="table-info">
																<td colspan="5"><a href="tasks/addTask.php?client=<?php echo $actualID ?>"><button type="button" class="btn btn-secondary" style="width: 100%">Añadir tarea</button></a></td>
															</tr>
														</tfoot>
													</table>
												</div>
											<!-- /Generic view -->
											
											<!-- High priority -->
												<div class="tab-pane fade" id="nav-home" role="tabpanel" aria-labelledby="highPriority">
													<ul>
														<?php
															for($i=0; $i<sizeof($highPriority); $i++){
																$auxArray = $highPriority[$i];
																echo "<li>".$auxArray['Nombre']." ".$auxArray['Descripcion']."</li>";
															}
														?>
													</ul>
												</div>
											<!-- /High priority -->

											<!-- Medium priority -->
												<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="mediumPriority">
													<ul>
														<?php
															for($i=0; $i<sizeof($mediumPriority); $i++){
																$auxArray = $mediumPriority[$i];
																echo "<li>".$auxArray['Nombre']." ".$auxArray['Descripcion']."</li>";
															}
														?>
													</ul>
												</div>
											<!-- /Medium priority -->

											<!-- Low priority -->
												<div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="lowPriority">
													<ul>
														<?php
															for($i=0; $i<sizeof($lowPriority); $i++){
																$auxArray = $lowPriority[$i];
																echo "<li>".$auxArray['Nombre']." ".$auxArray['Descripcion']."</li>";
															}
														?>
													</ul>
												</div>
											<!-- /Low priority -->

											<!-- Options -->
												<div class="tab-pane fade" id="nav-contact2" role="tabpanel" aria-labelledby="options">
													<br>
													<button type="button" class="btn btn-outline-info"><a href="tasks/addTask.php?client=<?php echo $actualID ?>">Añadir tarea</a></button>
													<button type="button" class="btn btn-outline-info"><a href="">Ver ficha</a></button>
													<button type="button" class="btn btn-outline-info"><a href="">Editar tareas</a></button>
													<button type="button" class="btn btn-outline-info"><a href="">Ver calendario</a></button>
												</div>
											<!-- /Options -->

										</div>
									</div>
								</div>
						
						<?php
							}else{
								echo "
									<div class='tab-content' id='v-pills-tabContent'>
										<h5>Seleccione un cliente para comenzar</h5>
									</div>
								";
							}
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