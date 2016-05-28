<?php

require 'init.php';
session_start();

function FindDuplicates($str, $what){//returns true if duplicate/s is found
	global $conn;
	$sql = "SELECT `$what` FROM `users` WHERE `$what` = '$str';";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result)>0){
		return true;
	}else{
		return false;
	}
}

if(!isset($_SESSION['email'])){

	$username = isset($_POST['username']) ? $_POST['username'] : '';
	$name = isset($_POST['name']) ? $_POST['name'] : '';
	$email = isset($_POST['email']) ? $_POST['email'] : '';
	$password = isset($_POST['password']) ? $_POST['password'] : '';
	$passwordAgain = isset($_POST['passwordAgain']) ? $_POST['passwordAgain'] : '';

	$username = htmlspecialchars($username);
	$name = htmlspecialchars($name);
	$email = htmlspecialchars($email);
	$password = htmlspecialchars($password);
	$passwordAgain = htmlspecialchars($passwordAgain);

	$error_username=false;
	$error_email=false;
	$error_password=false;

	if(isset($_POST['submit'])){
		
		if(!empty($username) && !empty($name) && !empty($email) && !empty($password) && !empty($passwordAgain)){
			
			if($password==$passwordAgain){
				$error_password=false;
			}else{
				$error_password=true;
			}
			
			if(!FindDuplicates($email, 'email')){
				$error_email=false;
			}else{
				$error_email=true;
			}
					
			if(!FindDuplicates($username, 'username')){
				$error_username=false;
			}else{
				$error_username=true;
			}

			if($error_username){
				echo "Error in username.";
			}
			if($error_email){
				echo "Error in email.";
			}
			if($error_password){
				echo "Error in password.";
			}
			if(!$error_username && !$error_email && !$error_password){
				$sql = "INSERT INTO `users` (`username`, `name`, `email`, `password`) VALUES ('$username', '$name', '$email', '$password');";
				mysqli_query($conn, $sql);
				echo "Success.";
			}

		}else{
			echo "Fill in all the details.";
		}
		
	}

}

?>

<?php if(!isset($_SESSION['email'])){ ?>
<b>Register</b>
<br>
<br>

<form action="register.php" method="post">

  Username:
  <br>
  <input type="text" name="username" maxlength="128">
  <br>
  <br>
  
  Name:
  <br>
  <input type="text" name="name" maxlength="128">
  <br>
  <br>
  
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
  
  Password again:
  <br>
  <input type="password" name="passwordAgain" maxlength="128">
  <br>
  <br>
  
  <input type="submit" name="submit" value="Submit">
  
</form>

<?php }else{echo 'You are already logged in.';} ?>