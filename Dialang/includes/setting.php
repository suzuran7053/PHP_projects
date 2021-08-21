<?php // UPDATE PROFILE
if(isset($_SESSION["user_id"])){
    $user_id = $_SESSION["user_id"];

    if (isset($_POST["edit_profile"])) {
        $user_name = mysqli_real_escape_string($dbc, htmlspecialchars($_POST["user_name"], ENT_QUOTES));
        $user_email = mysqli_real_escape_string($dbc, htmlspecialchars($_POST["user_email"], ENT_QUOTES));

        if(empty($_FILES["user_image"]["name"])){
            $user_image = "./images/user_image_default.jpg";
        }else{
            $user_image = $_FILES["user_image"]["name"];
            $user_image_tmp = $_FILES["user_image"]["tmp_name"];
            move_uploaded_file($user_image_tmp, "./images/$user_image");
        }

        $user_profile = htmlspecialchars($_POST["user_profile"], ENT_QUOTES);
        $user_target = htmlspecialchars($_POST["user_target"], ENT_QUOTES);
        $user_lang_id = $_POST["user_lang"];
        $user_nlang_id = $_POST["user_nlang"];

        /* $user_image = $_FILES["user_image"]["name"];
        $user_image_tmp = $_FILES["user_image"]["tmp_name"];
        move_uploaded_file($user_image_tmp, "./images/$user_image");
        
        if (empty($user_image)) {
            $query = "SELECT user_image FROM users WHERE user_id='$user_id'";
            $get_user_image_query = mysqli_query($dbc, $query);
            while ($row = mysqli_fetch_assoc($get_user_image_query)) {
                $user_image = $row["user_image"];
            }
        } */
        

        $query = "UPDATE users SET ";
        $query .= "user_name = '$user_name', ";
        $query .= "user_image = '$user_image', ";
        $query .= "user_email = '$user_email', ";
        $query .= "user_target = '$user_target', ";
        $query .= "user_profile = '$user_profile', ";
        $query .= "user_lang = '$user_lang_id', ";
        $query .= "user_nlang = '$user_nlang_id' ";
        $query .= "WHERE user_id='$user_id'";

        $update_user_query = mysqli_query($dbc, $query);

        checkQuery($update_user_query);
        if ($update_user_query) {
            alert("Profile has updated!");
            $_SESSION["user_name"] = $user_name;
            $_SESSION["user_email"] = $user_email;
            $_SESSION["user_profile"] = $user_profile;
            $_SESSION["user_image"] = $user_image;
            $_SESSION["user_nlang"] = $user_nlang_id;      
            $_SESSION["user_lang"] = $user_lang_id;
            $_SESSION["user_target"] = $user_target;
        }
    }
}

?>
<div class="col-md-10 mx-auto px-5 mb-5" style="margin-top: 70px;">
    <h1 class="mb-5 display-4">
        Setting<small><i class="ml-2 fas fa-cog"></i></small>
    </h1>

    <div class="container mt-3">
        <!-- TABS -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#profile">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#other_setting">Other Settings</a>
            </li>
        </ul>




        <!-- TAB CONTENT -->
        <div class="tab-content">
            <!-- PROFILE -->
            <?php  // SHOW CURRENT DATA IN THE FORM
            if (isset($_SESSION["user_name"])) {
                $user_id = $_SESSION["user_id"];
                $user_name = $_SESSION["user_name"];
                $user_email = $_SESSION["user_email"];
                $user_profile = $_SESSION["user_profile"];
                $user_target = $_SESSION["user_target"];
                $user_image = $_SESSION["user_image"];
                $user_lang_id = $_SESSION["user_lang"];
                $user_nlang_id = $_SESSION["user_nlang"];
            }
            ?>
            
            <div id="profile" class="container tab-pane active"><br>
                <h3>Edit Profile</h3>
                <p>You can update your profile here!</p>


                <form method="post" enctype="multipart/form-data" action="mypage.php?source=setting">


                    <div class="form-group mb-4">
                        <label for="user_name">Username</label><small class="text-danger"> *</small>
                        <input value="<?php echo $user_name; ?>" class="form-control bg-light border-0" name="user_name" type="text" required>
                    </div>
                    <img src="./images/<?php echo $user_image; ?>" alt="Dialang user <?php echo $user_name; ?>" width="20%" class="my-3 image-fluid">
                    <div class="form-group custom-file mb-4">
                        <input type="file" class="custom-file-input" name="user_image" id="customFile">
                        <label class="custom-file-label" for="user_image">Change Profile Picture</label>
                    </div>
                    <div class="form-group mb-4">
                        <label for="user_email">Email</label><small class="text-danger"> *</small>
                        <input value="<?php echo $user_email; ?>" class="form-control bg-light border-0" name="user_email" type="text" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="user_target">My Target</label>
                        <input value="<?php echo $user_target; ?>" class="form-control bg-light border-0" name="user_target" type="text" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="user_profile">Profile</label>
                        <textarea class="form-control bg-light border-0" name="user_profile" row="20" required><?php echo $user_profile; ?></textarea>
                    </div>

                    <div class="col-md-4 form-group mb-4">
                        <label for="user_lang">Learning Language</label>
                        <select name="user_lang" class="custom-select" multiple required>
                            <?php  // GET LANGUAGES EXCEPT FOR THE SELECTED ONE
                            $query = "SELECT * FROM languages";
                            $select_language_query = mysqli_query($dbc, $query);
                            while ($row = mysqli_fetch_assoc($select_language_query)) {
                                $la_name = $row["la_name"];
                                $la_id = $row["la_id"];
                                if ($row["la_id"] == $user_lang_id) {    //元々選択されていたものはここでselectedでecho
                                    echo "<option value='$la_id' selected>$la_name</option>";
                                } else {    //元々選択されていたもの以外をecho
                                    echo "<option value='$la_id'>$la_name</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4 form-group mb-4">
                        <label for="user_nlang">Native language</label>
                        <select name="user_nlang" class="custom-select" multiple required>
                            <?php  // GET N-LANGUAGES EXCEPT FOR THE SELECTED ONE
                            $query = "SELECT * FROM languages";
                            $select_language_query = mysqli_query($dbc, $query);
                            while ($row = mysqli_fetch_assoc($select_language_query)) {
                                $la_name = $row["la_name"];
                                $la_id = $row["la_id"];
                                if ($row["la_id"] == $user_nlang_id) {
                                    echo "<option value='$la_id' selected>$la_name</option>";
                                } else {
                                    echo "<option value='$la_id'>$la_name</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="text-center">
                        <!-- POST BUTTON -->
                        <input name="edit_profile" class="btn btn-lg bung mx-3" type="submit" value="Submit" id="post">
                    </div>
                </form>


            </div>






            <div id="other_setting" class="container tab-pane fade"><br>
                <h3>Other Settings</h3>
                <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>
        </div>
    </div>