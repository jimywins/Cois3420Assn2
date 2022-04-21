<?php 
session_start();
require_once ("includes/library.php");
$pdo =connectDB();
$user =$_SESSION['user'];

if ($_SESSION['user']==null){
    header("Location:login.php");
}
else{
//values to be updated stored in variables 
$title=$_SESSION['listtitle']?? null;
$desc= $_SESSION['desc']?? null;
$pswd= $_SESSION['pswd']?? null;
$expiry=$_SESSION['expiry']?? null;
$item=$_SESSION['id']; // id of update item

//changed update values (store new  updated values to variables)
$wtitle  = $_POST['title']?? $title;
$wdesc = $_POST['desc']?? $desc;
$wpswd = $_POST['password']?? $pswd;
$wexpiry =$_POST['expiry']?? $item;

if (isset($_POST['update'])){
    
    $pdo =connectDB();  
    $hash = password_hash($wpswd, PASSWORD_DEFAULT); 
    //$query ="UPDATE wList  values (?,?,?,?,?,null) where username ='$user' and list_ID =$item";
    //$pdo->prepare($query)->execute([$wuser,$wtitle, $wdesc, $wpswd, $wexpiry]);

    //update table data
    $query ="UPDATE wList SET title = ?, description = ? , passkey =? , expiry=? where  username ='$user' and list_ID ='$item' ";
    $stmt=$pdo->prepare($query);
    $stmt->execute([$wtitle, $wdesc, $hash , $wexpiry ]);
    header("Location:main.php");
    exit();
    
    
}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/d634eaee72.js" crossorigin="anonymous"></script>
    <script defer src="scripts/master.js"></script>
    <title>Wishlist</title>
    <link rel="stylesheet" href="styles/master.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com/%22%3E">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
</head>
<header>
<?php include "nav.php";?>

</header>

<body>
 
<h2> Update list information </h2>
<form id="update2" method="POST" action="<?php htmlentities($_SERVER['PHP_SELF'])?>" enctype="multipart/form-data">
 <fieldset>
<!-- Set Title for list Item -->
<div>
<div>
    <label for="title">Title </label>
    <input type ="text" name ="title" value="<?=$_SESSION['read_title'] ?>" required /> 
    
</div>

<!-- List Description -->
<div>
   <label for="Description">Desc</label>
   <textarea name="desc"  cols="17" rows="10" placeholder="Description of items"   /> <?=$_SESSION['read_desc']?></textarea>
</div>

<!-- Set visibility for list items for public viewing -->
<div>
   <label for="Password "> Password</label>
   <input type="password" id ="password" name="password"   placeholder="password" value="<?=$_SESSION['pswd']?>" required />
   <i class="fa-solid fa-eye-slash" id="togglePassword"></i>

  

</div>

<!-- Set Expiry for list  -->
<div>
<div>
    <label for=Expiry > Exipiry</label>
    <input type="date" name ="expiry" value="<?=$_SESSION['read_expiry']?>" required />
</div>
 </fieldset>

 <!-- Update information button -->
<div>
 <div id="buttons">
    <button type="update" name="update" id="update">Update</button>
</div>
</form>


   
</body>

</html>


</body>

<footer>
<!-- (Includes/footer) -->
<div>
</footer>
</html>