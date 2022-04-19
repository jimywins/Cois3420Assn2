<?php 
session_start();

if ($_SESSION['user']==null){
    header("Location:login.php");
}
else{
//values to be updated stored in variables 
$title=$_SESSION['listtitle']?? null;
$desc= $_SESSION['desc']?? null;
$pswd= $_SESSION['pswd']?? null;
$expiry=$_SESSION['expiry']?? null;
$item=$_SESSION['rowid']; // id of update item

//changed update values (store new  updated values to variables)
$wtitle  = $_POST['title']?? $title;
$wdesc = $_POST['desc']?? $desc;
$wpswd = $_POST['password']?? $pswd;
$wexpiry =$_POST['expiry']?? $item;

if (isset($_POST['update'])){
   // $query = "INSERT into wList values (?,?,?,?,?,null) where username =$user and list_ID =$item "; 
    // $pdo->prepare($query)->execute([$user,$title, $desc, $pswd, $expiry]);
    //$query ="UPDATE wList SET values (?,?,?,?,?,null) where username =$user and list_ID =$item";
    $query ="UPDATE wList SET title = $wtitle, description = $wdesc, passkey =$wpswd, expiry=$wexpiry where  username =$user and list_ID =$item";
    //$pdo->prepare($query)->execute([$user,$title, $desc, $pswd, $expiry]);
    
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
</head>
<header>
<?php include "nav.php";?>

</header>

<body>
 
<h2> Update list information </h2>
<form id="Wish" method="POST" action="<?php htmlentities($_SERVER['PHP_SELF'])?>" enctype="multipart/form-data">
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


    <script>
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");

        togglePassword.addEventListener("click", function () {
            // toggle the type attribute
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            
            // toggle the icon
            this.classList.toggle("fa-eye");
        });

        // prevent form submit
        const form = document.querySelector("form");
        form.addEventListener('submit', function (e) {
            e.preventDefault();
        });
    </script>
</body>

</html>


</body>

<footer>
<!-- (Includes/footer) -->
<div>
</footer>
</html>