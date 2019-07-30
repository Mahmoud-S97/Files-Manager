






<!DOCTYPE html>
<html>
<head> 
	<title>File Manager</title>
	<link rel = "stylesheet" type="text/css" href = "css/style.css">
	<link rel = "stylesheet" type="text/css" href = "css/font-awesome.min.css">
</head>
<body>
  
  <div class = "container">
  	<div class = "frm">
  		<h2>Register</h2>
  		<form method = "post" action = "register.php">
  		 <div class = "input-fields">
  			<label>Username*</label>
  			<input type = "text" name = "username" class = "input">
  		</div>
  			 <div class = "input-fields">
  			<label>Password*</label>
  			<input type = "password" name = "password_1" class = "input">
  		</div>
  		<div class = "input-fields">
  			<label>Re-type Password*</label>
  			<input type = "password" name = "password_2" class = "input">
  		</div>
  			<input type = "submit" name = "reg_btn" value = "Register">
  			<p>Already Registered? <a href = "index.html">Login</a></p>
  		</div>
  		</form>
  	</div>
  </div>

</body>
</html>

<?php

session_start();

$errors = array();

if(isset($_POST['reg_btn'])){

	$username = strtolower($_POST['username']);
	$password_1 = strtolower($_POST['password_1']);
	$password_2 = strtolower($_POST['password_2']);

	if(empty($username)){
		array_push($errors, "User Name Is Required!");
	}
	if(empty($password_1)){
		array_push($errors, "Password Is Required!");
	}
	if($password_1 != $password_2){
		array_push($errors, "The Two Passwords Not Matched!");
	}
	if(count($errors) == 0){

		$file = fopen("users.txt", "r") or die("Unable to open file!");

		$theData = file("users.txt");

		$arr = array();

		$found = false;

		foreach ($theData as $line) {

			$line = trim($line);

			$arr = explode(" ", $line);

		 	if($arr[0] == $username){

		 		$found = true;

		 		fclose($file);

		 		echo "<div style = 'margin:0px auto;background-color:#DDD;
			text-align:center;color:#e44141; width:350px; border-radius:10px;'>";

				echo "This User Is Already Exists,"."</br>" . "Please Choose Another One!.";

				echo "</div>";

			 }//end if user is exists

		}// end foreach

			if($found == false){

			 		$file = fopen("users.txt", "a+");

			 		fwrite($file, "$username" . " " . "$password_1".PHP_EOL);

			 		fclose('users.txt');

			 		$_SESSION['username'] = $username;

			 		mkdir("files". '\\' . $_SESSION['username']);

			 		header("location: home.php");

		}//end if

	} else {
	
		foreach ($errors as $error) {

			echo "<div style = 'margin:0px auto;background-color:#DDD;
			text-align:center;color:#e44141; width:350px; border-radius:10px'>";

			foreach ($errors as $error) {

				echo "-" . $error . "</br>";
			}
			echo "</div>";
			die();
		}
	}
}

?>