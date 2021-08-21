<?php  //PUBLISH POST
if(isset($_SESSION["user_id"])){
    $post_author_id = $_SESSION["user_id"];
}else{
    $_SESSION["message"] = "Sorry, you need to login to use this feature!";
    redirect("./index.php");
}
if (isset($_POST["publish_post"])) {
    $post_cat_id = $_POST["post_topic"];
    $post_title = mysqli_real_escape_string($dbc, $_POST["post_title"]);
    $post_content = mysqli_real_escape_string($dbc, $_POST["post_content"]);
    $post_date = date("Y-m-d"); 
    
    
    if (isset($_FILES["post_image"]["name"])){
        $post_image = $_FILES["post_image"]["name"];
        $post_image_tmp = $_FILES["post_image"]["tmp_name"];
        move_uploaded_file($post_image_tmp, "./images/$post_image");
    }
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $query = "INSERT INTO ";
    $query .= "posts(post_category_id, post_title, post_content, post_date, post_image, post_author_id) ";
    $query .= "VALUES($post_cat_id, '$post_title', '$post_content', '$post_date', '$post_image', $post_author_id)";

    $publish_post_query = mysqli_query($dbc, $query);
    checkQuery($publish_post_query);
    $post_id = mysqli_insert_id($dbc);
    header("Location: index.php?source=view_post&post_id=$post_id");
}
?>

<div class="row">                
    <div class="col-10 post-wrapper mx-auto" style="margin-top: 70px;">
        <!-- CONTENT START -->
        <h2 class="mb-5 display-4 text-center">
            CREATE A NEW POST
        </h2>

        <form method="post" enctype="multipart/form-data" action="">
            <div class="row">
                <div class="col-md-4 form-group">
                    <select name="post_topic" class="custom-select" required autofocus>
                        <option selected disabled>Select a Category</option>

                        <?php  // GET TOPICS
                        $query = "SELECT * FROM categories";
                        $select_topics_query = mysqli_query($dbc, $query);
                        while ($row = mysqli_fetch_assoc($select_topics_query)) {
                            $cat_title = $row["cat_title"];
                            $cat_id = $row["cat_id"];
                        ?>
                            <option value="<?php echo $cat_id; ?>"><?php echo $cat_title; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="post_date">Date</label><small class="text-danger"> *</small>
                    <?php
                        $today = date("Y-m-d");
                    ?>                    
                    <input value="<?php echo $today; ?>" class="form-control bg-light border-0" name="post_date" type="date">
                </div>
            </div>

            <div class="form-group mb-4">
                <label for="post_title">Title</label><small class="text-danger"> *</small>
                <input class="form-control bg-light border-0" name="post_title" type="text">
            </div>
            <div class="form-group mb-4">
                <label for="post_content">Content<small class="text-danger"> *</small></label>
                <textarea class="form-control bg-light border-0" name="post_content" row="20" required></textarea>
            </div>
            
            <div class="mb-4">
                <input type="file" name="post_image" id="customFile">
            </div>

            <div class="text-center mb-5">
                <input name="publish_post" class="btn btn-primary btn-lg bung" type="submit" value="Publish" id="post">
            </div>
        </form>
    </div>

</div>
    
