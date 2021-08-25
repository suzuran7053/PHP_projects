<?php
require_once("init.php"); 

$user = new User();
if(isset($_POST["filename"])){
    $user->ajax_save_user_image($_POST["filename"], $_POST["user_id"]);
};

if(isset($_POST["photo_id"])){ //ここに書いた内容がdataとしてhtml内に反映される模様
    Photo::display_sidebar_data($_POST["photo_id"]);
};



?>