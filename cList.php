<?php
session_start();
if(!isset($_SESSION['username'])){//Check if there is a user logged in
    header("Location:login.php");
    exit();
}

$title = $_POST['title']?? null; //add the title to post array
$desc = $_POST['desc']?? null; // add descriptin to post array 
$pswd = $_POST['password']?? null; // add password to post array
$expiry = $_POST['expiry']?? null; //add expiry date to post array 
require_once ("includes/library.php");
$pdo =connectDB();
$user =$_SESSION['username'];
$item=$_SESSION['id']; // id of update item
var_dump($_SESSION['id']);
//Store values in the post array in session variable to use in update information





//if user creates a list
if (isset($_POST['create'])){
    //Initialize functions for List
    $delete =$_POST['delete']?? null;
    $edit=$_POST['edit']?? null;
    $hide=$_POST['hide']?? null;



//validate password (more work needed)
    if(strlen($pswd) < 6){
       // $errors['pswdstrength']= true;
       echo "Please chooses stronger password";
       var_dump(strlen($pswd));
    }

     //Hash password provided by user. Wirte user input to database
     $hash = password_hash($pswd, PASSWORD_DEFAULT); 
     $query = "INSERT into wList values (?,?,?,?,?,null)"; 
     $pdo->prepare($query)->execute([$user,$title, $desc, $hash, $expiry]);

  header("Location:main.php"); //Redirect back to main page to veiw lists 
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


 
<h2> Create a new Wishlist </h2>
<form id="Wish" method="POST" action="<?php htmlentities($_SERVER['PHP_SELF'])?>" enctype="multipart/form-data">
 <fieldset>
<!-- Set Title for list Item -->
<div>
<div>
    <label for="title">Title </label>
    <input type ="text" id="title" name ="title" value="<?=$title?>" required /> 
    
</div>

<!-- List Description -->
<div>
   <label for="Description">Desc</label>
   <textarea name="desc"  cols="17" rows="10" placeholder="Description of items" value="<?=$desc?>" required /> </textarea>
</div>

<!-- Set visibility for list items for public viewing -->
<div>
   <label for="Password secure">Password</label>
   <input type="password" name="password"   placeholder="password" value="<?=$pswd?>" required /></input>
</div>

<!-- Set Expiry for list  -->
<div>
<div>
    <label for=Expiry >Expiry</label>
    <input type="date" name ="expiry" value="<?=$expiry?>" required />
</div>
 </fieldset>

 <!-- Submit data and create List  -->
<div>
 <div id="buttons">
    <button type="create" name="create">Create</button>
</div>

<div>
<input type="hidden" name="htitle" id="hidden" value= "<?php echo $_SESSION['rowid']; ?>" 
</div>
</form>



</body>

<footer>
<!-- (Includes/footer) -->
<div>
</footer>
</html>