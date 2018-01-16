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
            
            if(!hash_equals($_SESSION['token'], $_POST['token'])){
                    die("Request forgery detected");
            }
            
            $topic = $_POST['topic'];
            $content = $_POST['content'];
            $link = $_POST['link'];
            
    
    
            
            
            require 'database.php';
            // create new story & link in link table
            $stmt1 = $mysqli->prepare("insert into link (story_topic, story_link) values ('$topic', '$link')");
            if(!$stmt1){
                printf("11st Query Prep Failed: %s\n", $mysqli->error);
                exit;
                }
                // check whether the story exist or not 
            if(mysqli_num_rows(mysqli_query($mysqli, "select topic from story where topic = '$topic'" )) !=0){
            printf(" the TOPIC ALREADY exists");
            echo '<blockquote>Go to the home page!<br>';
            echo '<form action="login-m3-home-user.php" method="POST">';
            echo '<input type="submit" name="Back" value="Back"> ';
            echo '</form>';
            exit;
            }
            // check whether the link exist or not
            if(mysqli_num_rows(mysqli_query($mysqli, "select story_link from link where story_link = '$link'" )) !=0){
            printf(" the LINK ALREADY exists");
            echo '<blockquote>Go to the home page!<br>';
            echo '<form action="login-m3-home-user.php" method="POST">';
            echo '<input type="submit" name="Back" value="Back"> ';
            echo '</form>';
            exit;
            }
            $stmt1->bind_param('ss', $topic, $link);
            $stmt1->execute();
     
            $stmt1->close();
            // insert new story in story table
            $stmt2 = $mysqli->prepare("insert into story (username, topic, story) values ('$username', '$topic','$content')");
            if(!$stmt2){
                printf("2st Query Prep Failed: %s\n", $mysqli->error);
                exit;
                }
           
            $stmt2->bind_param('sss', $username, $topic,$content);
            $stmt2->execute();
     
            $stmt2->close();
            
            echo 'Submitted<br> ';
            echo $topic. $username;
            
            
    ?>
    <blockquote>Go back to the story!<br>
                    <form action="login-m3-home-user.php" method="POST">
                    <input type="hidden" name="username" value="<?php echo $_SESSION['username'];?>" />
                    <input type="submit" name="Back" value="Back"> 
                </form>
</body>
</html>