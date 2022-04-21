<?php

include "includes/library.php";

$id= $_GET['id'] ?? null;
$pdo = connectDB();

$statment= $pdo ->prepare("SELECT * FROM item WHERE id=? ");
$statment->execute([$id]);

if($statment->fetch()){//Found something
  $title=$statment['title'];
  $itemlink=$statment['itemlink'];
  $description=$statment['description'];
echo("$title");
echo("$itemlink");
echo("$description");
}
else{//found nothing
    echo "no";
}



exit();
?>