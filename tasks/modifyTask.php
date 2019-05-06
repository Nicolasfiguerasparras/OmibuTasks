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
                $id = collectID($db, 'tareas');

                // Client ID from URL
                if(isset($_GET['client'])){
                    $clientID = $_GET['client'];
                }
            ?>
		<!-- /Establish connection with DB -->

		<!-- Restrictions -->
			<?php
                if(!isset($_SESSION['email'])){
					header("location: notAllowed.php");
                }
			?>
		<!-- /Restrictions -->

        <!-- Form action -->
                <?php
                    if(isset($_POST['addTask'])){
                        $title = $_POST['title'];
                        $priority = $_POST['priority'];
                        $description = $_POST['description'];
                        $limitDate = $_POST['limitDate'];
                        $workerID = $_POST['worker'];
                        $clientID = $_POST['clientID'];
                        
                        // Restrictions

                        $createTaskQuery = mysqli_query($db, "INSERT INTO tareas (ID_tarea, Nombre, Descripcion, Fecha, Prioridad, Trabajador, Cliente, Finalizado) VALUES (NULL, '$title', '$description', '$limitDate', '$priority', '$workerID', '$clientID', '0')") or die(mysqli_error($db));

                        header("location: ../index.php");
                    }
                ?>
        <!-- /Form action -->
		
		<!-- Extract client data -->
			<?php
				$workerData = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM trabajadores WHERE Email = '$_SESSION[email]'"));
			?>
		<!-- /Extract client data -->
	
		<div class="container-fluid">
			<div class="mainBox">

                <!-- Header -->
                    <div class="row">

                        <!-- Add client button -->
                            <div class="col-3 addClientBox">
                                <a href="#"><i class="fas fa-plus-circle addClientBtn"></i></a>
                            </div>
                        <!-- /Add client button -->

                        <!-- Welcome message -->
                            <div class="col-9 welcomeMessage">
                                <h1><?php echo $workerData['Nombre']." ".$workerData['Apellidos'] ?></h1>
                            </div>
                        <!-- /Welcome message -->

                    </div>
                <!-- /Header -->

                <!-- Down header -->
                    <div class="row">
                        <!-- Lateral NavBar client list from DB -->
                            <div class="col-3">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link" href="../myTasks/">Mis tareas</a>
                                    <?php
                                        $clientsQuery = mysqli_query($db, "SELECT * FROM clientes");

                                        if($row = mysqli_fetch_array($clientsQuery)){ 
                                            do{
                                                if(isset($_GET['client'])){
                                                    if($_GET['client'] == $row['ID_cliente']){
                                                        echo "<a class='nav-link active' href='../index.php?client='$row[ID_cliente]'>".$row['Nombre']."</a>";
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
                            </div>
                        <!-- /Lateral NavBar client list from DB -->

                        <!-- Main content -->
                            <div class="col-9">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">

                                        <form action="addTask.php" method="post" id="addTaskForm">

                                            <!-- Invisible inputs -->
                                                <input type="number" value="<?php echo $id ?>" name="taskID" hidden>
                                                <input type="number" value="<?php echo $clientID ?>" name="clientID" hidden>
                                            <!-- /Invisible inputs -->

                                            <!-- Get actual values -->
                                                <?php
                                                    $actualValues = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM tasks WHERE ID_tarea = '$_GET[task]'"));
                                                ?>
                                            <!-- /Get actual values -->

                                            <div class="form-row">
                                                <div class="form-group col-md-5">
                                                    <label for="title">Título de la tarea</label>
                                                    <input id="title" name="title" type="text" class="form-control" value="<?php echo $actualValues['Nombre'] ?>" required>
                                                </div>
                                                <div class="form-group col-md-5">
                                                    <label for="priority">Prioridad</label>
                                                    <select id="priority" name="priority" class="form-control">
                                                        <option selected value="0" disabled>Escoja una prioridad...</option>
                                                        <option value="1">Prioridad alta</option>
                                                        <option value="2">Prioridad media</option>
                                                        <option value="3">Prioridad baja</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-10">
                                                    <label for="description">Descripción</label>
                                                    <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-5">
                                                    <label for="worker">Trabajador</label>
                                                    <select id="worker" name="worker" class="form-control">
                                                        <option selected disabled value="0">Elige un trabajador para esta tarea...</option>
                                                        <?php 
                                                            $workerQuery = mysqli_query($db, "SELECT ID_trabajador, Nombre, Apellidos FROM trabajadores");
                                                            // Workers count
                                                            $rows = mysqli_num_rows($workerQuery);

                                                            // For loop depending of workers count
                                                            for($i=0;$i<$rows;$i++){
                                                                $data=mysqli_fetch_array($workerQuery);
                                                                echo "<option value='$data[ID_trabajador]'>$data[Nombre] $data[Apellidos]</option>"; 
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-5">
                                                    <label for="limitDate">Fecha límite</label>
                                                    <input type="date" class="form-control"name="limitDate" id="limitDate">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-2">
                                                    <input type="submit" class="btn btn-primary" id="addTask" name="addTask">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <!-- /Main content -->

                    </div>
                <!-- /Down header -->

			</div>
		</div>

		<!-- Bootstrap JS -->
			<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
			<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<!-- /Bootstrap JS -->
	</body>
</html>