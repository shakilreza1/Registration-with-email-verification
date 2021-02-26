<?php
session_start();
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
	$user_home->redirect('index.php');
}

$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));        // userSession means which id is login is store in (:uid) and (:uid is store                                                                      in userID to Select user id);
$row = $stmt->fetch(PDO::FETCH_ASSOC);                          // Select data collected using fetch function and store in $stmt variable;

?>

<!DOCTYPE html>
<html>
    
    <head>
        <title><?php echo $row['userEmail']; ?></title>
        
    </head>
    
    <body>
        <div>
            <div>
                <div>
                    <a> <span></span>
                     <span></span>
                     <span></span>
                    </a>
                    <a href="#">Member's Home</a>
                    <div>
                        <ul>
                            <li>
                                <a href="#" role="button"> <i></i> 
								<?php echo $row['userEmail']; ?> <i></i>
                                </a>
                                <ul>
                                    <li>
                                        <a tabindex="-1" href="logout.php">Logout</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <ul>
                            <li>
                                <a href="#">Belancer Learning Tools</a>
                            </li>
                            <li>
                                <a href="#"><b>Training On... </b>

                                </a>
                                <ul>
                                    <li><a href="#">PHP OOP</a></li>
                                    <li><a href="#">PHP PDO</a></li>
                                    <li><a href="#">jQuery</a></li>
                                    <li><a href="#">Bootstrap</a></li>
                                    <li><a href="#">ASP.NET</a></li>
                                </ul>
                            </li>
                            
                            
                            
                        </ul>
                    </div>
                    
                </div>
            </div>
        </div>       
           
    </body>

</html>