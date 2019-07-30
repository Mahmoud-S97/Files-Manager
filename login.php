




<?php

session_start();

$errors = array();


if(isset($_POST['login_btn'])){

	$username = strtolower($_POST['username']);
    $password = strtolower($_POST['password']);
	
	if(empty($username)){

		array_push($errors, "User Name Is Required!");
	}

	if(empty($password)){

		array_push($errors, "Password Is Required!");
	}

	if(count($errors) == 0){

	  $file = fopen("users.txt", "r");

		$theData = file("users.txt");

		$arr = array();

		$found = false;

		foreach ($theData as $line) {

			$line = trim($line);

			$arr = explode(" ", $line);

			if($arr[0] == $username && $arr[1] == $password){

				$found = true;

				$_SESSION['username'] = $username;

				chdir("files". '\\' . $_SESSION['username']);

				fclose($file);

				header("location: home.php");
			
			} /*end the if user not Exists!*/ 
		}

			if($found == false){

					include "index.html";

				echo "<div style = 'margin:0px auto;background-color:#DDD;
			text-align:center;color:#e44141; width:350px; border-radius:10px;'>";

			 echo "Wrong in Username or Password" . "</br>" . "Please, Try Agaian!.";

			echo "</div>";	
		}


	} else {
	           include "index.html";

		foreach ($errors as $error) {

			echo "<div style = 'margin:0px auto;background-color:#DDD;
			text-align:center;color:#e44141; width:350px; border-radius:10px;'>";

			foreach ($errors as $error) {

				echo "-" . $error . "</br>";
			}//end for each about type of error!

			echo "</div>";
			
			die();
		}//end the first for each about the result Div

	}//end else if there is errors!

}//end isset(value)


?>