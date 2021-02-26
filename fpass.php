<?php
session_start();
require_once 'class.user.php';
$user = new USER();

if($user->is_logged_in()!="")
{
	$user->redirect('home.php');
}

if(isset($_POST['btn-submit']))
{
	$email = $_POST['txtemail'];
	
	$stmt = $user->runQuery("SELECT userID FROM tbl_users WHERE userEmail=:email LIMIT 1");    // LIMIT 1 is for one email no copy email that                                                                                               we set unique email in database;
	$stmt->execute(array(":email"=>$email));

	$row = $stmt->fetch(PDO::FETCH_ASSOC);	
	
	if($stmt->rowCount() == 1)
	{
		$id = base64_encode($row['userID']);
		$code = md5(uniqid(rand()));
		
		$stmt = $user->runQuery("UPDATE tbl_users SET tokenCode=:token WHERE userEmail=:email");
		$stmt->execute(array(":token"=>$code,"email"=>$email));
		
		$message= "
				   Hello , $email
				   <br /><br />
				   We got requested to reset your password, if you do this then just click the following link to reset your password, if not just ignore                   this email,
				   <br /><br />
				   Click Following Link To Reset Your Password 
				   <br /><br />
				   <a href='http://localhost/WDev-20th/Registration with email verification/resetpass.php?id=$id&code=$code'>click here to reset your password</a>
				   <br /><br />
				   thank you :)
				   ";
		$subject = "Password Reset";
		
		$user->send_mail($email,$message,$subject);
		
		$msg = "<div>
					We've sent an email to $email.
                    Please click on the password reset link in the email to generate new password. 
			  	</div>";
	}
	else
	{
		$msg = "<div>
					<strong>Sorry!</strong>  this email not found. 
			    </div>";
	}
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Forgot Password</title>
    <!-- ================================== -->
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
  <body style="background-position:top center;
    background-repeat: no-repeat;
    background-size: cover;
    background: rgba(227,91,91,1); background: -moz-linear-gradient(left, rgba(227,91,91,1) 0%, rgba(105,46,194,1) 51%, rgba(115,74,212,1) 75%, rgba(39,189,194,1) 100%); background: -webkit-gradient(left top, right top, color-stop(0%, rgba(227,91,91,1)), color-stop(51%, rgba(105,46,194,1)), color-stop(75%, rgba(115,74,212,1)), color-stop(100%, rgba(39,189,194,1))); background: -webkit-linear-gradient(left, rgba(227,91,91,1) 0%, rgba(105,46,194,1) 51%, rgba(115,74,212,1) 75%, rgba(39,189,194,1) 100%); background: -o-linear-gradient(left, rgba(227,91,91,1) 0%, rgba(105,46,194,1) 51%, rgba(115,74,212,1) 75%, rgba(39,189,194,1) 100%); background: -ms-linear-gradient(left, rgba(227,91,91,1) 0%, rgba(105,46,194,1) 51%, rgba(115,74,212,1) 75%, rgba(39,189,194,1) 100%); background: linear-gradient(to right, rgba(227,91,91,1) 0%, rgba(105,46,194,1) 51%, rgba(115,74,212,1) 75%, rgba(39,189,194,1) 100%); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e35b5b', endColorstr='#27bdc2', GradientType=1)">
    <div>

      <form  method="post">
        <h2 id="forgotp">Forgot Password</h2><hr />
        
        	<?php
			if(isset($msg))
			{
				echo $msg;
			}
			else
			{
				?>
              	<div id="ent">
				Please enter your email address. You will receive a link to create a new password via email.!
				</div>  
                <?php
			}
			?>
        <div class="container">
            <div class="row">
               <div class="col-md-2"></div>
                <div class="col-md-6">
                    <input id="gp" class="form-control" type="email" placeholder="Email address" name="txtemail" required />
                </div>
                <div class="col-md-2">
                    <button id="gpb" type="submit" class="btn btn-info" name="btn-submit">Generate new Password</button>
                </div>
            </div>
        </div>
        
       
   </form>

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