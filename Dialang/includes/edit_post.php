  
<!-- CONTENT START -->
<div class="col-md-10 mx-auto post-wrapper px-5" style="margin-top: 70px;">
    <h2 class="mb-5 display-4 text-center">
        UPDATE POST
    </h2>
    <?php
        deletePost();
    ?>
    <?php  // SHOW CURRENT DATA IN THE FORM
    if(isset($_GET["edit_id"])){
        $edit_id = $_GET["edit_id"];
        
        $query = "SELECT * FROM posts WHERE post_id=$edit_id";
        $select_edit_post = mysqli_query($dbc, $query);
        while ($row = mysqli_fetch_assoc($select_edit_post)){
        $post_topic = $row["post_topic"];
        $post_title = $row["post_title"];
        $post_content = $row["post_content"];
        $post_ncontent = $row["post_ncontent"];
        $post_image = $row["post_image"];
        $post_access = $row["post_access"];
        $post_date = date('Y-m-d\TH:i', strtotime($row["post_date"]));
        }
        //$exampleDate = "2019-08-18 00:00:00";//sql timestamp
        //$newDate = date('Y-m-d\TH:i', strtotime($exampleDate));

    }
    ?>

    <?php // UPDATE POST
    if(isset($_POST["update_post"])){
        $post_title = htmlspecialchars($_POST["post_title"], ENT_QUOTES);
        $post_topic = $_POST["post_topic"];
        $post_content = $_POST["post_content"];
        $post_ncontent = htmlspecialchars($_POST["post_ncontent"], ENT_QUOTES);
        $post_access = $_POST["optradio"];
        $post_date = date("Y-m-d H:i:s", strtotime($_POST["post_date"]));
        $post_image = $_FILES["post_image"]["name"];
        $post_image_tmp = $_FILES["post_image"]["tmp_name"];
        move_uploaded_file($post_image_tmp, "./images/$post_image");
    
        /* if(empty($post_date)){
            $post_date = date("Y-m-d H:i:s");
        } */
        if(empty($post_topic)){
            $query = "SELECT post_topic FROM posts WHERE post_id=$edit_id";
            $get_post_topic_query = mysqli_query($dbc, $query);
            while($row = mysqli_fetch_assoc($get_post_topic_query)){
                $post_topic = $row["post_topic"];
            }
        }
        if(empty($post_image)){
            $query = "SELECT post_image FROM posts WHERE post_id=$edit_id";
            $get_post_image_query = mysqli_query($dbc, $query);
            while($row = mysqli_fetch_assoc($get_post_image_query)){
                $post_image = $row["post_image"];
            }
        }

        $query = "UPDATE posts SET ";
        $query .= "post_title = '$post_title', ";
        $query .= "post_topic = '$post_topic', ";
        $query .= "post_access = '$post_access', ";
        $query .= "post_image = '$post_image', ";
        $query .= "post_content = '$post_content', ";
        $query .= "post_ncontent = '$post_ncontent', ";
        $query .= "post_date = '$post_date', ";
        $query .= "post_last_edit_date = CURRENT_TIMESTAMP ";  //最後はコンマなしにすること！
        $query .= "WHERE post_id=$edit_id";

        $update_post_query = mysqli_query($dbc, $query);

        checkQuery($update_post_query);
        if($update_post_query){
            alert("The post has updated!");
        }        
    }

    ?>

    <form method="post" enctype="multipart/form-data" action="">
        <div class="row">
            <div class="col-md-4 form-group mb-4">
                <label for="post_date">Date</label>
                <input value="<?php echo $post_date; ?>" class="form-control bg-light border-0" name="post_date" type="datetime-local">
            </div>
        </div>
        <div class="row justify-content-between">
            <div class="col-md-4 form-group mb-4">
                <select name="post_topic" class="custom-select">
                    <option value="<?php echo $post_topic; ?>" selected><?php echo $post_topic; ?></option>　<!--元々選択されていたものはここでechoし、selected-->

                    <?php  // GET TOPICS EXCEPT FOR THE SELECTED ONE
                    $query = "SELECT topic_name FROM topics";
                    $select_topics_query = mysqli_query($dbc, $query);
                    while ($row = mysqli_fetch_assoc($select_topics_query)) {
                        if($row["topic_name"] != $post_topic){    //元々選択されていたもの以外をecho
                            $topic = $row["topic_name"];
                    ?>
                            <option value="<?php echo $topic; ?>"><?php echo $topic; ?></option>
                    <?php
                        }
                    }
                    ?>
                    
                </select>
            </div>
            <div class="col-md-2">
                <a onClick=\"javascript: return confirm('Are you sure you want to delete?'); \" href="mypage.php?source=mypage&delete_id=<?php echo $edit_id; ?>" class="text-danger"><i class="mr-1 far fa-trash-alt"></i>Delete Post</a>
            </div>
        </div>
        <div class="form-group mb-4">
            <label for="post_title">Title</label>
            <input value="<?php echo $post_title; ?>" class="form-control bg-light border-0" name="post_title" type="text">
        </div>
        <div class="form-group mb-4">
            <label for="post_content">Content<small class="text-danger"> *</small></label>
            <textarea class="form-control bg-light border-0" name="post_content" row="20" required><?php echo $post_content; ?></textarea>
        </div>
        <div class="form-group mb-4">
            <label for="post_ncontent">Native language version</label>
            <textarea class="form-control bg-light border-0" name="post_ncontent" row="20"><?php echo $post_ncontent; ?></textarea>
        </div>
        <img src="./images/<?php echo $post_image; ?>" alt="an image of <?php echo $post_title; ?>" width="30%" class="my-3 image-fluid">
        <div class="form-group custom-file mb-4">            
            <input type="file" class="custom-file-input" name="post_image" id="customFile">
            <label class="custom-file-label" for="post_image">Choose file</label>
        </div>
        <div class="form-group mb-4">
            <label for="post_access">Access<small class="text-danger"> *</small></label>
            <div class="ml-5 d-flex justify-content-between">
                <div class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input" id="<?php echo $post_access; ?>" name="optradio" value="<?php echo $post_access; ?>" checked>
                    <label class="custom-control-label" for="<?php echo $post_access; ?>"><?php echo $post_access; ?></label>
                </div>
        <?php  // GET NOT SELECTED ACCESS
            $query = "SELECT access_type FROM access WHERE access_type!='$post_access'";
            $select_all_access_query = mysqli_query($dbc, $query);
            while ($row = mysqli_fetch_assoc($select_all_access_query)) {
                $access = $row["access_type"];
                ?>
                <div class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input" id="<?php echo $access; ?>" name="optradio" value="<?php echo $access; ?>">
                    <label class="custom-control-label" for="<?php echo $access; ?>"><?php echo $access; ?></label>
                </div>
                <?php
            }
        ?>        
            </div>
        </div>


        <div class="text-center">
            <!-- PREVIEW BUTTON
            <input formaction="index.php?source=preview_post" name="preview_post" class="btn btn-light bung mx-3" type="submit" value="Preview">
 -->
            <!-- POST BUTTON -->
            <input name="update_post" class="btn btn-lg bung mx-3" type="submit" value="UPDATE" id="post">
        </div>
    </form>
</div>
    
