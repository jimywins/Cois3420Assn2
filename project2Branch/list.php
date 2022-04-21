<?php
session_start();
$errors = array();
$title = $_POST['title']?? null; //add the title to post array
$desc = $_POST['desc']?? null; // add descriptin to post array 
$pswd = $_POST['password']?? null; // add password to post array
$expiry = $_POST['expiry']?? null; //add expiry date to post array 
$passerror =false;
$errors = array(); //empty errors array everytimes page loads 
require_once ("includes/library.php");
$pdo =connectDB();
$user =$_SESSION['username'];




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
    $query = "INSERT into List values (null,?,?,?,?)"; 
    $pdo->prepare($query)->execute([ $title, $desc, $hash, $expiry]);
    
     

}

function delete(){
   $row=$_POST['deleteid'];
    $pdo =connectDB();        
    $query=("DELETE from List where list_ID = ?");
    $stmt=$pdo->prepare($query);
    $stmt->execute([$row]);
    
  }

function edit(){

}

  if(isset($_POST['delete'])){
    delete();
  }

?>




<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/d634eaee72.js" crossorigin="anonymous"></script>
    <title>Wishlist</title>
    <link rel="stylesheet" href="master.css" />
</head>
<header>
<!-- (includes/header) -->
<div>
</header>

<body>

<?= "The current lists are\n" ?>
    <div>
    <ul>
    <!-- Query the database to select all lists for display -->
    <?php $stmt=$pdo->query("SELECT list_ID, title, description, expiry FROM List ");
    foreach ($stmt as $row): //loop through result set 

         $id=$pdo->query("SELECT list_ID  FROM List"); ?>
     <li>
         <!--Display data for the list -->
      <?php 
            $_SESSION['rowid'] = $row['list_ID']; // Get the row id for this list 
            
            echo nl2br("Title: ". $row['title']); 
            echo nl2br("\nDescription: ". $row['description']);
            echo nl2br("\nList Expiry Date: ". $row ['expiry']);
            
      
            
      ?>
      <!-- Buttons for  edit and delete -->
    <form id="list" method="POST" action="<?php htmlentities($_SERVER['PHP_SELF'])?>" enctype="multipart/form-data">
    <div>
    <button name="delete"><i class="fa-solid fa-trash"></i></button>
    <button name="edit"><i class="fa-solid fa-edit"></i></button>
    <button name ="hide"><i class="fa-solid fa-eye-slash"></i></i></button>
    <button name="items"><i class="fa-solid fa-list"></i></button>
    <input type="hidden" name="deleteid" id="hidden" value= "<?php echo $_SESSION['rowid']; ?>" 
    </div>
    </form>

    

     </li>
     <?php endforeach; ?>
     
    <ul>
    <div> 
    

<h2> Create a new Wishlist </h2>
<form id="Wish" method="POST" action="<?php htmlentities($_SERVER['PHP_SELF'])?>" enctype="multipart/form-data">
 <fieldset>
<!-- Set Title for list Item -->
<div>
<div>
    <label for="title">Title </label>
    <input type ="text" name ="title" value="<?=$title?>" required /> 
    
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
    <label for=Expiry >Exipiry</label>
    <input type="date" name ="expiry" value="<?=$expiry?>" required />
</div>
 </fieldset>

 <!-- Submit data and create List  -->
<div>
 <div id="buttons">
    <button type="create" name="create">Create</button>
</div>
</form>

</body>

<footer>
<!-- (Includes/footer) -->
<div>
</footer>
</html>