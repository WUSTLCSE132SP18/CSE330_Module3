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
    
     
        </style>
</head>

        <?php
        session_start();
        if(isset($_POST['submit'])){// check the usename 
        if(isset($_POST['username'])){
            $_SESSION['username']=$_POST['username'];
            $username=$_SESSION['username'];
            if( !preg_match('/^[\w_\-]+$/', $username) ){
            echo "Invalid username";
            exit;
                }
            }
        }
        
        if($_SESSION['token'] != $_POST['token']){
                die("Request forgery detected");
        } // use form to pass parameter to next php doc
        // creat new story topic and content
        echo '<form name ="new" action = "new_story.php" method = "POST"><br>';
        echo '<p id=welcomewords2>Story Topic:</p><br>';
        echo '<p id=welcomewords2><input type= "text" name="topic"></p><br>';
        echo '<p id=welcomewords2>Link: <input type="text" name="link"></p><br>';
        echo '<p id=welcomewords2>Story Content:</p><br>';
        echo '<p id=welcomewords2><textarea name = "content" cols="70" rows="20"></textarea></p><br>';
        echo '<input type="hidden" name="token1" value=" '.$_SESSION['token'].'">';
        echo '<input type="hidden" name="username" value="'.$_SESSION['username'].'">';
        echo '<p id=welcomewords2><input type="submit" value="CREATE" class="button"></p><br>';
        echo '</form>';
        ?>
        

        
        
        </body>
        </html>