<?php
session_start();


if(!isset($_SESSION['username'])){ //Checks if user is login otherwise redirect to login page

  header("Location:login.php");
  exit();
}

$errors = array();
$title = $_POST['title']?? null; //add the title to post array
$desc = $_POST['desc']?? null; // add descriptin to post array 
$pswd = $_POST['password']?? null; // add password to post array
$expiry = $_POST['expiry']?? null; //add expiry date to post array 
$passerror =false; //password error 
$errors = array(); //empty errors array everytimes page loads 
require_once ("includes/library.php");
$pdo =connectDB();
$user =$_SESSION['user']; //store user data in session variable 
$url = 'https://loki.trentu.ca/~phillipgrummett/3420/project/publicList.php?user=$user'; //url variable for sharing link 
$hidelist = array();

//get the form values for the current list store in a session variable
$_SESSION['id'] = $_POST['listid']?? null;
$_SESSION['read_title'] = $_POST['read_title']?? null;
$_SESSION['read_pswd'] = $_POST['read_pswd']?? null;
$_SESSION['read_desc'] = $_POST['read_desc']?? null;
$_SESSION['read_expiry'] = $_POST['read_expiry']?? null;

$hidelist = $_SESSION['id'];

$errors = array();


//hide list item
function hide(){
  $row=$_POST['listid'];
  $pdo =connectDB();    
  $query=("UPDATE from wList SET visable='FALSE' where list_ID = ? ");//Update code to make it visable or not and not deleting entry
  $stmt=$pdo->prepare($query);
}



//delete list item 
function delete(){
   $row=$_POST['listid'];
    $pdo =connectDB();        
    $query=("DELETE from wList where list_ID = ? ");
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
if(isset($_POST['hide']) ){

 hide();
}

//Delete a list form display 
  if(isset($_POST['delete']) ){

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
    <script defer src="scripts/master.js"></script>
   
    <title>Wishlist</title>
    <link rel="stylesheet" href="styles/master.css" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    
</head>
<header>
<?php include "nav.php";?>
</header>

<h1> Wish List </h1>
<h2> Welcome : <?php echo $user ?> </h2>

<p>Share your wishlist with friends and family  <button  id="url" value="https://loki.trentu.ca/~johnuja/3420/project/pvList.php?user=<?php echo $user?>" >Share your wishlist </button> <p> or copy from: <span>https://loki.trentu.ca/~johnuja/3420/project/pvList.php?user=<?php echo $user?></span>


<body>

<form id="create" method="POST"  enctype="multipart/form-data">
 <button type="create" name="createNew">Create new wishlist </button>
</form>


<h3> <?=  "The current lists are\n" ?></h3>

    <ul class="listitems">
    <!-- Query the database to select all lists for display -->
<?php 

//if (!isset($_POST['hide'])){
$stmt =$pdo->query("SELECT  title, description,passkey, expiry,list_ID, created FROM wList where username = '$user' ");

    
//}
//else 
//$stmt =$pdo->query("SELECT  title, description,passkey, expiry,list_ID, created FROM wList where username = '$user' and list_ID != '$hidelist'  ");
   

 
  foreach ($stmt as $row): // loop through result set  

     // $id=$pdo->query("SELECT username  FROM wList");
      ?>
  
     <div class="list"><li>
         <!--Display data for the list -->
      <?php 

      //Get values for table columns and store in session variables 
            $_SESSION['rowid'] = $row['list_ID']; 
            $_SESSION['data1'] = $row['title']; 
            $_SESSION['data2'] = $row['passkey'];
            $_SESSION['data3'] = $row['description'];
            $_SESSION['data4'] = $row['expiry'];
            // date created not included becuase we dont want the user to be able to update that 
            ?> 

           


       <!-- Display list items for user to see -->

<p class="title"> <?php echo  "Title:- ". $row['title'];  ?></p>
       <p> <?php echo "Description:- ". $row['description'];?> </p>
       <p> <?php "List Expiry Date:-   ". $row ['expiry'];  ?></p>
       <p> <?php echo "This list was created on ".$row['created'] ?></P>



      
    
      <!-- Buttons for  edit and delete view and hide  list items  -->
    
    <form id="list" method="POST" action="<?php htmlentities($_SERVER['PHP_SELF'])?>" enctype="multipart/form-data">
    <section class="ui">
    <button name="delete" id="dltb"> Delete List  <i class= "fa-solid fa-trash "></i></button>

    <button name="edit"> Edit List  <i class="fa-solid fa-edit"></i></button>
    
    <button name="items">View Items <i class="fa-solid fa-list"></i></button>
    
    <input type="hidden" name="listid" id="hidden" value= "<?php echo $_SESSION['rowid']; ?>" >

    <input type="hidden" name="read_title" id="hidden" value= "<?php echo $_SESSION['data1']; ?>" >

    <input type="hidden" name="read_pswd" id="hidden" value= "<?php echo $_SESSION['data2']; ?>" >

    <input type="hidden" name="read_desc" id="hidden" value= "<?php echo $_SESSION['data3']; ?>" >

    <input type="hidden" name="read_expiry" id="hidden" value= "<?php $_SESSION['data4']; ?>" >
  </section>
    </form>
    <button name ="hide" id="hide">Hide List  <i class="fa-solid fa-eye-slash"></i></i></button>

    
    

     </li>
  </div>
     <?php endforeach; ?>
     
    <ul>
  
    
 






</body>

<footer>
<!-- (Includes/footer) -->
<div>
</footer>


