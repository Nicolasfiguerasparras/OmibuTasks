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
		<link rel="stylesheet" type="text/css" href="css/main.css"> 
		<!-- --------------------------------------------------------------------------------------------- -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<!-- --------------------------------------------------------------------------------------------- -->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
		<!-- --------------------------------------------------------------------------------------------- -->
	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

		<!-- Full calendar -->
			<link href='fullcalendar/packages/core/main.css' rel='stylesheet' />
			<link href='fullcalendar/packages/daygrid/main.css' rel='stylesheet' />
			<script src='fullcalendar/packages/core/main.js'></script>
			<script src='fullcalendar/packages/interaction/main.js'></script>
			<script src='fullcalendar/packages/daygrid/main.js'></script>
			<script src='fullcalendar/packages/core/locales-all.js'></script>
		<!-- /Full calendar -->


		<title>Inicio</title>

	</head>
	<body>

		<!-- Establish connection with DB -->
			<?php
                include('connectDB.php');
                $db = connectDb();
            ?>
		<!-- /Establish connection with DB -->

		<!-- Restrictions -->
			<?php
                if(!isset($_SESSION['email']) or $_SESSION == ""){
					header("location: login/");
				}
				
				if(isset($_GET['client']) && $_GET['client'] == ""){
					header("location: index.php");
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
			<div class="col-10 offset-1 mainBox">
				<div class="row">

					<!-- Add client button -->
						<div class="col-3 addClientBox">
							<a href="addClient/"><i class="fas fa-plus-circle addClientBtn"></i></a>
						</div>
					<!-- /Add client button -->

					<!-- Welcome message -->
						<div class="col-9 welcomeMessage">
							<?php
								if(isset($_GET['client'])){
									$welcomeMessage = $workerData['name']." ".$workerData['surname'];
								}else{
									$welcomeMessage = "Bienvenido, ".$workerData['name']." ".$workerData['surname'];
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
									$clientsQuery = mysqli_query($db, "SELECT * FROM client");

									if($row = mysqli_fetch_array($clientsQuery)){ 
										do{
											if(isset($_GET['client'])){
												if($_GET['client'] == $row['client_ID']){
													echo "<a class='nav-link active' href='index.php?client='$row[client_ID]'>".$row['name']."</a>";
												}else{
													echo "<a class='nav-link' href='index.php?client=$row[client_ID]'>".$row['name']."</a>";
												}
											}else{
												echo "<a class='nav-link' href='index.php?client=$row[client_ID]'>".$row['name']."</a>";
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
													<a class="nav-item nav-link active" id="highPriority" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Calendario</a>
													<a class="nav-item nav-link" id="genericView" data-toggle="tab" href="#nav-first" role="tab" aria-controls="genericView" aria-selected="false">Vista general</a>
													<a class="nav-item nav-link" id="mediumPriority" data-toggle="tab" href="#nav-contact2" role="tab" aria-controls="nav-contact2" aria-selected="false">Tareas destacadas</a>
												</div>
											</nav>

											<?php
												$taskQuery = mysqli_query($db, "SELECT * FROM task WHERE worker_ID = $_SESSION[ID] and client_ID = $actualID");
												
												$standarPriority = $highPriority = Array();

												if($row = mysqli_fetch_array($taskQuery)){ 
													do{
														if($row['priority'] == 1){
															$highPriority[] = $row;
														}elseif($row['priority'] == 0){
															$standarPriority[] = $row;
														}
													}while($row = mysqli_fetch_array($taskQuery));
												}
											?>

											<div class="tab-content" id="nav-tabContent">

												<!-- Generic view -->
													<div class="tab-pane fade" id="nav-first" role="tabpanel" aria-labelledby="genericView">

														<table class="table col-11 table-responsive-md">

															<thead>
																<tr class="table-primary">
																	<th scope="col"></th>
																	<th scope="col">Responsable</th>
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
																				
																				if($auxArray['Finalizado'] == '0'){
																					echo "<td><i class='fa fa-close'></i></td>";
																				}else{
																					echo "<td><i class='fa fa-check'></i></td>";
																				}
																				
																				$associatedWorker = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM worker WHERE worker_ID = $auxArray[worker_ID]"));
																				echo "<td>".$associatedWorker['name']." ".$associatedWorker['surname']."</td>";
																				echo "<td>".$auxArray['name']."</td>";
																				echo "<td>".$auxArray['description']."</td>";
																				$date = date("F j, Y", strtotime("$auxArray[limit_date]"));
																				echo "<td>".$date."</td>";
																				echo "<td style='text-align: center'><a href='Tasks/modifyTask.php?task=$auxArray[task_ID]&client=$actualID'><i class='fa fa-edit' style='font-size:20px;color:green'></i></a></td>";
																			echo "</tr>";
																		}
																	?>
																<!-- /High priority tasks -->

																<!-- Standard priority tasks -->
																	<?php
																		for($i=0; $i<sizeof($standarPriority); $i++){
																			$auxArray = $standarPriority[$i];
																			echo "<tr class='table-warning'>";
																				if($auxArray['done'] == 0){
																					echo "<td><i class='fa fa-close'></td>";
																				}else{
																					echo "<td><i class='fa fa-check'></td>";
																				}
																				
																				$associatedWorker = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM worker WHERE worker_ID = $auxArray[worker_ID]"));
																				echo "<td>".$associatedWorker['name']." ".$associatedWorker['surname']."</td>";
																				echo "<td>".$auxArray['name']."</td>";
																				echo "<td>".$auxArray['description']."</td>";
																				$date = date("F j, Y", strtotime("$auxArray[limit_date]"));
																				echo "<td>".$date."</td>";
																				echo "<td style='text-align: center'><a href='Tasks/modifyTask.php?task=$auxArray[task_ID]&client=$actualID'><i class='fa fa-edit' style='font-size:20px;color:green'></i></a></td>";
																			echo "</tr>";
																		}
																	?>
																<!-- /Standard priority tasks -->

															</tbody>

															<tfoot>
																<tr class="table">
																	<td colspan="6"><a href="tasks/addTask.php?client=<?php echo $actualID ?>"><button type="button" class="btn btn-secondary" style="width: 100%">Añadir tarea</button></a></td>
																</tr>
															</tfoot>

														</table>

													</div>
												<!-- /Generic view -->
												
												<!-- Calendar -->
													<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="highPriority">
														<div id='calendar' class="col-12"></div>
													</div>
												<!-- /Calendar -->

												<!-- Highlighted -->
													<div class="tab-pane fade" id="nav-contact2" role="tabpanel" aria-labelledby="options">
														<table class="table col-11">

															<thead>
																<tr class="table-primary">
																	<th scope="col">Responsable</th>
																	<th scope="col">Título</th>
																	<th scope="col">Descripción</th>
																	<th scope="col">Fecha límite</th>
																</tr>
															</thead>

															<tbody>
																<?php
																	for($i=0; $i<sizeof($highPriority); $i++){
																		$auxArray = $highPriority[$i];
																		echo "<tr class='table-danger'>";
																			$associatedWorker = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM worker WHERE worker_ID = $auxArray[worker_ID]"));
																			echo "<td>".$associatedWorker['name']." ".$associatedWorker['surname']."</td>";
																			echo "<td>".$auxArray['name']."</td>";
																			echo "<td>".$auxArray['description']."</td>";
																			$date = date("F j, Y", strtotime("$auxArray[limit_date]"));
																			echo "<td>".$date."</td>";
																			echo "<td style='text-align: center'><a href='Tasks/modifyTask.phptask=$auxArray[task_ID]&$_GET[client]'><i class='fa fa-edit' style='font-size:20px;color:green'></i></a></td>";
																		echo "</tr>";
																	}
																?>
															</tbody>
														</table>
													</div>
												<!-- /Highlighted -->

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
					<!-- Main content -->

				</div>
			</div>
		</div>

		<!-- Bootstrap JS -->
			<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
			<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<!-- /Bootstrap JS -->

		<!-- FullCalendar Script -->
			<script>
				document.addEventListener('DOMContentLoaded', function() {
					var calendarEl = document.getElementById('calendar');

					var calendar = new FullCalendar.Calendar(calendarEl, {
						plugins: [ 'interaction', 'dayGrid' ],
						header: {
							left: 'prev,next, today',
							center: 'title',
							right: 'dayGridMonth,dayGridWeek'
						},

						views: {
							dayGridWeek: {
								type: 'timeGrid',
								duration: { days: 4 },
								buttonText: 'Semana'
							}
						},

						// defaultDate: '2019-05-12',
						navLinks: false, // can click day/week names to navigate views
						editable: true,
						eventLimit: true, // allow "more" link when too many events
						locale: 'es'
					});
					calendar.setOption('height', 1000);
					calendar.render();
				});
			</script>
		<!-- /FullCalendar Script -->

	</body>
</html>