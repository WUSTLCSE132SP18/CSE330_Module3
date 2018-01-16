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
        background-color:pink;
        padding: 10px;
        width: 100%;
    }
    p#title{
        text-align:left;
        font-family:Times New Roman;
        font-size: 30px;
        font-weight: bold;
        width: 100%;
        background-color:pink;
        padding: 10px;
        
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
        text-align:left;
        font-family:fantasy;
        font-size: 25px;
        font-weight: bold;
        width: 100%;
        background-color:lightgreen;
        padding: 10px;
       
    }
     div#welcome3{
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

<body>
    <div id="welcome">

    <p id=welcomewords>Welcome to the <del>worst</del> <ins>Best</ins> Story Website</p>

    </div>
<?php
    require 'database.php';
    session_start();
    $_SESSION['username']='guest';
    $username=$_SESSION['username'];
    
    // get information of each story
    $stmt = $mysqli->prepare("select username, topic, story, comment_number, story_link from story join link on (story.topic=link.story_topic) order by topic");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
    $stmt->execute();
    echo'<ul>';
    $stmt->bind_result($user, $topic,$story,$comment_number,$storylink);
    
    while($stmt->fetch()){
        // print the information of each story
        printf("<p id=title>Title: %s</p>",htmlspecialchars($topic));
        printf("<p id=welcomewords2>Submiter: %s</p>",htmlspecialchars($user));
        printf("<p id=welcomewords2>Comments Number: %s</p>",htmlspecialchars($comment_number));
        $link = sprintf("storyandcomment.php?topic=%s", $topic);
        echo "<p id =welcomewords3><a href=".$link.">Read the story</a></p></br>";
    }
    echo "</ul>\n";

    $stmt->close();
    echo "<p id =welcomewords3>You are a $username</p></br>";
    
?>
    
    <div id="welcome3">

    <p id=welcomewords3>Register Here!</p>

    </div>
    
    <br>
    <div class="loginpart">   
        <form action="adduser.php" method="POST">
            <label>Creat User:<input type="text" name="username" placeholder="input new username" required></label>
            <label>Password:<input type="text" name="password" placeholder = "input username here" required></label>
            <input type="submit" name="submit" value="Creat">
        </form>
    </p>
    </div>
    <div>
        <blockquote>Please put your Username Above!
        </blockquote>
        <blockquote>Go back to login!<br>
            <form action="logout.php" method="POST">
            <input type="submit" name="logout" value="LOGIN"> 
        </form>
    </div>
</body>
</html>