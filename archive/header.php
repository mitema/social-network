<?php // Example 26-2: header.php
  session_start();

  require_once 'functions.php';

  $userstr = '[ Guest ]';
  

  if (isset($_SESSION['user']))
  {
    $user     = $_SESSION['user'];
    $loggedin = TRUE;
    $userstr  = " [ $user ]";
    $glbuser = $user;
  }
  else $loggedin = FALSE;


  /* x 
  echo "<title>$appname$userstr</title><link rel='stylesheet' " .
       "href='styles.css' type='text/css'>"                     .
       "</head><body><left><canvas id='logo' width='624' "    .
       "height='96'>$appname</canvas></center>"             .
       "<div class='appname'> # Welcome $userstr</div>"            .
       "<script src='javascript.js'></script>";
   x */

  /* x */

   

    echo <<<_END
    
        <!DOCTYPE html>
        <html>
            <head>
                <title>$appname$userstr</title>
                
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                
                <link rel="stylesheet" href="styles.css" type="text/css">
                <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
                <link rel="stylesheet" href="bootstrap/css/bootstrap-theme.css">
            </head>
            
            <body>
                
                <nav class="navbar navbar-inverse navbar-static-top">
                  <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navMain">
                        <span class="sr-only">Toggle navigation</span>
                      </button>
                      <a class="navbar-brand" href="#">[ P!ng ]</a>
                        
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="navMain">
                      <ul class="nav navbar-nav">
                
                        
                      </ul>
                      
                    </div><!-- /.navbar-collapse -->
                    <br>
                  </div><!-- /.container-fluid -->
                </nav>
              
                
                
                <script src="http://code.jquery.com/jquery-2.1.3.min.js"></script>
                <script src="bootstrap/js/bootstrap.min.js"></script>
                <script src="scripts/jQuery-Autocomplete-master/dist/jquery.autocomplete.min.js"
                <script src="javascript.js"></script>
                <!-- <script src="auto-complete.js"></script> -->
                
                
_END;
  /*  */


  if ($loggedin)
  {
    
      echo <<<_END
      
      <div class="container">
      <nav class="navbar navbar-default navbar-static-top">
                <div class="container-fluid">
                    
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#pngNavbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                      </button>
                        <a class="navbar-brand" href="members.php?view=$user">Profile</a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="pngNavbar">
                      <ul id="navbarMain" class="nav navbar-nav">
                        <li class="navbar-tabs" id="friendsTab"><a href="friends.php">Friends<span class="sr-only">(current)</span></a></li>
                        <li class="navbar-tabs" id="galleryTab"><a href="gallery.php">Gallery</a></li>
                        <li class="navbar-tabs" id="messagesTab"><a href="messages.php">Messages</a></li>
                        <li class="navbar-tabs" id="groupsTab"><a href="groups.php">Groups</a></li>
                      </ul>
                      
                      <form class="navbar-form navbar-right" role="search">
                        <div class="form-group">
                          <input id="autocomplete" type="text" class="form-control" name="currency" placeholder="Search">
                        </div>
                        <button id="searchBTN" type="submit" class="btn btn-default">Submit</button>
                      </form>
                      
                      
                      <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">[ $user ]<span class="caret"></span></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="profile.php">Edit Profile</a></li>
                            <li><a href="members.php">Find Friends</a></li>
                            <li class="divider"></li>
                            <li><a href="logout.php">Log Out</a></li>
                          </ul>
                        </li>
                      </ul>
                      
                    </div><!-- /.navbar-collapse -->
                  </div><!-- /.container-fluid -->
            </nav>
            </div>
            
           
            
       
        
_END;
      
      
  }
  else
  {
    echo ("<br><ul class='menu'>" .
          "<li><a href='index.php'>Home</a></li>"                .
          "<li><a href='signup.php'>Sign up</a></li>"            .
          "<li><a href='login.php'>Log in</a></li></ul><br>"     .
          "<span class='info'>&#8658; You must be logged in to " .
          "view this page.</span><br><br>");
  }
  
  
  //LOAD MYSQUL
  $result = queryMysql("SELECT user FROM profiles");
  $num    = $result->num_rows;
  
  $result2 = queryMysql("SELECT name FROM profiles");
  $num2    = $result2->num_rows;


  $members = array();
  $members2 = array();
    
  for ($j = 0 ; $j < $num ; $j++)
  {
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $row2 = $result2->fetch_array(MYSQLI_ASSOC);
    
    if ($row['user'] == $user) continue;
       
    array_push($members, $row['user']);
	array_push($members2, $row2['name']);
	
  }
  
  
  
  
?>

<script type="text/javascript">
	
	$(function(){
		
		var membersJ = <?php echo '["' . implode('","',$members). '"]' ?>;
		var membersY = <?php echo '["' . implode('","',$members2). '"]' ?>;
		
		//alert(membersJ);
		
		var currencies = [{ value: '', data: '' }];
		
		//alert(currencies);
		for (i = 0; i < membersJ.length; ++i) { 
			//alert(membersJ[i]);
			currencies.push({ value: membersY[i], data: membersJ[i]});
	    
		}
		//alert(currencies);
		
		
		$('#autocomplete').autocomplete({
	    lookup: currencies,
	    onSelect: function (suggestion) { 
		  $.get('members.php?view='+ suggestion.data);
		  
		  window.location.href = "members.php?view=" + suggestion.data;
	      
	    }
	  	});
	  	
	  	$('#searchBTN').on('click', function() {
		  alert("hi");
		  
	  	});
	
	
	});

</script>

