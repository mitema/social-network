<?php


//echo "<script src='//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js'></script>";

 require_once 'header.php';
 require_once 'helper.php';

  if (!$loggedin) die();
   
function save($filecount,$user)
{
			$filecount;
			$temp_file_name = $_FILES['image']['tmp_name'];
			$p_parts = pathinfo($temp_file_name);
			$temp2name = $p_parts['filename'];
			$cat_name = $_POST['catName'];
			if ($cat_name == "") {
		  		$cat_name = "main";
	  		}
			$saveto = "./users/$user/gallery/$cat_name/";
			$saveto = $saveto .$filecount. ".jpg";
			move_uploaded_file($_FILES['image']['tmp_name'], $saveto);
			$saveto = $saveto .$filecount . ".jpg";
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

  



echo "<title id = 'user'>$user</title>".
"<meta http-equiv ='Content_Type' content ='text/html; charset =UTF-8'>".
  "  <meta id = 'viewport' name='viewport'". "content ='width=device-width, maiximum-scale". "=1.0, minimum-scale=1.0, initial-scale=1.0'/>".

"</head>".
"<body>";


echo <<<_END

<form method = "POST" enctype="multipart/form-data">
	#Album Name: <input type="text" id = 'catBtn' name="catName"><br>
    # temp: <input type='file' id = 'imageBtn' name='image' size='14'>
    <input type='submit' id= 'uploadBtn' value='Upload' onclick="post();">
</form>

<div id ="result"></div>

<script type="text/javascript">
function post()
{
    var category = $("#catBtn").val();
    $.post("helper.php",{postcat:category},
    function(data){
          var result = data;
		  alert(result);
     });
}
</script>

<div class ="gallery"> 
	 <div class ="title"></div>

     <div class="sorting">
     	  <div class = "container">
		  	   <span>Filter photos by</span>
_END;

$temp_dir ="./users/$user/gallery";
if(!file_exists($temp_dir))
{
	mkdir($temp_dir,0755,true);
}

if(file_exists($temp_dir))
{
		$album_array = array_filter(glob($temp_dir.'/*'), 'is_dir');
		foreach($album_array as $folders)
		{
			$albName = basename($folders).PHP_EOL;
		    $myText = (string)$albName;
			$String = preg_replace('/\s+/', '', $myText);
			echo "<a class ='sortLink' data-keyword='$String' href='#'>$String</a>";
		}
	    echo "<div class ='clear_both'></div>";
		echo"</div></div>";
	    
	  	echo"<div class ='photos'>";
	    echo"<div id ='myDiv' class ='thumbnail_container'></div>";	
}	  
echo <<<_END
      </div>
   </div>
_END;

?>
   </body>
</html>