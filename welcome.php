<?php 

require 'init.php';

session_start();

if(isset($_SESSION['email'])){
	$name;
	$email=isset($_SESSION['email']) ? $_SESSION['email'] : '';
	$sql = " SELECT `name` FROM `users` WHERE `email` = '$email'; ";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			$name = $row['name'];
		}
	}
	echo "Welcome $name"; 
}else{
	echo "Please login.";
}

?>