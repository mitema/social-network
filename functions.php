<?php // Example 26-1: functions.php
  $dbhost  = "localhost";    // Unlikely to require changing
  $dbname  = "test";   // Modify these...
  $dbuser  = "mite";   // ...variables according
  $dbpass  = "mite";   // ...to your installation
  $appname = "P!ng"; // ...and preference
  $current_dir = "temp";
  

  $connection = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
 

  function createTable($name, $query)
  {
    queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
    echo "Table '$name' created or already exists.<br>";
  }

  function queryMysql($query)
  {
    global $connection;
    $result = $connection->query($query);
    if (!$result) die($connection->error);
    return $result;
  }

  function destroySession()
  {
    $_SESSION=array();

    #if (session_id() != "" || isset($_COOKIE[session_name()]))
      #setcookie(session_name(), '', time()-2592000, '/');

    session_destroy();
  }

  function sanitizeString($var)
  {
    global $connection;
    $var = strip_tags($var);
    $var = htmlentities($var);
    $var = stripslashes($var);
    return $connection->real_escape_string($var);
  }

  function showProfile($user)
  {
	 
  $desc ='';
	$glbuser = $_SESSION['user'];
	$current_dir = $_SERVER['DOCUMENT_ROOT'];

    if (file_exists("./users/$user/$user.jpg"))
    {
	    
        $temp_path = "./users/$user/$user.jpg";
    }
    
    $temp_path = "./users/$user/$user.jpg";
    
    $result = queryMysql("SELECT * FROM profiles WHERE user='$user'");

    if ($result->num_rows)
    {

      $row = $result->fetch_array(MYSQLI_ASSOC);
      $desc = stripslashes($row['text']);
      /* echo stripslashes($row['text']) . "<br style='clear:left;'><br>"; */
    }
      
      echo <<<_END
         
        <div class="container">
            <div class="jumbotron">
                <h1>Hello, $user!</h1>
                <p>
                	<div class="row">
                        <div class="col-xs-3 col-md-2">
                           
                            <img src=$temp_path style='float:left;'>
                            
                        </div>
                        <div class="col-xs-9 col-md-10">
                            
                            <p>$desc</p>
                            
                        </div>
                    </div> 
                </p>
				
            </div> 

_END;

	if ($glbuser!=$user){
		
		echo <<<_END
		<div class="panel panel-default">
                <div class="panel-body">
                    <ul class="nav nav-pills" role="tablist">
                        <li role="presentation" class="active"><a href="#">Pings <span class="badge">42</span></a></li>
                        <li role="presentation"><a href="messages.php?view=$user">Messages <span class="badge">3</span></a></li>
                        <li role="presentation"><a href="gallery.php?view=$user">Gallery</a></li>
                    </ul>
                </div> 
            </div> 
		</div>	
_END;
		
	} else {
		
		echo "</div>";
		
	}
	
   
	}


    function showGallery($user)
    {
	    $current_dir = $_SERVER['DOCUMENT_ROOT'];
	    $tempDir =  "./users/$user/gallery/main";
        
        
        if (!file_exists($tempDir)) 
        {
        mkdir($tempDir, 0755, true);
        
        }   
        
        if (file_exists($tempDir))
        {
            /*$pic_path = "/ping/users/$user/gallery/test1.jpg";
            $pic_path2 = "/ping/users/$user/gallery/test2.jpg"; */
            
            $picList = scandir($current_dir . "./users/$user/gallery/main", 1);
           
			$picArray = glob($tempDir.'/*.jpg');
			    
        echo <<<_END
            
            <div class="container">
                <div class="panel panel-default">
                    <div class="panel-heading">
                    
                        <button type="button" class="btn btn-default navbar-btn" style="float:right;">
                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span> Upload
                        </button>
                            
                        <h1 class="panel-title">Gallery</h1>
                        
                    </div> 
                    <div class="panel-body">
                            <div class="row">
_END;
			
			foreach(array_chunk($picArray, 2) as $picCHArray) {
				
				echo "<div class='col-xs-12 col-md-4'>";
				
				foreach($picCHArray as $picSet) {
					$path_parts = pathinfo($picSet);
					$picFileName = $path_parts['filename'];
					$newPicPath = "./users/$user/gallery/main/" . $picFileName . ".jpg";
					echo "<a href='#' class='thumbnail'><img src=$newPicPath alt='error'></a>";
					
				}
				echo "</div>";
				
			}

			echo "</div></div>";

            
        } else {
            $noimg_path = "./temp/noimg2.jpg";
           echo <<<_END
            
            <div class="container">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <button id="galUpload" type="button" class="btn btn-default navbar-btn" style="float:right;">
                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span> Upload
                        </button>
                           
                        <h1 class="panel-title">Gallery</h1>
                    </div>
                    <div class="panel-body">
                        
                            <div class="row">
                                <div class="col-xs-12 col-md-4">
                                    <a href="#" class="thumbnail">
                                        <img src=$noimg_path alt="error">
                                    </a>
                                    <a href="#" class="thumbnail">
                                        <img src=$noimg_path alt="error">
                                    </a>
                                </div>

                                <div class="col-xs-6 col-md-4">
                                    <a href="#" class="thumbnail">
                                        <img src=$noimg_path alt="error">
                                    </a>
                                    <a href="#" class="thumbnail">
                                        <img src=$noimg_path alt="error">
                                    </a>
                                </div>

                                <div class="col-xs-6 col-md-4">
                                    <a href="#" class="thumbnail">
                                        <img src=$noimg_path alt="error">
                                    </a>
                                    <a href="#" class="thumbnail">
                                        <img src=$noimg_path alt="error">
                                    </a>
                                </div>
                                
                            </div>
                    </div>
                      
_END;
            
            
        }
        
       
    } 
?>
