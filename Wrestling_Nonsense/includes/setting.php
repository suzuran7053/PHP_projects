
<?php 
if (isset($_SESSION["user_name"])) {
    $user_id = $_SESSION["user_id"];
    $query = "SELECT * FROM users WHERE user_id = $user_id";
    $get_user_info = mysqli_query($dbc, $query);
    checkQuery($get_user_info);
    while($row = mysqli_fetch_assoc($get_user_info)){
        $user_name = $row["user_name"];
        $user_image = $row["user_image"];  
    }           
}

// UPDATE PROFILE
if (isset($_POST["edit_profile"])) {
    $new_user_name = mysqli_real_escape_string($dbc, htmlspecialchars($_POST["user_name"], ENT_QUOTES));
    if(empty($_FILES["user_image"]["name"])){
        $new_user_image = $user_image;
    }else{
        $new_user_image = $_FILES["user_image"]["name"];
        $user_image_tmp = $_FILES["user_image"]["tmp_name"];
        move_uploaded_file($user_image_tmp, "./images/$new_user_image");
    }                
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $query = "UPDATE users SET ";
    $query .= "user_name = '$new_user_name', ";
    $query .= "user_image = '$new_user_image' ";
    $query .= "WHERE user_id = $user_id";
    $update_user_query = mysqli_query($dbc, $query);

    checkQuery($update_user_query);
    if ($update_user_query) {
        alert("Your profile has updated!");
        $_SESSION["user_name"] = $user_name;
        $_SESSION["user_image"] = $user_image;
    }
    header("Location: index.php?source=setting");
}
?>
<div class="row">
    <div class="col-12 mx-auto px-1 mb-5" style="margin-top: 70px;">
        <h1 class="mb-5 display-4 pl-2">
            Setting<small><i class="ml-2 fas fa-cog"></i></small>
        </h1>

        <div class="container mt-3">
            <!-- TABS -->
            <ul class="nav nav-tabs text-primary">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#profile">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#other_setting">Other Settings</a>
                </li>
            </ul>


            <!-- TAB CONTENT -->
            <div class="tab-content">
                <!-- PROFILE SETTINGS-->
                <div id="profile" class="container tab-pane active"><br> <!--active-->
                    <p>You can update your profile here!</p>
                    <form method="post" enctype="multipart/form-data" action="">
                        <div class="form-group mb-4">
                            <label for="user_name">Username</label><small class="text-danger"> *</small>
                            <input value="<?php echo $user_name; ?>" class="form-control bg-light border-0" name="user_name" type="text" required>
                        </div>       
                        <img src="./images/<?php echo $user_image; ?>" alt="Profile image of <?php echo $user_name; ?>" style="width:150px; height:150px;" class="my-3 image-fluid">
                        <div class="mb-4">
                            <input type="file" name="user_image" id="customFile">
                            <label for="user_image">Change Profile Picture</label>
                        </div>
                        <div class="text-center">
                            <!-- POST BUTTON -->
                            <input name="edit_profile" class="btn btn-primary btn-lg bung mx-3" type="submit" value="Submit" id="post">
                        </div>
                    </form>
                </div>

                <!-- OTHER SETTINGS -->
                <div id="other_setting" class="container tab-pane fade"><br>

                    <div>
                        <h5 class="mb-3">Add a new Category</h5>

                        <?php //ADD CATEGORIES FUNCTION
                                insertCategories();
                                editCategory();
                                deleteCategory();
                                ?>

                            <form action="" method="post">
                                <div class="form-group">
                                    <input type="text" name="cat_title" class="form-control" style="width:65%;" placeholder="Type a category name" required>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="new_cat_submit" class="btn btn-success" value="Add">
                                </div>
                            </form>
                            
                    </div>

                    <div>
                        <h5 class="mb-3">Edit Your Category</h5>
                            <div class="container-fluid">
                                <?php //CREATE CATEGORIES TABLE FUNC                                
                                    createCategoriesTable(); ?>
                            </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>