<?php
error_reporting(0);
require_once 'dbconfig.php';

class USER
{	

	private $conn;
	
	public function __construct()
	{
		$database = new Database();           // dbconfig.php database connection class name Database object create name $database;
		$db = $database->dbConnection();      // $database object create which is used to call database class function dbConnection() and it                                            store in $db variable;
		$this->conn = $db;                    // $this is use to call the  class(User) of this function and connected it with database                                                   used by database variable $db;
        
    }
	
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	
	public function lasdID()
	{
		$stmt = $this->conn->lastInsertId();
		return $stmt;
	}
	
	public function register($fname,$lname,$uname,$email,$upass,$code,$date)
	{
		try
		{							
			$password = md5($upass);
			$stmt = $this->conn->prepare("INSERT INTO tbl_users(firstName,lastName,userName,userEmail,userPass,tokenCode) 
			                                             VALUES(:first_name, :last_name, :user_name, :user_mail, :user_pass, :active_code)");
			$stmt->bindparam(":first_name",$fname);
			$stmt->bindparam(":last_name",$lname);
			$stmt->bindparam(":user_name",$uname);
			$stmt->bindparam(":user_mail",$email);
			$stmt->bindparam(":user_pass",$password);
			$stmt->bindparam(":active_code",$code);
			$stmt->execute();	
			
			return $stmt;
		}

		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}
	
	public function login($email,$upass)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM tbl_users WHERE userEmail=:email_id");

			$stmt->execute(array(":email_id"=>$email)); //another technique for binding parameters

			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			
			if($stmt->rowCount() == 1)
			{
				if($userRow['userStatus']=="Y")
				{
					if($userRow['userPass']==md5($upass))                 // userpassword and database password matching...;
					{
						$_SESSION['userSession'] = $userRow['userID'];    // userId is store in userSession;
						
						return true;
					}
					else
					{
						header("Location: index.php?error");
						exit;
					}
				}
				else
				{
					header("Location: index.php?inactive");
					exit;
				}	
			}
			else
			{
				header("Location: index.php?error");
				exit;
			}		
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}
	
	
	public function is_logged_in()
	{
		if(isset($_SESSION['userSession']))
		{
			return true;
		}
	}
	
	public function redirect($url)
	{
		header("Location: $url");
	}
	
	public function logout()
	{
		session_destroy();

		$_SESSION['userSession'] = false;     // userSession is use to false because no one can entry main page just typing the url of main                                           page;
	}
	
	function send_mail($email,$message,$subject)
	{						
		require_once('mailer/class.phpmailer.php');
		
		$mail = new PHPMailer(true);
		$mail->IsSMTP(); 
		$mail->SMTPDebug  = 0;                     
		$mail->SMTPAuth   = true;                  
		$mail->SMTPSecure = "ssl";                // ssl : Secure Sockets Layer;             
		$mail->Host       = "smtp.gmail.com";      
		$mail->Port       = 465;             
		$mail->AddAddress($email);
		$mail->Username='wdevc1802@gmail.com';    // This is used to send mail by that id;
		$mail->Password='rezasha01980';              // Id password must have to give for accessing that id;
		$mail->SetFrom('wdevc1802@gmail.com','belancer');     // It show the user mail inbox which id they get mail;
		$mail->AddReplyTo("wdevc1802@gmail.com","belancer");  // It use to reply that id for comment of any question;
		$mail->Subject    = $subject;
		$mail->MsgHTML($message);
		$mail->Send();
	}	
}