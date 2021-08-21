<?php
/* $p_id =$_GET['p_id'];
header("Location: index.php?source=view_correct_post&p_id=$p_id"); */
?>
<!-- CONTENT START -->
<div class="col-md-10 post-wrapper px-5" style="margin-top: 70px;">

    <?php
    if (isset($_GET["p_id"])) {
        $p_id = $_GET["p_id"];
        $query = "UPDATE posts SET post_view_count = post_view_count+1 WHERE post_id = $p_id";
        $add_view_count_query = mysqli_query($dbc, $query);
        checkQuery($add_view_count_query);


        $query = "SELECT * FROM posts WHERE post_id=$p_id";
        $select_the_post = mysqli_query($dbc, $query);
        checkQuery($select_the_post);
        while ($row = mysqli_fetch_assoc($select_the_post)) {
            $post_image = $row["post_image"];
            $post_title = $row["post_title"];
            $post_topic = $row["post_topic"];
            $post_date = $row["post_date"];
            $post_content = $row["post_content"];
            $post_ncontent = $row["post_ncontent"];
            $post_likes_count = $row["post_likes_count"];
            $post_view_count = $row["post_view_count"];
            $post_correction_count = $row["post_correction_count"];
            $post_author_id =  $row["post_author_id"];
        }
        $query = "SELECT * FROM comments WHERE comment_post_id=$p_id";
        $get_comment_count = mysqli_query($dbc, $query);
        $comment_count = mysqli_num_rows($get_comment_count);

        $query = "SELECT * FROM users WHERE user_id=$post_author_id";
        $get_author_image = mysqli_query($dbc, $query);
        checkQuery($get_author_image);

        while($row = mysqli_fetch_assoc($get_author_image)){
            $author_id = $row["user_id"];
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
                <li class="mr-2"><i class="far fa-eye mr-1"></i><?php echo $post_view_count; ?></li>
                <li class="mr-2"><i class="fas fa-heart mr-1"></i><?php echo $post_likes_count; ?></li>
                <li class="mr-2"><i class="far fa-comment mr-1"></i><?php echo $comment_count; ?></li>
                <li class="mr-2"><i class="fas fa-check-circle mr-1"></i><?php echo $post_correction_count; ?></li>
            </ul>
        </div>

        <div class="col-md-3">
            <div>
                <i class="fas fa-clock mr-1"></i><span>Posted on: <time><?php echo $post_date; ?></time></span>
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
        <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="" style="width: 40vw;">
    </div>


    <article class="text-center">
        <!-- CONTENT AREA -->
        <div class="row justify-content-center">
            <div class="col-md-5">
                <p><?php echo $post_content; ?></p>
            </div>
            <div class="col-md-5">
                <p><?php echo $post_ncontent; ?></p>
            </div>
        </div>
        <hr class="post_hr">
    </article>

    <!-- CORRECT BUTTON -->
    <div class="row">
        <a href="" class="btn btn-lg bung mx-auto my-3" id="post">Correct This Post</a>
    </div>

    <!-- LIKE BUTTON AREA -->
    <div class="row justify-content-center mt-5">
        <div class="mx-3 text-center" id="like">
            <span class="d-block">Like this!</span>           
            <i class="my-2  text-danger" style="font-size:21px;"></i>
        </div>
    </div>

    <?php
    // COMMENT
    $user_id = $_SESSION["user_id"];
    if (isset($_POST["comment"])) {
        $comment_post_id = $_GET["p_id"];
        $comment_content = $_POST["comment_content"];
        $query = "INSERT INTO comments(comment_post_id,comment_content,comment_date,comment_author_id) ";
        $query .= "VALUES($comment_post_id, '$comment_content', CURRENT_TIMESTAMP, '$user_id')";
        $comment_query = mysqli_query($dbc, $query);
        checkQUery($comment_query);
        //unset($_POST["comment"]);
        //header("Location: "));


        // +1 post_comment_count
        $query = "UPDATE posts SET post_comment_count=post_comment_count+1 WHERE post_id=$comment_post_id";
        $add_count_comment_query = mysqli_query($dbc, $query);
        checkQUery($add_count_comment_query);
        
    }
    ?>

    <!-- COMMENT AREA -->
    <div class="row justify-content-center">
        <form action="" method="post" class="col-md-8 mt-5 p-4 bg-light rounded border">
            <div class="form-group">
                <textarea class="form-control" name="comment_content" placeholder="Leave a Comment"></textarea>
            </div>
            <input type="submit" class="btn btn-dark float-right mt-3" name="comment" value="COMMENT">
        </form>
    </div>


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
                $comment_author_name = $row["user_name"];
                $comment_author_image = $row["user_image"];
                $comment_author_level = $row["user_level"];
            }

            if(isset($_SESSION["user_name"])){  //ログインしてたらユーザープロフィールに飛べる
                $comment_author_link = "./mypage.php?source=user_detail&user_id=$comment_author_id";
            }else{
                $comment_author_link ="";
            }

    ?>
            <div class="row my-2">
                <div class="col-md-7 mx-auto">
                    <a href="<?php echo $comment_author_link; ?>">
                        <img src="images/<?php echo $comment_author_image; ?>" alt="" width="30px" class="image-fluid rounded-circle"> <!-- COMMENT AUTHOR PIC HERE-->
                        <em><?php echo $comment_author_name; ?></em>
                    </a>
                    <span class="badge badge-info">Level: <?php echo $comment_author_level; ?></span>
                    <small class="float-right"><time><?php echo $comment_date; ?></time></small>
                    <p><?php echo $comment_content; ?></p>
                    <div class="float-right align-items-center">
                        <i class="fas fa-angle-down" style="font-size:22px;"></i>
                        <span class="ml-1" style="font-size:15px;">1</span>
                        <i class="ml-3 fas fa-angle-up" style="font-size:22px;"></i>
                        <span class="ml-1" style="font-size:15px;">2</span>
                    </div>
                </div>
            </div>
            <hr class="col-md-7 mx-auto">

    <?php }
    }
    ?>

</div>