<?php
$user=$_POST['username']??null;
$email=$_POST['email']??null;
$_SESSION['username']=$user ?? null;
$errors = array();
include 'includes/library.php';
$pdo =connectDB();    

if(isset($_POST['submit'])){//Button is set
var_dump("we get in here");
    if(!isset($user) || strlen($user) == 0){//Username does exist
        $errors['user'] = true;
      }
      var_dump(filter_var($email, FILTER_VALIDATE_EMAIL));
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){//Checks if email does exist and is valid
        $errors['email'] =true;
    }
    if(count($errors)==0){
        $query= "SELECT * FROM userbase where username = ? AND  email = ? "; 
        $stmt=$pdo->prepare($query);
        $stmt->execute([$user,$email]);
        $row=$stmt->fetch();
        if($row){ //There is something start session allow for password reset
            session_start();
            $_SESSION['user']=$user;
            header("Location: PassChange.php");
        }
        else //Data is incorrect
        {
            $errors["info"]=true;
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
    <title>Forgot Login</title>
</head>

<body>

<form id="forgotF"  method="post">
    <div> 
    <label for ="username">Username </label> 
    <input type="text" id="user" name="username" value="<?php $user ?>" size="40"/>
    <span class="error <?=!isset($errors['user']) ? 'hidden' : "";?>">please input a valid username</span>
    </div>
    <div> 
    <label for ="email">Email </label> 
    <input type="text" id="email" name="email" size="40"/>
    <span class="error <?=!isset($errors['email']) ? 'hidden' : "";?>">please input a valid email</span>
    </div>
    <div >    
    <button type="submit" name="submit">Submit</button>
    </div>
    <div>
    <span class="error <?=!isset($errors['info']) ? 'hidden' : "";?>">Your infomation is incorrect</span>
    </div>
</form>

</body>
    
    </html>