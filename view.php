






<?php


include "home.php";

 $file = scandir($_SESSION['username']);

$count = 0;

foreach($file as $num){
 
   if($num[0] == '.' || $num[1] == '.')
   {
   	continue;
   } else {

	echo "<table border = 1 align = center width = 50% height = 30px>";
	echo "<tr align = center>";

	echo "<td class = 'fa fa-file'>" . ' ' . $num . "</td>";

	echo "</tr>";

	echo "</table>";
	}

}
