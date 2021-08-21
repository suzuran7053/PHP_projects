<?php include "header.php" ?>
<?php
if (isset($_POST["register"])) {

    $username = $_POST["username"];
    $username = mysqli_real_escape_string($dbc, $username);
    $query = "SELECT user_name FROM users WHERE user_name='$username'";
    $check_if_name_is_taken_query = mysqli_query($dbc, $query);
    if(mysqli_num_rows($check_if_name_is_taken_query)==0){    
        $email = $_POST["email"];
        $password = $_POST["password"];
        $user_lang_id = $_POST["user_lang"];
        $user_nlang_id = $_POST["user_nlang"];     
        $email = mysqli_real_escape_string($dbc, $email);
        $password = mysqli_real_escape_string($dbc, $password);
        $hash = password_hash($password, PASSWORD_DEFAULT);
    
        $query = "INSERT INTO users (user_name, user_email, user_password, user_lang, user_nlang) ";
        $query .= "VALUES('$username', '$email', '$hash',$user_lang_id,$user_nlang_id)";
        $insert_registration_query = mysqli_query($dbc, $query);
        if (!$insert_registration_query) {
            die("QUERY FAILED" . mysqli_error($dbc));
        } else {
            header("Location: ../signin_success.php");
        }
    }else{
        header("Location: ../signin_error.php");
    }
}
?>

