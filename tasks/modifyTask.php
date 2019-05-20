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
            ?>
		<!-- /Establish connection with DB -->

		<!-- Restrictions -->
			<?php
                if(!isset($_SESSION['login_ok'])){
					header("location: notAllowed.php");
                }

                if(!isset($_GET['task'])){
                    header("location: ../");
                }

                if(!isset($_GET['client'])){
                    header("location: ../");
                }
			?>
		<!-- /Restrictions -->

        <!-- Extract actual data -->
			<?php
                $task_ID = $_GET['task'];
                $client_ID = $_GET['client'];

                $actualValues = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM tareas WHERE ID_tarea = '$task_ID'"));
				$workerData = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM trabajadores WHERE ID_trabajador = '$_SESSION[ID]'"));
			?>
		<!-- /Extract actual data -->

        <!-- Form action -->
                <?php
                    if(isset($_POST['modifyTask'])){
                        $title = $_POST['title'];
                        if($_POST['priority'] == '1' || $_POST['priority'] == true){
                            $priority = $_POST['priority'];
                        }elseif($_POST['priority'] == '2' || $_POST['priority'] == false){
                            $priority = '2';
                        }
                        $description = $_POST['description'];
                        $limitDate = $_POST['limitDate'];
                        $workerID = $_POST['worker'];
                        $clientID = $_POST['clientID'];
                        $taskID = $_POST['taskID'];
                        
                        // Add restrictions to inputs //

                        $modifyTaskQuery = mysqli_query($db, "
                                                        UPDATE tareas SET 
                                                                    Nombre='$title', 
                                                                    Descripcion='$description', 
                                                                    Fecha='$limitDate', 
                                                                    Prioridad='$priority', 
                                                                    Trabajador='$workerID' 
                                                        WHERE ID_tarea='$task_ID'
                                                        ") or die(mysqli_error($db));

                        echo mysqli_error($db);
                        header("location: ../index.php?client=$_POST[clientID]");
                    }
                ?>
        <!-- /Form action -->
	
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

                                        <form action="modifyTask.php" method="post" id="addTaskForm">

                                            <!-- Invisible inputs -->
                                                <input type="number" value="<?php echo $task_ID ?>" name="taskID" hidden>
                                                <input type="number" value="<?php echo $client_ID ?>" name="clientID" hidden>
                                            <!-- /Invisible inputs -->

                                            <div class="form-row">
                                                <div class="form-group col-md-10">
                                                    <label for="title">Título de la tarea</label>
                                                    <input id="title" name="title" type="text" class="form-control" value="<?php echo $actualValues['Nombre'] ?>" required>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-10">
                                                    <label for="description">Descripción</label>
                                                    <textarea class="form-control" name="description" value="<?php echo $actualValues['Descripcion'] ?>" id="description" rows="3"><?php echo $actualValues['Descripcion'] ?></textarea>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-5">
                                                    <label for="worker">Trabajador</label>
                                                    <select id="worker" name="worker" class="form-control">
                                                        <option value="0">Elige un trabajador para esta tarea...</option>
                                                        <?php
                                                            $workerQuery = mysqli_query($db, "SELECT ID_trabajador, Nombre, Apellidos FROM trabajadores");
                                                            // Workers count
                                                            $rows = mysqli_num_rows($workerQuery);

                                                            // For loop depending of workers count
                                                            for($i=0;$i<$rows;$i++){
                                                                $data=mysqli_fetch_array($workerQuery);
                                                                if($data['ID_trabajador'] == $actualValues['Trabajador']){
                                                                    echo "<option selected value='$data[ID_trabajador]'>$data[Nombre] $data[Apellidos]</option>"; 
                                                                }else{
                                                                    echo "<option value='$data[ID_trabajador]'>$data[Nombre] $data[Apellidos]</option>"; 
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-5">
                                                    <label for="limitDate">Fecha límite</label>
                                                    <input type="date" class="form-control" value="<?php echo $actualValues['Fecha'] ?>"  name="limitDate" id="limitDate">
                                                </div>
                                            </div>
                                            <div>
                                            <div class="form-row">
                                                <div class="form-group col-md-3" >
                                                    <label class="container" style="padding-left: 0px">
                                                        <input type="checkbox" name="priority" value="<?php echo $actualValues['Prioridad'] ?>" <?php if($actualValues['Prioridad']=='1'){ echo "checked='true'"; } ?>> Destacar
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-2"">
                                                    <input type="submit" class="btn btn-primary" id="modifyTask" name="modifyTask">
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