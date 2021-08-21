<div class="col-md-10 mx-auto post-wrapper px-5" style="margin-top: 70px;">
    

    
    <?php
    if(isset($_GET["p_id"])){
        $p_id = $_GET["p_id"];
        $query = "UPDATE posts SET post_view_count = post_view_count+1 WHERE post_id = $p_id";
        $add_view_count_query = mysqli_query($dbc, $query);
        checkQuery($add_view_count_query);

        $query = "SELECT * FROM posts WHERE post_id=$p_id";
        $select_the_post = mysqli_query($dbc, $query);
        checkQuery($select_the_post);
        while($row = mysqli_fetch_assoc($select_the_post)){
            $post_image = $row["post_image"];
            $post_title = $row["post_title"];
            $post_topic = $row["post_topic"];
            $post_author_id = $row["post_author_id"];
            $post_date = date("Y/n/j D G:i",  strtotime($row["post_date"]));
            $post_content = $row["post_content"];
            $post_ncontent = $row["post_ncontent"];
            $post_likes_count = $row["post_likes_count"];
            $post_view_count = $row["post_view_count"];
            $post_correction_count = $row["post_correction_count"];

            $query = "SELECT * FROM comments WHERE comment_post_id=$p_id";
            $get_comment_count = mysqli_query($dbc, $query);
            $comment_count = mysqli_num_rows($get_comment_count);
        }
        $query = "SELECT * FROM users WHERE user_id=$post_author_id";
        $get_author_data = mysqli_query($dbc, $query);
        checkQuery($get_author_data);
        while($row = mysqli_fetch_assoc($get_author_data)){
        $author_name = $row["user_name"];
        $author_image = $row["user_image"];
        }
    }
    ?>
    
    
    <div class="row justify-content-center">
        <div class="col-md-8" style="border-left: solid #C1FC4D 6px;">
            <h5><?php echo $post_topic; ?></h5>
            <h2 class="bung"><?php echo $post_title; ?></h2>
            <ul>
                <li class="mr-2 d-inline"><i class="far fa-eye mr-1"></i><?php echo $post_view_count; ?></li>
                <li class="mr-2 d-inline"><i class="fas fa-heart mr-1"></i><?php echo $post_likes_count; ?></li>
                <li class="mr-2 d-inline"><i class="far fa-comment mr-1"></i><?php echo $comment_count; ?></li>
                <li class="mr-2 d-inline"><i class="fas fa-check-circle mr-1"></i><?php echo $post_correction_count; ?></li>
            </ul>
        </div>

        <div class="col-md-2">            
            <div class="text-right">
            <a href='mypage.php?source=edit_post&edit_id=<?php echo $p_id; ?>' class='text-info'> Edit</a>
        <a href='mypage.php?source=mypage&delete_id=<?php echo $p_id; ?>' class='text-danger ml-3'><i class='mr-1 far fa-trash-alt'></i></a>
    </div>
            <div>
                <span class="text-right"><i class="fas fa-clock mr-1"></i><?php echo $post_date ?></span>
            </div>
            <div>
                <a href="./mypage.php?source=user_detail&user_id=<?php echo $author_id; ?>">
                    <span>by <?php echo $author_name; ?></span><img class="img-responsive rounded-circle" src="images/<?php echo $author_image; ?>" alt="" style="width: 40px;">
                </a>
            </div>
        </div>
    </div>

    <!-- PICTURE AREA -->
    <div class="my-3 text-center">
        <img class="img-responsive" src="./images/<?php echo $post_image; ?>" alt="" style="width: 40vw;">
    </div>

    
    <article class="text-center pb-3 mb-5">
        <!-- CONTENT AREA -->
        <div class="row justify-content-center">
            <div class="col-sm-5">
                <p><?php echo $post_content; ?></p>
            </div>
            <div class="col-sm-5">
                <p><?php echo $post_ncontent; ?></p>
            </div>
        </div>
    </article>

    <!-- EDIT & DELETE BUTTON-->
    <div class="pr-5 text-right">
        <a href='mypage.php?source=edit_post&edit_id=<?php echo $p_id; ?>' class='text-info'> Edit</a>
        <a href='mypage.php?source=mypage&delete_id=<?php echo $p_id; ?>' class='text-danger ml-3'><i class='mr-1 far fa-trash-alt'></i></a>
    </div>
    

    <h4 class="text-center mt-3">COMMENT</h4>

    <?php //GET COMMENT FOR THIS POST
    $post_id = $_GET["p_id"];
    $query = "SELECT * FROM comments WHERE comment_post_id=$post_id ORDER BY comment_date DESC";
    $get_comment_query = mysqli_query($dbc, $query);
    checkQUery($get_comment_query);
    if (mysqli_num_rows($get_comment_query) == 0) {
        echo "<h2 class='text-center text-info'>NO COMMENT YET</h2>";
    } else {
        while ($row = mysqli_fetch_assoc($get_comment_query)) {
            $comment_content = $row["comment_content"];
            $comment_date = $row["comment_date"];
            $comment_author_id = $row["comment_author_id"];
            $query = "SELECT * FROM users WHERE user_id='$comment_author_id'";
            $select_comment_author_image = mysqli_query($dbc, $query);
            while($row = mysqli_fetch_assoc($select_comment_author_image)){
                $comment_author = $row["user_name"];
                $comment_author_image = $row["user_image"];
                $comment_author_level = $row["user_level"];
            }
            if(isset($_SESSION["user_name"])){  //ログインしてたらユーザープロフィールに飛べる
                $comment_author_link = "./mypage.php?source=user_detail&user_id=$comment_author_id";
            }else{
                $comment_author_link ="";
            }
    ?>

    <div class="row my-4">    
        <div class="col-md-7 mx-auto py-2" style="border-bottom: dotted medium gray;">
            <a href="<?php echo $comment_author_link; ?>">
                <img src="images/<?php echo $comment_author_image; ?>" alt="" width="30px" class="image-fluid rounded-circle"> <!-- COMMENT AUTHOR PIC HERE-->
                <em><?php echo $comment_author; ?></em>
            </a>
            <span class="badge badge-info">Level: <?php echo $comment_author_level; ?></span>
            <small class="float-right"><time><?php echo $comment_date; ?></time></small>
            <p><?php echo $comment_content; ?></p>
            <div class="float-right align-items-center">
                <i class="mx-1 fas fa-angle-down" style="font-size:22px;"></i>
                <span class="mx-1" style="font-size:15px;">1</span>
                <i class="mx-1 fas fa-angle-up" style="font-size:22px;"></i>
                <span class="mx-1" style="font-size:15px;">2</span>
            </div>
        </div>
    </div>

    <?php }
    }
    ?>
</div>






