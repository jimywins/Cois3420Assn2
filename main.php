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
$user =$_SESSION['user'];

//get the form values for the current list store in a session variable
$_SESSION['id'] = $_POST['listid']?? null;
$_SESSION['read_title'] = $_POST['read_title']?? null;
$_SESSION['read_pswd'] = $_POST['read_pswd']?? null;
$_SESSION['read_desc'] = $_POST['read_desc']?? null;
$_SESSION['read_expiry'] = $_POST['read_expiry']?? null;
$errors = array();

//delete list item 
function delete(){
   $row=$_POST['listid'];
    $pdo =connectDB();        
    $query=("DELETE from wList where list_ID = ?");
    $stmt=$pdo->prepare($query);
    $stmt->execute([$row]);
    
  }

  //edit list item
function edit(){
  header("Location:update.php");
  exit();
}

// view items in list 
function viewListItems(){
  header("Location:items.php");
  exit();
  
}



//Delete a list form display 
  if(isset($_POST['delete'])){
    delete();
  }

//View list items in a list / go to create new list item 
if(isset($_POST['items'])){
  viewListItems();

}

//Create a new list 
if(isset($_POST['createNew'])){
  header("Location:cList.php"); //Redirect to create List page 
  exit();
}

//edit list information
if (isset($_POST['edit'])){
  //request password -- // if password matches allow edit 
  $_SESSION['title'] = $_POST['title'];
  $_SESSION['title'] = $_POST['title'];
  header("Location:update.php");
  
  exit();
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

<h1> Wish List </h1>
<h2> Welcome : <?php echo $user ?> </h2>
<body>

<form id="create" method="POST"  enctype="multipart/form-data">
 <button type="create" name="createNew">Create new wishlist </button>
</form>


<h3> <?= "The current lists are\n" ?></h3>
    
    <ul>
    <!-- Query the database to select all lists for display -->
<?php  $stmt=$pdo->query("SELECT  title, description,passkey, expiry,list_ID FROM wList where username = '$user' ");
    
   

 
  foreach ($stmt as $row): // loop through result set  

      $id=$pdo->query("SELECT username  FROM wList"); ?>
  
     <div class="list"><li>
         <!--Display data for the list -->
      <?php 

      //Get values for table columns and store in session variables 
            $_SESSION['rowid'] = $row['list_ID']; 
            $_SESSION['data1'] = $row['title']; 
            $_SESSION['data2'] = $row['passkey'];
            $_SESSION['data3'] = $row['description'];
            $_SESSION['data4'] = $row['expiry'];
            

           


       //Display list items for user to see 
            echo nl2br("Title:- ". $row['title']); 
            echo nl2br("\nDescription:- ". $row['description']);
            echo nl2br("\nList Expiry Date:-   ". $row ['expiry']);
           
      
      ?>
      <!-- Buttons for  edit and delete view and hide  list items  -->
    
    <form id="list" method="POST" action="<?php htmlentities($_SERVER['PHP_SELF'])?>" enctype="multipart/form-data">
    <div>
    <button name="delete" value= "<?php echo $_SESSION['delete']; ?>"> Delete List  <i class= "fa-solid fa-trash "></i></button>

    <button name="edit"> Edit List  <i class="fa-solid fa-edit"></i></button>
  
    <button name ="hide">Hide List  <i class="fa-solid fa-eye-slash"></i></i></button>
    
    <button name="items">View Items <i class="fa-solid fa-list"></i></button>
    
    <input type="hidden" name="listid" id="hidden" value= "<?php echo $_SESSION['rowid']; ?>" >

    <input type="hidden" name="read_title" id="hidden" value= "<?php echo $_SESSION['data1']; ?>" >

    <input type="hidden" name="read_pswd" id="hidden" value= "<?php echo $_SESSION['data2']; ?>" >

    <input type="hidden" name="read_desc" id="hidden" value= "<?php echo $_SESSION['data3']; ?>" >

    <input type="hidden" name="read_expiry" id="hidden" value= " $_SESSION['data4']" >
    </div>
    </form>
<?php
    
?>
    
    

     </li>
  </div>
     <?php endforeach; ?>
     
    <ul>
    
    
 






</body>

<footer>
<!-- (Includes/footer) -->
<div>
</footer>
</html>
