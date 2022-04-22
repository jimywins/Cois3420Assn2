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
    $witemtitle  = $_POST['title']?? $_SESSION['itemtitle'];
    $witemlink = $_POST['link']?? $_SESSION['itemlink'];
    $witemdesc = $_POST['desc']?? $_SESSION['itemdesc'];
$itempos1= $_SESSION['currentid']; // id of itme currently being targeted

if (isset($_POST['updateitem'])){
    
    $pdo =connectDB();  
    
    //$query ="UPDATE wList  values (?,?,?,?,?,null) where username ='$user' and list_ID =$item";
    //$pdo->prepare($query)->execute([$wuser,$wtitle, $wdesc, $wpswd, $wexpiry]);

    //update table data
    $query ="UPDATE items SET title = ?, itemlink = ?, description = ?   where  itemid ='$itempos1' ";
    $stmt=$pdo->prepare($query);
    $stmt->execute([$witemtitle, $witemlink, $witemdesc ]);
    header("Location:items.php");
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
    <link rel="preconnect" href="https://fonts.googleapis.com/%22%3E">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <title>Wishlist</title>
    <link rel="stylesheet" href="styles/master.css" />
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
    <input type ="text" name ="title" value="<?=$_SESSION['itemtitle'] ?>" required /> 
    
</div>

<!-- Set link for list Item -->
<div>
<div>
    <label for="title">Link </label>
    <input type ="text" name ="link" value="<?=$_SESSION['itemlink'] ?>" required /> 
    
</div>



<!-- item  Description -->
<div>
   <label for="Description">Desc</label>
   <textarea name="desc"  cols="17" rows="10" placeholder="Description of items"   /> <?=$_SESSION['itemdesc']?></textarea>
</div>




 </fieldset>

 <!-- Update information button -->
<div>
 <div id="buttons">
    <button type="update" name="updateitem" id="update">Update item</button>
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