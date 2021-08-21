<?php

if (isset($_POST["submit"])) {
    $user_name = $_POST["user_name"];
    $user_password = $_POST["user_password"];
    $user_lang = $_POST["user_lang"];
    $user_nlang = $_POST["user_nlang"];
    $user_target = $_POST["user_target"];

    $query = "INSERT INTO users(user_name,user_password,user_lang,user_nlang,user_target) ";
    $query .= "VALUES('$user_name','$user_password',$user_lang,$user_nlang,'$user_target')";
    $add_user_query = mysqli_query($dbc, $query);
    if (!$add_user_query) {
        die("QUERY FAILED" . mysqli_error($dbc));
    }
}

?>

    <form action="" method="post" class="text-white">
        <div class="form-group">
            <label for="user_name">User Name</label>
            <input type="text" name="user_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="user_password">Password</label>
            <input type="password" name="user_password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="user_lang">Learning Language</label>
            <select name="user_lang" class="form-control" required>
                <option value="" disabled selected>What language are you learning?</option>
                <option value="1">English</option>
                <option value="2">Japanese</option>
            </select>
        </div>
        <div class="form-group">
            <label for="user_nlang">Native Language</label>
            <select name="user_nlang" class="form-control" required>
                <option value="" disabled selected>What's your native language?</option>
                <option value="1">English</option>
                <option value="2">Japanese</option>
            </select>
        </div>
        <div class="form-group">
            <label for="user_target">Your Target</label>
            <input type="text" name="user_target" class="form-control" placeholder="e.x. Become a great interpretor!">
        </div>

        <input type="submit" name="submit" value="SIGN UP" class="btn btn-primary">
    </form>
</div>