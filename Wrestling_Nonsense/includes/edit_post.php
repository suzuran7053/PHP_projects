<?php
if(isset($_SESSION["user_id"])){
    $user_id = $_SESSION["user_id"];
}else{
    redirect("index.php");
}

if (isset($_GET["source"]) && $_GET["source"]="edit_post") {
    $post_id = $_GET["edit_post_id"];

    // GET THE EDITING POST DATA
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $query = "SELECT * FROM posts WHERE post_id = $post_id";
    $get_this_post_query = mysqli_query($dbc, $query);
    while ($row = mysqli_fetch_assoc($get_this_post_query)) {
        $post_title = $row["post_title"];
        $post_cat_id = $row["post_category_id"];
        $post_date = date("Y-m-d", strtotime($row["post_date"]));
        $post_content = $row["post_content"];
        $post_image = $row["post_image"];
    }
    checkQuery($get_this_post_query);
   

    //UPDATE POST
    if (isset($_POST["upload_post"])) {
        $post_cat_id = $_POST["post_topic"];
        
        if(isset($_POST["post_title"])){ $post_title = mysqli_real_escape_string($dbc, $_POST["post_title"]); }
        if(isset($_POST["post_content"])){ $post_content = mysqli_real_escape_string($dbc, $_POST["post_content"]); }
        if(isset($_POST["post_date"])){ $post_date = $_POST["post_date"]; }
        if(!isset($_POST["post_title"])){ $post_title = $post_title; }
        if(!isset($_POST["post_content"])){ $post_content = $post_content; }
        if(!isset($_POST["post_date"])){ $post_date = $post_date; }
        
        $post_image = $_FILES["post_image"]["name"];
        $post_image_tmp = $_FILES["post_image"]["tmp_name"];
        move_uploaded_file($post_image_tmp, "./images/$post_image");

        if(empty($post_image)){  //もし画像を更新されなかったばあい、もともとの画像をそのまま保存する方法（元の画像を引き出してもう一度保存）
            $query = "SELECT post_image FROM posts WHERE post_id=$post_id";
            $select_image_query = mysqli_query($dbc, $query); 
            while($row = mysqli_fetch_assoc($select_image_query))
            $post_image = $row["post_image"];
        }
        
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $query = "UPDATE posts SET ";
        $query .= "post_category_id = $post_cat_id, post_title = '$post_title', ";
        $query .= "post_content = '$post_content', post_date = '$post_date', ";
        $query .= "post_image = '$post_image' ";
        $query .= "WHERE post_author_id = $user_id AND post_id = $post_id";

        $edit_post_query = mysqli_query($dbc, $query);
        checkQuery($edit_post_query);
        redirect("index.php?source=view_post&post_id=$post_id");
        
    }
}
?>
    
<div class="col-md-12 post-wrapper px-5" style="padding-top: 70px;">
    <!-- CONTENT START -->
    <h2 class="mb-5 display-4 text-center">
        EDIT A POST
    </h2>

    <form method="post" enctype="multipart/form-data" action="">        
        <div class="row">
            <div class="col-md-4 form-group mb-4">
                <select name="post_topic" class="custom-select" required autofocus>

                    <?php                                    
                    // 1. GET THE SELECTED TOPIC
                    $query = "SELECT * FROM categories WHERE cat_id = $post_cat_id";
                    $select_the_topics_query = mysqli_query($dbc, $query);
                    while ($row = mysqli_fetch_assoc($select_the_topics_query)) {
                        $cat_title = $row["cat_title"];
                        $cat_id = $row["cat_id"];
                    ?>
                        <option value="<?php echo $cat_id; ?>" selected><?php echo $cat_title; ?></option>
                    <?php
                    }
                    // 2. GET OTHER TOPICS
                    $query = "SELECT * FROM categories WHERE cat_id != $post_cat_id";
                    $select_the_topics_query = mysqli_query($dbc, $query);
                    while ($row = mysqli_fetch_assoc($select_the_topics_query)) {
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
            <div class="col-md-4 form-group mb-4">
                <label for="post_date">Date</label><small class="text-danger"> *</small>
                <input value="<?php echo $post_date; ?>" class="form-control bg-light border-0" name="post_date" type="date">
            </div>
        </div>

        <div class="form-group mb-4">
            <label for="post_title">Title</label><small class="text-danger"> *</small>
            <input class="form-control bg-light border-0" name="post_title" type="text" placeholder="<?php echo $post_title; ?>" value="<?php echo $post_title; ?>">
        </div>
        <div class="form-group mb-4">
            <label for="post_content">Content<small class="text-danger"> *</small></label>
            <textarea class="form-control bg-light border-0" name="post_content" row="20" required><?php echo $post_content; ?></textarea>
        </div>
        <div class="mb-4">
            <image class="d-block mb-2" src="./images/<?php echo $post_image; ?>" alt="">
            <input type="file" name="post_image" id="customFile">
        </div>


        <div class="text-center">
            <input name="upload_post" class="btn btn-primary btn-lg bung m-3" type="submit" value="Submit" id="post">
        </div>
    </form>
</div>
    
