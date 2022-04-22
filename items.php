<?php
session_start();

if(!isset($_SESSION['username'])){ //Make sure of login
    header("Location:login.php");
    exit();
}

else{

$title = $_POST['title']?? null; //add the title to post array
$desc = $_POST['desc']?? null; // add descriptin to post array 
$hidden = $_POST['hidden']?? null; // add password to post array
$link  = $_POST['link']?? null;
require_once ("include/library.php");
$pdo =connectDB();  

$row=$_SESSION['id']; // item id from List table 
//get the form values for the current list store in a session variable
$_SESSION['itemtitle'] = $_POST['read_itemtitle']?? null;
$_SESSION['itemlink'] = $_POST['read_itemlink']?? null;
$_SESSION['itemdesc'] = $_POST['read_itemdesc']?? null;
$_SESSION['currentid'] = $_POST['itemid']?? null;


$thisitem = $_SESSION['currentid'] ?? null;// item currently being targeted for delete/ update
$query= "SELECT title, itemlink, description FROM items where list_ID ='$thisitem' ";
$pdo->prepare($query)->execute([$row]);
  

  if(isset($_POST['createI'])){
    $title = $_POST['title']?? null; //add the title to post array
    $desc = $_POST['desc']?? null; // add descriptin to post array 
    $link = $_POST['link']?? null;
    $hidden = $_POST['hidden']?? null; // add password to post array

    // Check that item title does not already exist 
  
    //Insert values into the Items table in database 
    $query = "INSERT into items values ($row,?,?,?,default)"; 
    $pdo->prepare($query)->execute([$title,$link,$desc]);
}

if(isset($_POST['view'])){
//provide all details of selected item 
header("location:viewitem.php");
exit();
}

if(isset($_POST['delete']) ){
    //might need to show javascript pop up
    //$row=$_SESSION['id'];
    $pdo =connectDB();        
    $query=("DELETE from items where list_ID = ? and itemid =$thisitem  ");
    $stmt=$pdo->prepare($query);
    $stmt->execute([$row]);
  }

if(isset($_POST['edit'])){
    header("location:updateitem.php");
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
    <title>WishItems</title>
    <link rel="stylesheet" href="styles/master.css" />
</head>


<body>
<header>
<?php include "nav.php";?>

</header>
<div id="clist">
<h1> List Items</h1>
    
 
<section id="items">
<h3> <?= "The current lists items are\n" ?></h3>
   

    <ul>
    <!-- Query the database to select all lists for display -->
   <?php
    $stmt=$pdo->query("SELECT title, itemlink, description,itemid FROM items where list_ID ='$row' ");
    
    foreach ($stmt as $col): //loop through result set
     $link = $col['itemlink'];
         ?>
    <div class="itemlist">
     <li>
<?php
            $_SESSION['itemid'] = $col['itemid'];
            $_SESSION['itemtitle'] = $col['title']; 
            $_SESSION['itemlink'] = $col['itemlink'];
            $_SESSION['itemdesc'] = $col['description'];
            
            
?>
         <!--Display data for the list -->

    
             <p class="title"> <?php echo nl2br("Title:- ". $col['title']); ?></p>
             <p> <?php echo "\nDescription:- ". $col['description']; ?></p>
             <a href="<?php echo $col['itemlink']?>"> Item link online</a> 
     

    <form id="list" method="POST" action="<?php htmlentities($_SERVER['PHP_SELF'])?>" enctype="multipart/form-data">
    <div>
        <button name="view"> View item  <i class="fa-solid fa-list"></i></button>
        <button name="edit"> Edit item  <i class="fa-solid fa-edit"></i></button>
        <button name="delete"> Delete item  <i class= "fa-solid fa-trash "></i></button>   
    </div>
    <input type="hidden" name="itemid" id="hidden" value= "<?php echo $_SESSION['itemid']; ?>" >
    
    <input type="hidden" name="read_itemtitle" id="hidden" value= "<?php echo $_SESSION['itemtitle']; ?>" >
    <input type="hidden" name="read_itemlink" id="hidden" value= "<?php echo $_SESSION['itemlink']; ?>" >
    <input type="hidden" name="read_itemdesc" id="hidden" value= "<?php echo $_SESSION['itemdesc']; ?>" >

  
    </form>
     </li>



    
</div>
     <?php endforeach; ?>

    </ul>

    </section>

<section class= "createitem">
<h2> Create a new item </h2>
<form id="item" method="POST" action="<?php htmlentities($_SERVER['PHP_SELF'])?>" enctype="multipart/form-data">
 <fieldset>
<!-- Set Title for list Item -->
<div>
<div>
    <label for="title">Title </label>
    <input type ="text" name ="title"  required /> 
    
</div>

<!-- Item Description -->
<div>
   <label for="Description">Desc</label>
   <textarea name="desc"  cols="15" rows="10" placeholder="Description of items"> </textarea>
</div>

<!-- Item Link Online -->
<div>
   <label for="Item Link">Link</label>
   <input type ="text" name="link" />
</div>

<!-- input for file upload-->
<div>
    <label for="file">Item photo:</label> 
    <input type="file" name="file" accept="image/png, image/jpeg">
</div>

<!-- Set visibility for list items for public viewing -->
<div>
  
   <input type="hidden" name="visibility"></input>
</div>

 </fieldset>

 <!-- Submit data and create Item  -->
<div>
 <div id="button">
    <button type="createI" name="createI">Create Item </button>
</div>
</form>
<!----------------------------------------------------------------------------------->
    </section>
    </div>
</body>
</html>