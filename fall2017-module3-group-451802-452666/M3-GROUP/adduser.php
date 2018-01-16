    <!DOCTYPE html>
    <head>
        <meta charset="utf-8"/>
        <title>Add User </title>
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
    require 'database.php';
    session_start();
    $user = $_POST['username'];
    $password1 = $_POST['password'];
    $options = [
    'cost' => 12 // the default cost is 10
    ];
    // $password_en=crypt($password,$salt);
    $password_new = password_hash($password1,PASSWORD_DEFAULT,$options);
    
    // check the username exists
    if(mysqli_num_rows(mysqli_query($mysqli, "select username from users where username = '$user'" )) ==1){
        printf(" the username already exists");
       exit;
    }
    
    // insert the username
    $stmt = $mysqli->prepare("insert into users (username, password) values ('$user','$password_new')");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    

    $stmt->execute();
    
    $stmt->close();
    echo 'Creat user successfully';

?>
  <blockquote>
    <br>
    Log In here!<br>
                <form action="logout.php" method="POST">
                <input type="submit" name="logout" value="LOG IN"> 
            </form>
                <br>Delete user!<br>
                <form action="deleteuser.php" method="POST">
                <input type="submit" name ="delete" value="DELETE">
                </form>
                
            </blockquote>
        
    </div>
</body>
</html>