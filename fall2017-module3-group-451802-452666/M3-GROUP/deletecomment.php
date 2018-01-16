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
	$comment = $_POST['comment'];
	$username = $_POST['username'];
	//check token value
	if(!hash_equals($_SESSION['token'], $_POST['token'])){
		die("Request forgery detected");
	}
	//delete the comment
	require 'database.php';
	$stmt = $mysqli->prepare("select username, topic, story, comment_number from story where topic='$topic'");
		if(!$stmt){
		printf(" 1st Query Prep Failed: %s\n", $mysqli->error);
		exit;
		}
		
	   
		$stmt->bind_param('s', $topic);
	
		$stmt->execute();
	
		$stmt->bind_result($username1,$topic, $story, $comment_number);
		while($stmt->fetch()){
			printf("<p>Topic: %s</p><br>",htmlspecialchars($topic));
			
			//printf("<p>Comment Number: %s</p><br>",htmlspecialchars($comment_number));
		}
			// check this user has the right to delete and change the story
		
		
		$stmt->close();
	
	
	
			echo $username;
			echo '<br>';
			$stmt1 = $mysqli->prepare("delete from comments where story_topic= '$topic' and comment = '$comment' and username = '$username'");
			if(!$stmt1){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}
			
			$stmt1->bind_param('s', $topic);
	 
			$stmt1->execute();
	 
			$stmt1->close();
			
			echo $_SESSION['comment_number'];
			
			
			
			
			$new_number = (INT)$comment_number  - 1;
			
			$stmt2 = $mysqli->prepare("update story set comment_number = ? WHERE topic= ?");
			if(!$stmt2){
				printf("2 Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}
			 
			$stmt2->bind_param('ss', $new_number, $topic);
			 
			$stmt2->execute();
			 
			$stmt2->close();
			
			
			
			
			
			
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