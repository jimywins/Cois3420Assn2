<?php

$user=$_POST['username']??null;
$email=$_POST['Email']??null;
$cemail=$_POST['CEmail']??null;
$pass=$_POST['pass']??null;
$cpass=$_POST['cpass']??null;
include 'include/library.php';//Data base connection
$errors = array();
$pdo=connectDB();


if(isset($_POST['create'])){


    if(!isset($user) || (strlen($user) == 0) ) { //Cant register if theres  no username
        $errors['user'] = true;
        echo(1);
      }
      else{//They did set a username
    $query= "SELECT * FROM userbase where username = ?";
    $stmt=$pdo->prepare($query);
    $stmt->execute([$user]);
    $row=$stmt->fetch();
    if($row){//There is another username
        $errors['user'] =true;
        echo(2);
        header("Location:login.php");
    }
    else //Is unique user
    {
     if( !filter_var($email, FILTER_VALIDATE_EMAIL) && !filter_var($cemail, FILTER_VALIDATE_EMAIL)){ //Check if both emails entered are valid
        if(!strcmp($email,$cemail)){//If email is valid check if both emails are the same
        
            $errors['email'] =true;
            echo(3);

        }

        }
    if($pass !== $cpass){//Check if both enter password are the same
    $errors['pass']=true; 
    
    }
    }

    if(count($errors)===0)//No Errors on creating account
    {
        session_start();
        $_SESSION['username'] =$user;
        $query="INSERT INTO userbase  VALUES(?,?,?)";
        $password= password_hash($pass,PASSWORD_DEFAULT);
        $stmt=$pdo->prepare($query);
        $stmt->execute([$user, $password, $email]);

        //Code to send email
        $to=$email;
        $subject="Account Creation";
        $message="Thank you for creating your account you may now send an email";

        header("Location:main.php"); //redirect to main page 
exit();
   
    }

    }

}


?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="styles/master.css" />
    <script defer src="scripts/master.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <title>Register</title>
  </head>





  <body>
  <header>
    <?php include "nav.php";?>
  </header>
  <div id="register">
      <!-- Form box for login page -->
      <h1>Register</h1>
    <form id ="login" method="post" action="<?php htmlentities($_SERVER['PHP_SELF'])?>" enctype="multipart/form-data">
    <div> <label for ="username">Enter your Username for login </label> 
    <input type="text" id="username" name="username" size="40"/>
    </div>
    <div>
    <label for="password">Create your Password:</label> 
    <input type="password" id="pass" name="pass" size="40" />
    </div>
    <div>
    <label for="password">Confirm your password </label> 
    <input type="password" id="Cpass" name="cpass" size="40" />
    </div>
    <div>
    <label for="Email">Enter your email address </label> 
    <input type="Email" id="Email" name="Email" size="40" />
    </div>
    <div>
    <label for="Email">Confirm your email address </label> 
    <input type="Email" id="CEmail" name="CEmail" size="40" />
    </div>
    
    <div id="login'">    
    <button type="submit" name="create">Create Account</button>
    </div>
    </div>

    



  </body>

  </html>