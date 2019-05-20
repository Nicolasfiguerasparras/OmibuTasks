<!--Extract session-->
<?php
        session_start();
    ?>
<!--/Extract session-->

<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- --------------------------------------------------------------------------------------------- -->
        <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
        <!-- --------------------------------------------------------------------------------------------- -->
        <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
        <!-- --------------------------------------------------------------------------------------------- -->
        <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
        <!-- --------------------------------------------------------------------------------------------- -->
        <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
        <!-- --------------------------------------------------------------------------------------------- -->
        <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
        <!-- --------------------------------------------------------------------------------------------- -->
        <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
        <!-- --------------------------------------------------------------------------------------------- -->
        <link rel="stylesheet" type="text/css" href="css/util.css">
        <link rel="stylesheet" type="text/css" href="css/main.css">
        <!-- --------------------------------------------------------------------------------------------- -->
    </head>
    <body>

        <!-- Establish connection with DB -->
            <?php
                include('../connectDB.php');
                $db = connectDb();
            ?>
        <!-- /Establish connection with DB -->

        <!-- Form action -->
            <?php
                if(isset($_POST['login'])){
                    $email = $_POST['email'];
                    $password = $_POST['pass'];
                    
                    $loginQuery = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM worker WHERE email = '$email' and password = '$password'"));
                    
                    if(!$loginQuery == ""){
                        $_SESSION['login_ok'] = true;
                        $_SESSION['email'] = $email;
                        $_SESSION['ID']= $loginQuery['worker_ID'];
                        
                        // Codificate session and save in cookie if openSession exist
                        $dataSesion = session_encode();
                        
                        if(isset($_POST['openSession'])){
                            setcookie("session", $dataSesion, time()+(60*60*60), "/");
                        }

                        header("Location: ../index.php");
                    }else{
                        header("Location: index.php?error=true");
                    }
                }
            ?>
        <!-- /Form action -->

        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100">
                    <div class="login100-pic js-tilt" data-tilt>
                        <img src="images/rupert.gif" alt="gif de rupert, mascota de Ómibu">
                    </div>

                    <form class="login100-form validate-form" method="post" enctype="multipart/form-data">
                        <span class="login100-form-title">
                            Área de usuarios
                        </span>

                        <div class="wrap-input100 validate-input" data-validate = "Es necesario un email válido: ej@abc.abc">
                            <input class="input100" type="text" name="email" placeholder="Email">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                            </span>
                        </div>

                        <div class="wrap-input100 validate-input" data-validate = "Es necesario introducir una contraseña">
                            <input class="input100" type="password" name="pass" placeholder="Contraseña">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="fa fa-lock" aria-hidden="true"></i>
                            </span>
                        </div>

                        <div class="checkbox">
                            <input type="checkbox" name="openSession"> Mantener la sesión abierta
                        </div>

                        <div class="container-login100-form-btn">
                            <input type="submit" class="login100-form-btn" name="login" value="Acceder" style="text-align:center">
                        </div>

                        <?php
                            if(isset($_GET['error']) && $_GET['error'] == 'true'){
                                echo "
                                    <div class='text-center' style='color:red'>
                                        <p>Email y/o contraseña incorrecta</p>
                                    </div>
                                ";
                            }
                        ?>

                        <div class="text-center p-t-12">
                            <a class="txt2" href="forgotten.php">
                                ¿Ha olvidado su contraseña?
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- --------------------------------------------------------------------------------------------- -->
        <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
        <!-- --------------------------------------------------------------------------------------------- -->
        <script src="vendor/bootstrap/js/popper.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
        <!-- --------------------------------------------------------------------------------------------- -->
        <script src="vendor/select2/select2.min.js"></script>
        <!-- --------------------------------------------------------------------------------------------- -->
        <script src="vendor/tilt/tilt.jquery.min.js"></script>
        <script >
            $('.js-tilt').tilt({
                scale: 1.1
            })
        </script>
        <!-- --------------------------------------------------------------------------------------------- -->
        <script src="js/main.js"></script>

    </body>
</html>