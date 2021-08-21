<?php session_start(); ?>

<?php
    session_unset();
    /* $_SESSION["user_id"] = null;
    $_SESSION["user_name"] = null;
    $_SESSION["user_firstname"] = null;
    $_SESSION["user_lastname"] = null;
    $_SESSION["user_profile"] = null;
    $_SESSION["user_image"] = null;
    $_SESSION["user_nlang"] = null;      
    $_SESSION["user_lang"] = null;
    $_SESSION["user_target"] = null;
    $_SESSION["user_level"] = null;
    $_SESSION["user_joined "] = null;
    $_SESSION["user_last_login"] = null; */
    header("Location: ../index.php");
?>