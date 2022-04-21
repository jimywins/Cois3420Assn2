<?php

session_start();

include 'includes/library.php';
$NP=$_POST['NP']?? null;
$CP=$_POST['CP']?? null;
$errors = array();
$user=$_SESSION['username']?? null;
$pdo =connectDB();


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
    <script src="https://kit.fontawesome.com/d634eaee72.js" crossorigin="anonymous"></script>
    <script defer src="scripts/master.js"></script>
    <link rel="stylesheet" href="styles/master.css" />
    <title>Password Change</title>
    </head>


    <body>

    <form id="PassChange"  method="post">
    
    <div> 
    <label for ="NP">New password </label> 
    <input type="password" id="Np" name="Np" size="40"/>
    <i class="fa-solid fa-eye-slash" id="toggleNew"></i>
    </div>
    <div> 
    <label for ="CP">Confrim password </label> 
    <input type="password" id="CP" name="CP" size="40"  />
    <i class="fa-solid fa-eye-slash" id="toggleConfirm"></i>
    
    </div>
    <div >    
    <button type="submit" name="submit">Submit</button>
    </div>
    <div>
    <span class="error <?=!isset($errors['pass']) ? 'hidden' : "";?>">Your passwords dont match</span>
    </div>
</form>
    </body>

