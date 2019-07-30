
<?php



if(isset($_POST['files'])){
	foreach($_POST['files'] as $file){
		deleteFolder($file);
		if(is_dir($file))
			rmdir($file);
		else unlink($file);
	}
}
header('Location: '. $_SERVER['HTTP_REFERER']);


function deleteFolder($folder){

if(file_exists($folder)){

	$inner = scandir($folder);

	unset($inner[0], $inner[1]);

	foreach ($inner as $content) {

		$currentPath = $folder . '\\' . $content;
		
		$type = filetype($currentPath);

		if($type == "dir"){
			deleteFolder($currentPath);
			rmdir($currentPath);
		}else {
			unlink($currentPath);
		}

	}
	//header("location: home.php?path=" . $current);

 } else {return false;}

}//end function delete
