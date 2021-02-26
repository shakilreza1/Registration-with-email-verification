<?php
session_start();
require_once 'class.user.php';

$user = new USER();

 if($_POST) 
  {
      $fname     = strip_tags($_POST['txtfname']);
      $email     = strip_tags($_POST['txtemail']);
      
	  $stmt = $user->runQuery("SELECT * FROM tbl_users WHERE userEmail=:email_id");
      $stmt->execute(array(":email_id"=>$email));
	  $count=$stmt->rowCount();
	  	  
	  if($count>0)
	  {
		  echo "<span style='color:#ff6800;padding-left:5px;'>Sorry email already taken !!!</span>";
	  }
	  else
	  {
		  echo "<span style='color:#00ff29;padding-left:5px;'>Available</span>";
	  }
  }
  ?>