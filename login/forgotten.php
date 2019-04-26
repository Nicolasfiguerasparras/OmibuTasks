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

        <!-- Forgotten action -->
            <?php
                use PHPMailer\PHPMailer\PHPMailer;
                use PHPMailer\PHPMailer\Exception;
                
                require '../mailer/src/Exception.php';
                require '../mailer/src/PHPMailer.php';
                require '../mailer/src/SMTP.php';

                if(isset($_POST['forgotten'])){
                    $forgottenEmail = $_POST['email'];

                    // Instantiation and passing `true` enables exceptions
                    $mail = new PHPMailer(true);

                    try{
                        //Server settings
                        $mail->SMTPDebug = 2;                                       // Enable verbose debug output
                        $mail->isSMTP();                                            // Set mailer to use SMTP
                        $mail->Host       = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
                        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                        $mail->Username   = 'example@gmail.com';      // SMTP username
                        $mail->Password   = 'pass';              // SMTP password
                        $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
                        $mail->Port       = 587;                                    // TCP port to connect to

                        //Recipients
                        $mail->setFrom('nicolasfiguerasparras@gmail.com', 'Nicolás Figueras Parras');
                        $mail->addAddress($forgottenEmail);     // Add a recipient
                        
                        // Content
                        $mail->isHTML(true);                                  // Set email format to HTML
                        $mail->Subject = 'Restablecer la contraseña';
                        $mail->Body    = 'Su contraseña de restauración es <b>12345</b>';

                        $mail->send();
                    }catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                }
            ?>
        <!-- /Forgotten action -->

		<div class="limiter">
			<div class="container-login100">
				<div class="wrap-login100">

                    <!-- Lateral image -->
                        <div class="login100-pic js-tilt" data-tilt>
                            <img src="images/img-01.png" alt="IMG">
                        </div>
                    <!-- /Lateral image -->

                    <!-- Forgotten form -->
                        <form class="login100-form validate-form" method="post" enctype="multipart/form-data">
                            <span class="login100-form-title">
                                ¿Ha olvidado su contraseña?
                            </span>

                            <div class="wrap-input100 validate-input" data-validate = "Es necesario un email válido: ej@abc.abc">
                                <input class="input100" type="text" name="email" placeholder="Introduzca su email">
                                <span class="focus-input100"></span>
                                <span class="symbol-input100">
                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                </span>
                            </div>

                            <div class="container-login100-form-btn">
                                <input type="submit" class="login100-form-btn" name="forgotten" value="Enviar" style="text-align:center">
                            </div>

                            <div class="text-center return">
                                <a class="txt2" href="index.php">
                                    Volver atrás
                                </a>
                            </div>
                        </form>
                    <!-- /Forgotten form -->

				</div>
			</div>
		</div>

		<!-- Scripts -->
		    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>

            <script src="vendor/bootstrap/js/popper.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

            <script src="vendor/select2/select2.min.js"></script>

            <script src="vendor/tilt/tilt.jquery.min.js"></script>
            <script>
                $('.js-tilt').tilt({
                    scale: 1.1
                })
            </script>
            <script src="js/main.js"></script>
        <!-- /Scripts -->

	</body>
</html>