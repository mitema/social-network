<?php // Example 26-8: profile.php
  require_once 'header.php';

  if (!$loggedin) die();

  echo "<div class='main'>";


  	if (isset($_GET['view'])) $view = sanitizeString($_GET['view']);
  	else                      $view = $user;


  
  	if (isset($_POST['catName'])) 
  	{
	  	$cat_name = $_POST['catName'];
	  	
	  	if ($cat_name == "") {
		  	$cat_name = "main";
	  	}
	  	
	  	if (!file_exists("./users/$view/gallery/$cat_name")) 
	  	{
			mkdir("./users/$view/gallery/$cat_name", 0755, true);
   		}   
      
   		$saveto = "./users/$view/gallery/$cat_name/" ;
	  	
  	}
  
  		
  		
  	
  
  if (isset($_FILES['image']['name']))
  {
    /* $saveto = "/var/www/html/robinsnest/$user/$username/$user.jpg"; */
    
    $temp_file_name = $_FILES['image']['tmp_name'];
    $p_parts = pathinfo($temp_file_name);
	$temp2name = $p_parts['filename'];
    
    
    $saveto = $saveto . $temp2name . ".jpg";
    //echo "<script type='text/javascript'>alert('original_path:$temp_file_name file_name:$temp2name save_path:$saveto')</script>";
    
    move_uploaded_file($_FILES['image']['tmp_name'], $saveto);
    
    $typeok = TRUE;

    switch($_FILES['image']['type'])
    {
      case "image/gif":   $src = imagecreatefromgif($saveto); break;
      case "image/jpeg":  // Both regular and progressive jpegs
      case "image/jpg":
      case "image/pjpeg": $src = imagecreatefromjpeg($saveto); break;
      case "image/png":   $src = imagecreatefrompng($saveto); break;
      default:            $typeok = FALSE; break;
    }

      imagejpeg($src, $saveto);
      imagedestroy($src);
    
  }
  
  showProfile($view);
  showGallery($view);

  echo <<<_END
    <form method='post' action='gallery.php' enctype='multipart/form-data'>
_END;
?>
    # Album Name : <input type="text" name="catName"><br>
    # temp: <input type='file' name='image' size='14'><input type='submit' value='Upload'>
    </form><br></div></div>
  </body>
</html>
