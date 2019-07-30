






<?php
session_start();
 
 if(!isset($_SESSION['username'])){
 	header("location: index.html");
 }

?>

<html>
<head>
   <link rel = "stylesheet" type="text/css" href = "css/style.css">
	<link rel = "stylesheet" type="text/css" href = "css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="JavaScript/js.js"></script>
</head>
<body style='background:#BBB'>

	<!-- Start Navigation Bar -->

	<div class = "nav">
			<h2>Welcome <span> <?php echo "< <a href='home.php'>" . $_SESSION['username'] . "</a> >"; ?> </span></h2>
		<div class = "btn-logout">
			<button onclick = "window.location.href = 'logout.php'">Logout
				<li class="fa fa-sign-out"></li> </button>
		</div>
	</div>

	<!-- End Navigation Bar -->

	<!-- Start Content -->

	<div class = "content">
		<h3>Create Files Here...</h3>
		<hr>
			<div class = "directories">
				<form method = "post" action = "">
				<input type = "text" name = "directory" placeholder="Name Of Folder, Ex: Game">
				<br>
				<button type = "submit" name = "add_directory_btn">Add Directory</button>
			</form>
		</div>
		<li class = "fa fa-exchange"></li>
			<div class = "files">
				<form method = "post" action = "">
				<input type = "text" name = "file" placeholder="Name Of File, Ex: Word.txt">
				<br>
				<button type = "submit" name = "add_file_btn">Add File</button>
			</form>
			</div>
	</div>

	<!-- End Content -->


</body>
</html>

<?php

$username = $_SESSION['username'];

// scan for all files inside files folder.
// Print for all files and folder and add link on the folders to navigate them

if(isset( $_GET['path']) && startWith($_GET['path'],'files\\'.$username)) {
	$current = $_GET['path'];
}
else {
	$current = 'files\\' . $username;
}

if(!file_exists($current))exit();


$path = explode("\\", $current);


$cur  = $path[0] . '\\' . $path[1];//to escape the File/Session['username']!
echo "<li class='fa fa-home'></li> <a href='?path=$cur' style='color:#00F'>$username</a>";

	$count = count($path);

//To Navigate between the Directories!
for($i = 2; $i < $count; $i++){
	$cur .= '\\'.$path[$i];
	echo " <li class='fa fa-caret-right'></li> <a href='?path=$cur' style='color:#00F'>" . $path[$i] . "</a>";
}



//Creates The Table of Results!.
echo "<table border = 1 align = center>";
echo "<th>*<input type = 'checkbox' id='select-all'> 
Name</th> 
<th>Type</th>
 <th>Size</th> 
 <th>Date</th>";

echo "<tr>";

//Retrieving the data!
$scan = scandir($current);

foreach ($scan as $value) {
	if($value[0] == '.')
		continue; 

	$currSize = filesize(getcwd() . '\\' .$current .'\\'. $value);
	$curType = filetype(getcwd() . '\\' . $current .'\\'. $value);
	 
	if($curType == 'dir'){
		$t = "<li class = 'fa fa-folder'></li>";
	}else {
		$t = "<li class = 'fa fa-file'></li>";
	}

	/*Retrieving the folders and files as a link!*/
	echo "<td>"; ?>
	<form action = "delete.php" method = 'post'>
	<input type='checkbox' name='files[]' value="<?php echo $current .'\\'. $value; ?>"/>
   <?php
	echo'<a href="home.php?path=' . $current . '\\'. $value . '" style = \'font-size:18px;\'> ' . $value; ?>
	<?php
	echo "</td>";

	echo "<td style = 'color:#555'>" . $t . "</td>";//The type as font if is 'Dir' or 'File'!
	echo "<td style = 'color:#da6d6d'>" . $currSize . " Bytes" . "</td>";//size in bytes!
	echo "<td style = 'color:orange'>" . date("D/M/Y H:i:s") . "</td>";//last date

	 echo "</tr>";	
}

	echo "<caption align = 'bottom'>"; ?> <!-- Submit of the Deleting Data -->

		 	<input type = 'submit' name="delete" value = 'Delete'>
		 </form>

	 <?php
	echo "</caption>";
	echo "</table>";



//Adding A New Directory
if(isset($_POST['add_directory_btn'])){

	$directory = $_POST['directory'];

	if(empty($directory)){
		die("<h3 align=center>Expected Folder Name!</h3>");
	}

	if(file_exists($current . '\\' . $directory)){

		echo ("<h3 align=center>Sorry, The Directory Is Exists!</h3");

   } else {

   	mkdir($current . '\\' . $directory);
   	header('location: home.php?path=' . $_GET['path']);

   }
}

//Adding A New File
if(isset($_POST['add_file_btn'])){

	$file = $_POST['file'];

	if(empty($file)){
		die("<h3 align=center>Expected File Name!</h3>");
	}

	if(file_exists($current . '\\' . $file)){

	 echo ("<h3 align=center>Sorry, The File Is Exists!</h3>");

   } else {

   	$f = fopen($current . '\\' . $file, 'w');

   	header('location: home.php?path=' . $current);

   }
}


function startWith($a, $b){

	$lenb = strlen($b);
	$lena = strlen($a);
	/*if($lena < $lenb)return false;
	for($i = 0;$i< $lenb; $i++){
		if($a[$i]!=$b[$i])return false;
	}*/

	if(substr($a, 0,$lenb) == $b)
		return 1;
	return 0;

	//return true;
}


?>