<?php
$user=$_POST['username']??null;
$email=$_POST['email']??null;
$cemail=$_POST['Cemail']??null;
$pass=$_POST['pass']??null;
$cpass=$_POST['Cpass']??null;
include 'include/library.php';//Data base connection
$errors = array();
$pdo=connectDB();


if(isset($_POST['create'])){


    if(!isset($user) || strlen($user) === 0){ //Cant check if there no username
        $errors['user'] = true;
      }
      else{//They did set a username
    $query= "SELECT * FROM Userbase where username = ?";
    $stmt=$pdo->prepare($query);
    $stmt->execute([$user]);
    $row=$stmt->fetch();
    if($row){//There is another username
        $errors['user'] =true;
    }
    else //Is unique user
    {
     if( !filter_var($email, FILTER_VALIDATE_EMAIL)&&!filter_var($cemail, FILTER_VALIDATE_EMAIL)){ //Check if both emails entered are valid
        if(!strcmp($email,$cemail)){//If email is valid check if both emails are the same
        
            $errors['email'] =true;

        }

        }
    if(!strcmp($pass,$cpass)){//Check if both enter password are the same
    $errors['pass']=true;
    }
    }

    if(count($errors)===0)//No Errors on creating account
    {
        $query="INSERT INTO `jimynguyen`.`Userbase` (`username`, `password`, `email`) VALUES(?,?,?)";
        $password= password_hash($pass,PASSWORD_DEFAULT);
        $stmt=$pdo->prepare($query);
        $stmt->execute([$user],[$password],[$email]);

        //Code to send email
        $to=$email;
        $subject="Account Creation";
        $message="Thank you for creating your account you may now send an email";

        mail($email,$subject,$message);//Send email


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
  </head>


  <body>
      <!-- Form box for login page -->
    <form id ="login" method="post">
    <div> <label for ="username">Enter your Username for login </label> 
    <input type="text" id="username" name="username" size="40"/>
    </div>
    <div>
    <label for="password">Create your Password:</label> 
    <input type="password" id="pass" name="pass" size="40" />
    </div>
    <div>
    <label for="password">Confirm your password </label> 
    <input type="password" id="Cpass" name="Cpass" size="40" />
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

    <div>
            <span class="error <?=!isset($errors['login']) ? 'hidden' : "";?>">Your username or password was invalid</span>
            </div>
    </form>



  </body>