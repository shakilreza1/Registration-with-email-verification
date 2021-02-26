<?php
session_start();

require_once 'class.user.php';

$user_login = new USER();

if($user_login->is_logged_in()!="")
{
	$user_login->redirect('home.php');
}

if(isset($_POST['btn-login']))
{
	$email = trim($_POST['txtemail']);
	$upass = trim($_POST['txtupass']);
	
	if($user_login->login($email,$upass))
	{
		$user_login->redirect('home.php');
	}
}
?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>Login</title>
        <!-- ===================================== -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--========================-->
        <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
        <a href="https://icons8.com"></a>
        <!--========================-->
        <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
        <!--========================-->
        <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
        <!--========================-->
        <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
        <!--========================-->
        <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
        <!--========================-->
        <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
        <!--========================-->
        <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
        <!--========================-->
        <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
        <!--========================-->
        <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">

        <link rel="stylesheet" type="text/css" href="css/util.css">
        <link rel="stylesheet" type="text/css" href="css/main.css">

        <!-- ===================================== -->
    </head>

    <body>
<div>
            <!-- =========================== -->
            <?php 
		if(isset($_GET['inactive']))
		{
			?>
            <div>
                <strong>Sorry!</strong> This Account is not Activated Go to your Inbox and Activate it.
            </div>
            <?php
		}
		?>

            <div class="limiter">
                <div class="container-login100">
                    <div class="wrap-login100">

                        <form class="login100-form validate-form" method="post">


                            <span class="login100-form-title p-b-18">
						<i class=""><img src="data:image/png;base64,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"></i>
					</span>
                            <span class="login100-form-title p-b-26">LOGIN</span>

                            <?php
                        if(isset($_GET['error']))
                        {
                    ?>
                                <div>
                                    <strong style="color:red;font-family:roboto;font-size:20px;">Wrong Details!</strong>

                                </div>
                                <?php
                        }
                    ?>
                                    <div style="margin-bottom:13px;"></div>

                                    <div class="wrap-input100 validate-input" data-validate="Valid email is: a@b.c">
                                        <input class="input100" type="email" name="txtemail" required>
                                        <span class="focus-input100" data-placeholder="Email"></span>
                                    </div>

                                    <div class="wrap-input100 validate-input" data-validate="Enter password">
                                        <span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
                                        <input class="input100" type="password" name="txtupass" required>
                                        <span class="focus-input100" data-placeholder="Password"></span>
                                    </div>

                                    <div class="container-login100-form-btn">
                                        <div class="wrap-login100-form-btn">
                                            <div class="login100-form-bgbtn"></div>
                                            <button class="login100-form-btn" name="btn-login" type="submit">Login</button>
                                        </div>
                                    </div>

                                    <div class="text-center p-t-20">
                                        <span class="txt1">Don’t have an account?</span>

                                        <a class="txt2" href="signup.php">Sign Up</a>
                                    </div>
                                    <div class="text-center p-t-20">
                                        <span class="txt1"></span>
                                      
                                        <a class="txt2" id="fp" href="fpass.php">Lost your Password ? </a>
                                    </div>
                        </form>
                    </div>
                </div>
            </div>


            <div id="dropDownSelect1"></div>
            <!-- =========================== -->
        </div>


        <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
        <script src="vendor/animsition/js/animsition.min.js"></script>
        <script src="vendor/bootstrap/js/popper.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="vendor/select2/select2.min.js"></script>
        <script src="vendor/daterangepicker/moment.min.js"></script>
        <script src="vendor/daterangepicker/daterangepicker.js"></script>
        <script src="vendor/countdowntime/countdowntime.js"></script>
        <script src="js/main.js"></script>
    </body>

    </html>
