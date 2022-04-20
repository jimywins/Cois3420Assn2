<?php 
session_start();
if(!isset($_SESSION['username'])){ //Make sure of login
    header("Location:login.php");
    exit();
}


$title=$_SESSION['listtitle']?? null;
$desc= $_SESSION['desc']?? null;
$pswd= $_SESSION['pswd']?? null;
$expiry=$_SESSION['expiry']?? null;
$item=$_SESSION['rowid']; // id of update item


if (isset($_POST['Update'])){

    $query = "INSERT into wList values (?,?,?,?,?,null) where username =$user and list_ID =$item "; 
     $pdo->prepare($query)->execute([$user,$title, $desc, $hash, $expiry]);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/d634eaee72.js" crossorigin="anonymous"></script>
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
   <textarea name="desc"  cols="17" rows="10" placeholder="Description of items" value="<?=$_SESSION['read_desc']?>"  /> <?=$_SESSION['read_desc']?></textarea>
</div>

<!-- Set visibility for list items for public viewing -->
<div>
   <label for="Password secure"> Password</label>
   <input type="password" id ="password" name="password"   placeholder="password" value="<?=$_SESSION['read_pswd']?>" required /></input>
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
    <button type="Update" name="Update">Update</button>
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