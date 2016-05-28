<?php

require 'init.php';
session_start();
if(!isset($_SESSION['email'])){

	$email = isset($_POST['email']) ? $_POST['email'] : '';
	$password = isset($_POST['password']) ? $_POST['password'] : '';

	$email = htmlspecialchars($email);
	$password = htmlspecialchars($password);

	$error=false;

	if(isset($_POST['submit'])){
	
		if(!empty($email) && !empty($password)){
			
			//check if it matches
			$sql = " SELECT `email` FROM `users` WHERE `email` = '$email' AND `password` = '$password'; ";
			$result = mysqli_query($conn, $sql);
			if(mysqli_num_rows($result)>0){
				$error = false;
			}else{
				$error = true;
			}
		
			if($error){
				echo "Error in email or/and password.";
			}
			if(!$error){
				//login
				$_SESSION['email']=$email;
				echo "Logged in.";
				header("Location: welcome.php");
			}

		}else{
			echo "Fill in all the details.";
		}
		
	}

}
?>


<b><?php   if(isset($_SESSION['email'])){echo 'You are already logged in.';}else{ echo 'Log in:';  ?></b>
<br>
<br>

<form action="login.php" method="post">

  Email address:
  <br>
  <input type="text" name="email" maxlength="128">
  <br>
  <br>
  
  Password:
  <br>
  <input type="password" name="password" maxlength="128">
  <br>
  <br>
  
  <input type="submit" name="submit" value="Submit">
  
</form>

<?php } ?>
