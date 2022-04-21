<?php
session_start();
require_once ("includes/library.php");
$pdo =connectDB();
$viewUser =  $_GET["user"];
$_SESSION["pvlist"] = $viewUser;
$_SESSION["pvlistitem"] =$_POST["pvlistitem"]??null;

// view items in list 
function viewListItems(){
    header("Location:pvlistItems.php");
    exit();
    
  }
  
  
  //View list items in a list / go to create new list item 
  if(isset($_POST['items'])){
    viewListItems();
    exit();
  }
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/d634eaee72.js" crossorigin="anonymous"></script>
    <script defer src="scripts/master.js"></script>
    <title>Public view of <?php echo $viewUser?>'s List </title>
    <link rel="stylesheet" href="styles/master.css" />
</head>
<header>
<?php include "nav.php";?>
</header>

<h1> Wish List </h1>
<h2> You are viewing : <?php echo $_GET["user"]?>'s WishList  </h2>

<body>


<h3> <?php  echo $_GET["user"]?>  Lists are </h3>
<section class="try"> 
    <ul>
    <!-- Query the database to select all lists for display -->
<?php  $stmt=$pdo->query("SELECT  title, description,passkey, expiry,list_ID, created FROM wList where username = '$viewUser' ");
    
   

 
  foreach ($stmt as $row): // loop through result set  

      $id=$pdo->query("SELECT username  FROM wList"); ?>
  
     <div class="list"><li>
         <!--Display data for the list -->
      <?php 
       //store the row index in a session variable for a particular row 
            $_SESSION['rowid'] = $row['list_ID']; 

       //Display list items for user to see 
            echo nl2br("Title:- ". $row['title']); 
            echo nl2br("\nDescription:- ". $row['description']);
            echo nl2br("\nList Expiry Date:-   ". $row ['expiry']);
            echo nl2br("\nThis list was created on ".$row['created'])
           
      
      ?>
      <!-- Buttons for  edit and delete view and hide  list items  -->
    
    <form id="list" method="POST" action="<?php htmlentities($_SERVER['PHP_SELF'])?>" enctype="multipart/form-data">
    <div>
  
    <button name="items">View Items <i class="fa-solid fa-list"></i></button>
    <input type="hidden" name="pvlistitem" id="hidden" value= "<?php echo $_SESSION['rowid']; ?>" >
    </div>
    </form>

    
    

     </li>
  </div>
     <?php endforeach; ?>
     
    <ul>
  </section>
    
 






</body>

<footer>
<!-- (Includes/footer) -->
<div>
</footer>
</html>