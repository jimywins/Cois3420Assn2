<?php

session_start();
if(!isset($_SESSION['username'])){//Check if there is a user 
    header("Location:login.php");
    exit();
}
include 'include/library.php';
$NP=$_POST['NP'];
$CP=$_POST['CP'];
$errors = array();
$user=$_SESSION['username'];


if(isset($_POST['submit'])){//Button is set

if(strcmp($NP,$CP)){//IF the 2 are the same contiune otherwise error

$query="UPDATE userbase set passkey = ? where username = ?";
$passkey=password_hash($NP,PASSWORD_DEFAULT);
$stmt=$pdo->prepare($query);
$stmt->execute([$passkey],[$user]); //Updates password

header("Location: login.php");
exit();

}
else
{
$errors['pass']=TRUE;
}
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="styles/master.css" />
    <title>Password Change</title>
    <script defer src="scripts/passchange.js"></script>
    </head>


    <body>

    <form id="PassChange"  method="post">
    
    <div> 
    <label for ="NP">New password </label> 
    <input type="text" id="Np" name="Np" size="40"/>
    </div>
    <div> 
    <label for ="CP">Confrim password </label> 
    <input type="text" id="CP" name="CP" size="40"/>
    </div>
    <div >    
    <button type="submit" name="submit">Submit</button>
    </div>
    <div>
    <span class="error <?=!isset($errors['pass']) ? 'hidden' : "";?>">Your passwords dont match</span>
    </div>
</form>
    </body>