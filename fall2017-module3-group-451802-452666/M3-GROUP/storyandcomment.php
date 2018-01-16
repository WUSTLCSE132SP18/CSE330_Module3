<!DOCTYPE html>
<head>
    <meta charset="utf-8"/>
    <title>Story </title>
    <style type="text/css">
    body{
        /*width: 760px;  how wide to make your web page */
        /*background-color:lightslategray;  what color to make the background */
        margin: 0 auto;
        padding: 0;
        font:12px/16px Verdana, sans-serif; /* default font */
    }
    div#welcome{
        background-color:aquamarine;
        padding: 10px;
        width: 100%;
    }
    div#title{
        border-top: 3px solid black;
        border-bottom: 3px solid black;
        background-color:pink;
        padding: 10px;
        width: 100%;
        padding-top: 50px;
        padding-bottom: 50px;
    }
    p#title{
        border-top: 3px solid red;
        border-bottom: 3px solid red;
        text-align:center;
        font-family:Times New Roman;
        font-size: 30px;
        font-weight: bold;
        width: 100%;
        background-color:pink;
        
        padding-top: 10px;
        padding-bottom: 10px;
        
    }
    p#welcomewords{
        text-align:center;
        font-family:fantasy;
        font-size: 60px;
        font-weight: bold;
        width: 100%;
    }
     div#welcome2{
        background-color:lightgreen;
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
        background-color:yellow;
        
        padding-top: 20px;
        padding-bottom: 20px;
       
    }
    p#welcomewords23{
        text-align:center;
        font-family:fantasy;
        font-size: 40px;
        font-weight: bold;
        width: 100%;
        color: pink;
        padding: 10px;
       
    }
     div#welcome3{
        text-align:center;
        font-size: 40px;
        background-color:lemonchiffon;
        padding: 25px;
        width: 100%;
    }
    p#welcomewords3{
        text-align:center;
        font-family:fantasy;
        font-size: 60px;
        font-weight: bold;
        width: 100%;
    }
    p#welcomewords4{
        text-align:center;
        font-size: 20px;
        font-weight: bold;
        width: 100%;
    }
    .loginpart{
        text-align:center;
        /*border: 2px solid black;*/
        /*position:relative;*/
        /*left: 50%;
        top: 50%;
        right: 50%;
        bottom: 50%;*/
        overflow: auto;
        width: 100%;
        margin: 50px 0px 0px 0px;
        padding-top: 25px;
        padding-bottom: 80px;

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
    //$token = $_SESSION['token'];
    $topic = $_GET['topic'];
    $username_rightnow = $_SESSION['username'];
    require 'database.php';
    // select story info from the table
    $stmt = $mysqli->prepare("select username, topic, story, comment_number from story where topic='$topic'");
    if(!$stmt){
	printf(" 1st Query Prep Failed: %s\n", $mysqli->error);
	exit;
    }
    
   
    $stmt->bind_param('s', $topic);

    $stmt->execute();

    $stmt->bind_result($username,$topic, $story, $comment_number);

    echo "<ul>";
    // print out the information
    while($stmt->fetch()){
        printf("<p id=title>Topic: %s</p><br>",htmlspecialchars($topic));
        printf("<p>Poster: %s</p><br>",htmlspecialchars($username));
        printf("<p>Comment Number: %s</p><br>",htmlspecialchars($comment_number));
        printf("<p id =welcomewords23>Story:</p><br><p><font size =3px> %s</font></p><br>",htmlspecialchars($story));
        // check this user has the right to delete and change the story
        if( $username== $username_rightnow){
            // change story
            echo '<form name="change_story" action = "story_revise.php" method="POST"><br>';
            echo '<p> Change The Story Content: <input type = "text" name = "new_story" placeholder = "input new story here" required></p>';
            echo '<input type="submit" value="Change The Story" class="button">';
            
            
			echo '<input type="hidden" name="topic" value="'.$topic.'">';
            echo '<input type="hidden" name="username" value="'.$_SESSION['username'].'">';
            echo '<input type="hidden" name="token" value="'.$_SESSION['token'].'" />';
			
			echo'</form>';
            echo '<br>';
            
            }
        if( $username== $username_rightnow){    
			// delete the story
            echo '<form name="deletestory" action="deletestory.php" method="POST">';
			echo '<input type="hidden" name="topic" value="'.$topic.'">';
            echo '<input type="hidden" name="username" value="'.$_SESSION['username'].'">';
            echo '<input type="hidden" name="token" value="'.$_SESSION['token'].'" />';
			echo '<input type="submit" value="Delete The Story" class="button">';
			echo'</form>';
        }
    }
    
    $stmt->close();
    echo "<ul>\n";
    // get comment infomation of this story 
    $stmt2 = $mysqli->prepare("select story_topic, comment, username from comments where story_topic = '$topic'");
        if(!$stmt){
    	printf(" comment Query Prep Failed: %s\n", $mysqli->error);
    	exit;
                }
    $stmt2->bind_param('s', $topic); 
    $stmt2->execute();
     
    $stmt2->bind_result($story_topic, $comment, $who_sumbit);
    
    echo "</ul>\n";
    echo '<p id =welcomewords2>Following are the comments of this story</p> <br>';
    while($stmt2->fetch()){
        // print out these comments
        printf("<div id=welcome2>Comment Poster: %s</div><br>",htmlspecialchars($who_sumbit));
        printf("<div id=welcome2>Comment Content: %s</div><br>",htmlspecialchars($comment));
        if($username_rightnow == $who_sumbit){
            // change comments
            echo '<form name="change_comment" action = "comment_revise.php" method="POST"><br>';
            echo '<p> Change The Comment: <input type = "text" name = "new_comment" placeholder = "input new comment here" required></p>';
            echo '<input type="submit" value="Change The Comment" class="button">';
			echo '<input type="hidden" name="topic" value="'.$topic.'">';
            echo '<input type="hidden" name="comment" value="'.$comment.'">';
            echo '<input type="hidden" name="username" value="'.$_SESSION['username'].'">';
            echo '<input type="hidden" name="token" value="'.$_SESSION['token'].'" />';
			
			echo'</form>';
            echo '<br>';
        }
        if($username_rightnow == $who_sumbit){
            //delete the comment
            echo '<form name="deletecomment" action="deletecomment.php" method="POST">';
			echo '<input type="hidden" name="comment" value="'.$comment.'">';
            echo '<input type="hidden" name="topic" value="'.$topic.'">';
            echo '<input type="hidden" name="username" value="'.$_SESSION['username'].'">';
            echo '<input type="hidden" name="token" value="'.$_SESSION['token'].'" />';
			echo '<input type="submit" value="Delete The Comment" class="button">';
			echo'</form>';
        }
    }
    
    echo "</ul>";
    
    
    //$stmt1 = $mysqli->prepare("UPDATE story SET vistime = $vistimeadd WHERE topic= '$topic'");
    //if(!$stmt1){
    //	printf("2nd Query Prep Failed: %s\n", $mysqli->error);
    //	exit;
    // }
     
    //$stmt1->bind_param('ss', $vistimeadd, $topic);
     
    //$stmt1->execute();
 
    // $stmt1->close();
    if($_SESSION['username'] == "guest"){
        // disable guest to add new comment
        echo'<div id=welcome3>Guest can not comment, please login first</div>';
        
        
    }
    else{
        //enable user to add new comment
    echo '<form name="addcomment" action="comment.php" method = "POST">';
    echo '<p id=welcomewords4 >Comment: <input type="text" name="comments"></p><br>';
    echo '<input type="hidden" name="topic" value="'.$topic.' " >';
    echo '<input type="hidden" name="token" value="'.$_SESSION['token'].'" />';
    echo '<input type="hidden" name="commentnumber" value="'.$_SESSION['comment_number'].'" />';
    echo '<p id=welcomewords4 ><input type="submit" name="create" value="Submit Comment"></p>';
    echo '</form>';
    }
    
    echo '<blockquote>Go to the home page!<br>';
    if($_SESSION['username'] == "guest"){
       
        echo '<form action="login-m3-home-visiter.php" method="POST">';
        
    }
    else{
        echo '<form action="login-m3-home-user.php" method="POST">';
    }
    echo '<input type="submit" name="Back" value="Back"> ';
    echo '</form>';
    

?>
    
        

</body>
</html>