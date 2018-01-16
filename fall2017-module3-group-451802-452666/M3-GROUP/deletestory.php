<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
    <title>Delete A Story </title>
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
	
	$topic = $_POST['topic'];
	//check token 
	if(!hash_equals($_SESSION['token'], $_POST['token'])){
		die("Request forgery detected");
	}
	// delete the story
	require 'database.php';
			echo'13';
			$stmt1 = $mysqli->prepare("delete from story where topic= ?");
			if(!$stmt1){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}
			
			$stmt1->bind_param('s', $topic);
	 
			$stmt1->execute();
	 
			$stmt1->close();
			echo'23';
			// delete story link from table link 
			$stmt2 = $mysqli->prepare("delete from link where story_topic= ?");
			if(!$stmt2){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}
			
			$stmt2->bind_param('s', $topic);
	 
			$stmt2->execute();
	 
			$stmt2->close();
			echo'333';
			// delete story comments from table comments
			$stmt3 = $mysqli->prepare("delete from comments where story_topic= ?");
			if(!$stmt3){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}
			
			$stmt3->bind_param('s', $topic);
	 
			$stmt3->execute();
	 
			$stmt3->close();
			
			echo'3';
			
			echo 'Delete successed';
			echo '<br>';
	
	?>
<blockquote>Go back to the stories!<br>
						<form action="login-m3-home-user.php" method="POST">
						
						<input type="hidden" name="username" value="<?php echo $_SESSION['username'];?>" />
						<input type="submit" name="Back" value="Back"> 
					</form>





</body>
</html>