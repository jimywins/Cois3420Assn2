<?php
session_start();
$user=$_POST['username']??null;
$password=$_POST['password']??null;
include 'includes/library.php';//Data base connection
$errors = array();
$pdo=connectDB();
$_SESSION['user'] = $user;
 $_SESSION['pswd'] = $password ??null;  //- to auto fill uhhashed password in update field? 



if(isset($_POST['Forgot'])) //Redirects to forgot php page
{
 header("Location:forgot.php");
}
if(isset($_POST['login']))
{
 //Check if username does exist

 if(!isset($user) || strlen($user) == 0){
    $errors['login'] = true;
  }
  else
  {
    $query= "SELECT username, passkey, email FROM userbase where username =?";
    $stmt=$pdo->prepare($query);
  $stmt->execute([$user]);
  $row=$stmt->fetch();
  if(!$row){ //Returns nothing
    $errors['login'] =true;
    
  }
  else //There is a unique user name
  {
    if(password_verify($password,$row['passkey'])){
        session_start();
        $_SESSION['username']=$user;
        header("Location:main.php"); //Redirect to Homepage
      }
      else{
        $errors['login'] =true;
        
      }
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
    <title>Login</title>
    <script defer src="scripts/login.js"></script>
  </head>


  <body>
  <section id="loginform">
      <!-- Form box for login page -->
    <form id ="login" method="post">
    <div> <label for ="username">Username </label> 
    <input type="text" id="username" name="username" size="40"/>
    
    </div>
    <div>
    <label for="password">Password:</label> 
    <input type="password" id="password" name="password" size="40" />
    
    </div>
    </div>
    <div id="login'">    
    <button type="submit" name="login">Login</button>
    </div>
    </div>
    <div id="login'">    
    <button type="submit" name="Forgot">Forgot Login details</button>
    </div>
    <div>
            <span class="error <?=!isset($errors['login']) ? 'hidden' : "";?>">Your username or password was invalid</span>
            </div>
    </form>
</section >


  </body>