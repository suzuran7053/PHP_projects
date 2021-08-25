<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()){ redirect("./admin/login.php"); } ?>
<?php

if(empty($_GET["id"])){
    redirect("users.php");
}
$user = User::find_by_id($_GET["id"]);

if($user){
    $user->delete_photo();
    $session->message("The user '$user->username' has been deleted");
    redirect("users.php");
}else{
    redirect("users.php");
}


?>