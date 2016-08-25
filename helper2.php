<?php
require_once 'functions.php'; 
//$temp_dir ="./users/$user/gallery";
$user = $_POST['post_id'];
$albName =$_POST['post_key'];
//$albName = "arts";
$myText = (string)$albName;
$String = preg_replace('/\s+/', '', $myText);
$directory =  "./users/$user/gallery/$String/";

//$directory = str_replace(' ', '', $directory);
			$files = glob($directory . '*.jpg');
			 if ( $files !== false )
			 {
			$filecount = count($files);
				// create_tags($filecount);
				 echo $filecount; 

			 }
				
?>