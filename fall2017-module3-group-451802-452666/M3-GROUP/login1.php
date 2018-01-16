<?php
    
    session_start();
    require 'database.php';
    
    $user = $_POST['username'];
    $pwd = $_POST['password'];
    // check the username
    if(mysqli_num_rows(mysqli_query($mysqli, "select username from users where username = '$user'" )) ==0){
        printf(" the username doesn't exists");
       exit;
    }
    // get the password
    $stmt = $mysqli->prepare("select password from users where username = '$user'");
    
        if(!$stmt){
           printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        
        $stmt->execute();
        // Bind the results
        $stmt->bind_result($pwd_hash);
        $stmt->fetch();
        
     //Bind the parameter
     //these code from cse330 wiki
    
    
    //$stmt->execute();    
    
     //Bind the results
    //$stmt->bind_result($pwdhash);
    // check the password
    $hash=password_hash("$pwd", PASSWORD_DEFAULT);
    
        if( !password_verify($_POST['password'], $pwd_hash)){
        
        session_destroy();
        
        header("Location: loginerrorpage.html");
        }
        else{
        
        // Login succeeded!
        $_SESSION['username'] = $user;
        header("LOCATION: login-m3-home-user.php");
        }
    
    
    
?>