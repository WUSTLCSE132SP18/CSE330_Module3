<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
    <title>Change Password </title>
    <style type="text/css">
        div#welcome{
        background-color:aquamarine;
        padding: 10px;
        width: 100%;
    }
    
     p#welcomewords2{
        border-top: 3px solid black;
        border-bottom: 3px solid black;
        text-align:center;
        font-family:fantasy;
        font-size: 25px;
        font-weight: bold;
        width: 100%;
        background-color:lightgreen;
        
        padding-top: 20px;
        padding-bottom: 20px;
       
    }
	blockquote{
        border-top: 3px solid black;
        border-bottom: 3px solid black;
        font-family: Georgia, 'Times New Roman', Times, serif;
        font-size: 125%;
        font-style: italic;
        text-align:center;
        padding-top: 50px;
        padding-bottom: 50px;
    }
    
     
        </style>
</head>

	<?php
	session_start();
	if (!isset($_SESSION['username'])) {
	session_destroy();
	header("Location: loginerrorpage.html");
	exit;
	}
	
	
	//check token
	
	if(!hash_equals($_SESSION['token'], $_POST['token'])){
		die("Request forgery detected");
	}
	
	require 'database.php';
	//get varibles
	
	$username2 = $_POST['username'];
	$password3 = $_POST['new_password'];
	$options = [
    'cost' => 12 // the default cost is 10
    ];
    // $password_en=crypt($password,$salt);
    $password_new = password_hash($password3,PASSWORD_DEFAULT,$options);
	
	// change password
	$stmt2= $mysqli->prepare("update users set password= '$password_new' WHERE username = '$username2' ");
	if(!$stmt2){
		printf("32Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	
	 
	$stmt2->execute();
	 
	$stmt2->close();
	?>
	<blockquote>Go back to the story!<br>
						<form action="login-m3-home-user.php" method="POST">
						
						<input type="hidden" name="username" value="<?php echo $_SESSION['username'];?>" />
						<input type="submit" name="Back" value="Back"> 
					</form>





</body>
</html>