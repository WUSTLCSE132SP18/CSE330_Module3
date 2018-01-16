<!DOCTYPE html>
<head>
    <meta charset="utf-8"/>
    <title>Story </title>
    <style type="text/css">
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
        
        
        $username = $_SESSION['username'];
        
        if(!hash_equals($_SESSION['token'], $_POST['token'])){ // check token
                die("Request forgery detected");
        }
        
        $topic = $_POST['topic']; // get topic 
        $comments = $_POST['comments']; // get comments
        
        
        
        require 'database.php';
		$stmt = $mysqli->prepare("select username, topic, story, comment_number from story where topic='$topic'");
		if(!$stmt){
		printf(" 1st Query Prep Failed: %s\n", $mysqli->error);
		exit;
		}
		
	   
		$stmt->bind_param('s', $topic);
	
		$stmt->execute();
	
		$stmt->bind_result($username1,$topic, $story, $comment_number);
	
		echo "<ul>";
		// print out the information
		while($stmt->fetch()){
			printf("<p>Topic: %s</p><br>",htmlspecialchars($topic));
			
			//printf("<p>Comment Number: %s</p><br>",htmlspecialchars($comment_number));
		}
			// check this user has the right to delete and change the story
		
		$stmt->close();
		
		
		
		
		
		
        // insert data into table
        $stmt1 = $mysqli->prepare("insert into comments (story_topic, comment, username) values ('$topic', '$comments', '$username')");
        if(!$stmt1){
			printf("0 Query Prep Failed: %s\n", $mysqli->error);
			exit;
			}
         
        $stmt1->bind_param('sss', $topic, $comments, $username);
        $stmt1->execute();
 
        $stmt1->close();
		
		
		
		
		$new_number = (INT)$comment_number  + 1;
		
		$stmt2 = $mysqli->prepare("update story set comment_number = ? WHERE topic= ?");
		if(!$stmt2){
			printf("2 Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
		 
		$stmt2->bind_param('ss', $new_number, $topic);
		 
		$stmt2->execute();
		 
		$stmt2->close();
		
		
		
		
        echo 'Submitted<br> ';
		echo $story_topic;
		

?>
				<blockquote>Go back to the story!<br>  <!--go back to the home-->
                    <form action="login-m3-home-user.php" method="POST">
                    <input type="submit" name="Back" value="Back"> 
                </form>
</body>
</html>