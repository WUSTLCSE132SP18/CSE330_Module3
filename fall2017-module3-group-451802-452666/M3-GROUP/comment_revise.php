<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
    <title>Share A Story </title>
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
	$topic = $_POST['topic'];
	$new_comment = $_POST['new_comment'];
	$username = $_POST['username'];
	$old_comment = $_POST['comment'];
	// change comment
	$stmt2= $mysqli->prepare("update comments set comment= '$new_comment' WHERE story_topic='$topic' and comment = '$old_comment' and username = '$username' ");
	if(!$stmt2){
		printf("Query Prep Failed: %s\n", $mysqli->error);
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