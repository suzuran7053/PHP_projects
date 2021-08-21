<?php  //PUBLISH POST
    if (isset($_POST["publish_post"])) {
        $post_topic = $_POST["post_topic"];
        $post_title = $_POST["post_title"];
        $post_content = $_POST["post_content"];
        $post_ncontent = $_POST["post_ncontent"];
        $post_access = $_POST["optradio"];
        $post_date = date("Y-m-d H:i:s", strtotime($_POST["post_date"]));
        $post_author_id = $_SESSION["user_id"];
        $post_lang = $_SESSION["user_lang"];
        $post_nlang = $_SESSION["user_nlang"];
        if (isset($_FILES["post_image"]["name"])) {
            $post_image = $_FILES["post_image"]["name"];
            $post_image_tmp = $_FILES["post_image"]["tmp_name"];
            move_uploaded_file($post_image_tmp, "./images/$post_image");
        } 
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $query = "INSERT INTO posts(post_topic, post_title, post_content, post_ncontent, post_access, post_date, post_image, post_author_id, post_lang, post_nlang) ";
        $query .= "VALUES('$post_topic', '$post_title', '$post_content', '$post_ncontent', $post_access, '$post_date', '$post_image', $post_author_id,'$post_lang','$post_nlang')";
 
        $publish_post_query = mysqli_query($dbc, $query);
        checkQuery($publish_post_query);
    }
?>
    
    <div class="col-md-10 post-wrapper px-5" style="margin-top: 70px;">
    <!-- CONTENT START -->
    <h2 class="mb-5 display-4 text-center">
        CREATE A NEW POST
    </h2>

    <form method="post" enctype="multipart/form-data" action="">        
        <div class="row">
            <div class="col-md-4 form-group mb-4">
                <select name="post_topic" class="custom-select" required autofocus>
                    <option selected disabled>Select a Category</option>

                    <?php  // GET TOPICS
                    $query = "SELECT topic_name FROM topics";
                    $select_topics_query = mysqli_query($dbc, $query);
                    while ($row = mysqli_fetch_assoc($select_topics_query)) {
                        $topic = $row["topic_name"];
                    ?>
                        <option value="<?php echo $topic; ?>"><?php echo $topic; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 form-group mb-4">
                <label for="post_date">Date</label>
                <?php                
                    $today = date('Y-m-d\TH:i', strtotime("now"));
                ?>
                <input value="<?php echo $today; ?>" class="form-control bg-light border-0" name="post_date" type="datetime-local">
            </div>
        </div>

        <div class="form-group mb-4">
            <label for="post_title">Title</label>
            <input class="form-control bg-light border-0" name="post_title" type="text">
        </div>
        <div class="form-group mb-4">
            <label for="post_content">Content<small class="text-danger"> *</small></label>
            <textarea class="form-control bg-light border-0" name="post_content" row="20" required></textarea>
        </div>
        <div class="form-group mb-4">
            <label for="post_ncontent">Native language version</label>
            <textarea class="form-control bg-light border-0" name="post_ncontent" row="20"></textarea>
        </div>
        <div class="form-group custom-file mb-4">
            <input type="file" class="custom-file-input" name="post_image" id="customFile">
            <label class="custom-file-label" for="post_image">Choose file</label>
        </div>



        <div class="form-group mb-4">
            <label for="post_access">Access<small class="text-danger"> *</small></label>
            <div class="ml-5 d-flex justify-content-between">
                <div class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input" id="public" name="optradio" value="1" checked>
                    <label class="custom-control-label" for="public">Public</label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input" id="all_users" name="optradio" value="2">
                    <label class="custom-control-label" for="all_users">All Users</label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input" id="my_friends" name="optradio" value="3">
                    <label class="custom-control-label" for="my_friends">My Friend</label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input" id="private" name="optradio" value="4">
                    <label class="custom-control-label" for="private">Private</label>
                </div>
            </div>
        </div>


        <div class="text-center">
            <!-- PREVIEW BUTTON
            <input formaction="index.php?source=preview_post" name="preview_post" class="btn btn-light bung mx-3" type="submit" value="Preview">
 -->
            <!-- POST BUTTON -->
            <input name="publish_post" class="btn btn-lg bung mx-3" type="submit" value="Publish" id="post">
        </div>
    </form>
</div>
    
