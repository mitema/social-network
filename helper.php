<?php 
//header('Location: functions.php');
#session_start();
require_once 'functions.php'; 

 if (!$loggedin) die();

 if (isset($_SESSION['user']))
 {
		$user = $_SESSION['user'];
		if (isset($_POST['catName']))
		{
				$cat_name = $_POST['catName'];
				if ($cat_name == "") {
					$cat_name = "main";
	  			}

				if (!file_exists("./users/$user/gallery/$cat_name")) 
				{
						echo "<script type='text/javascript'>alert('hi3')</script>";
						mkdir("./users/$user/gallery/$cat_name", 0755, true);
						$filecount = 1;
						save($filecount,$user);

				}
				else
				{

						$directory =  "./users/$user/gallery/$cat_name/" ;
						$files = glob($directory . '*.jpg');
						if ( $files !== false )
						{
								$filecount = count( $files );
								$filecount++;
								save($filecount,$user);
								echo"<script>alert('upload sucess')</script>";
						}
						else
						{
								   $filecount = 1;
								   save($filecount,$user);
						}
			  	}

		}

 
}

?>