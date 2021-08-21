<?php 
ob_start();
session_start();  //session TURN ON?>

<?php
session_unset();
header("Location: ../index.php");
?>

