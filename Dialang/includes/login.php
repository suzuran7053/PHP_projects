<?php include "db.php"; ?>
<?php session_start(); ?>


<?php
if(isset($_POST["login"])){
    $username = $_POST["username"];
    $password = $_POST["password"];
    $username = mysqli_real_escape_string($dbc, $username);
    $password = mysqli_real_escape_string($dbc, $password);

    $query = "SELECT * FROM users WHERE user_name ='$username'";
    $get_user_data_query = mysqli_query($dbc, $query);
    if(!$get_user_data_query){
        die("QUERY FAILED" . mysqli_error($dbc));
    }
    
    while($row = mysqli_fetch_assoc($get_user_data_query)){
        if(password_verify($password, $row["user_password"])){
            $db_user_id = $row["user_id"];
            $db_user_name = $row["user_name"];
            $db_user_email = $row["user_email"];
            $db_user_profile = $row["user_profile"];
            $db_user_image = $row["user_image"];
            $db_user_nlang_id = $row["user_nlang"];
            $db_user_lang_id = $row["user_lang"];
            $db_user_target = $row["user_target"];
            $db_user_level = $row["user_level"];
            $db_user_made_corrections = $row["user_made_corrections"];  //いずれ消す
            $db_user_got_corrections = $row["user_got_corrections"];  //いずれ消す
            $db_user_joined = $row["user_joined"];
            $db_user_last_login = $row["user_last_login"];
        }
    }
    

    if(isset($db_user_id)){
        $_SESSION["user_id"] = $db_user_id;
        $_SESSION["user_name"] = $db_user_name;
        $_SESSION["user_email"] = $db_user_email;
        $_SESSION["user_profile"] = $db_user_profile;
        $_SESSION["user_image"] = $db_user_image;
        $_SESSION["user_nlang"] = $db_user_nlang_id;      
        $_SESSION["user_lang"] = $db_user_lang_id;
        $_SESSION["user_target"] = $db_user_target;
        $_SESSION["user_level"] = $db_user_level;
        $_SESSION["user_made_corrections"] = $db_user_made_corrections;  //いずれ消す
        $_SESSION["user_got_corrections"] = $db_user_got_corrections;  //いずれ消す
        $_SESSION["user_joined"] = $db_user_joined;
        $_SESSION["user_last_login"] = $db_user_last_login;
        header("Location: ../mypage.php");
    }else{
        header("Location: ../index.php");
    }
}

?>