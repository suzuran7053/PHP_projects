<?php

// THIS IS A SAFETY PRICAUTION. IN CASE WE FORGET TO INCLUDE FILES THAT HAVE CLASS DECLARED
// AUTOMATICALLY LOAD A CLASS THAT IS NOT INCLUDED(=UNDECLARED CLASS)
// This is going to be scanning our application and looking for undeclared objects in "index.php"
// If the class 'User' is undecleared, it's going to catch it and pass it in as a parameter
function classAutoLoader($class){
    $class = strtolower($class); // Lowercase or Uppercase, whatever you select
    $the_path = "includes/{$class}.php";  // We need to go out of this directory as this function will look through in index.php
    
    if(is_file($the_path) && !class_exists($class)){
        require_once($the_path);
    }else{
        die("File name '{$class}.php' was not found");
    }
}
spl_autoload_register('classAutoLoader');


function redirect($location){
    header("Location: $location");
}

function alert($message) {
    echo "<script type='text/javascript'>alert('$message');</script>";
}
?>