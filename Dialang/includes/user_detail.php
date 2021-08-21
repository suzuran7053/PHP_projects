<div class="col-md-10 mx-auto px-5 mb-5 user_detail" style="margin-top: 70px;">

<?php
if(isset($_GET["user_id"])){
    $user_id = $_GET["user_id"];
    $query = "SELECT * FROM users WHERE user_id=$user_id";
    $select_user_detail_query = mysqli_query($dbc, $query);
    while($row = mysqli_fetch_assoc($select_user_detail_query)){
        $user_name = $row["user_name"];
        $user_profile = $row["user_profile"];     
        $user_nlang_id = $row["user_nlang"];
        $user_lang_id = $row["user_lang"];
        $user_target = $row["user_target"];
        $user_image = $row["user_image"];
        $user_level = $row["user_level"];
        $user_posts = $row["user_posts"];
        $user_made_corrections = $row["user_made_corrections"];
        $user_got_corrections = $row["user_got_corrections"];
        $user_last_login = date("Y/n/j D G:i",  strtotime($row["user_last_login"]));
        $user_joined = date("Y/n/j D AG:i",  strtotime($row["user_joined"]));  //なぜか機能しない
    }
}

?>

    <h1 class="mb-5 display-4">
    <?php echo $user_name; ?> 's Profile
    </h1>


    <div class="row align-items-center justify-content-center text-center mb-5">
        <div class="col-md-3">
            <img src="./images/<?php echo $user_image; ?>" alt="" width="90%" class="img-fluid rounded-circle">
        </div>
        <div class="col-md-6">
            <ul>
                <li>
                    <h2 class="bung"><?php echo $user_name; ?></h2>
                </li>
                <li class="mt-2">
                    <b class="mr-5">
                        <i class="pink mr-1 fas fa-award"></i>
                        Level: <?php echo $user_level; ?>
                    </b>
                    <small>Last Login: <?php echo $user_last_login; ?></small>
                </li>

                <li class="mt-3">
                    <h5>My Target: <strong><?php echo $user_target; ?></strong></h5>
                </li>
                <li class="mt-3">Natioinal Language: <em>JAPANESE</em></li>
                <li class="mt-2">Language I'm learning: <em>ENGLISH</em></li>
                <li><small>Joined: <time><?php $user_joined; ?></time></small></li>
            </ul>
        </div>
    </div>
    <div class="row mt-5 justify-content-center text-center">
        <div class="col-sm-3">
        <?php  //GET HOW MANY POST THE USER MADE
            if(isset($_SESSION["user_name"])){
                $query = "SELECT * FROM posts WHERE post_author_id=$user_id";
                $get_user_post_count = mysqli_query($dbc,$query);
                $post_count = mysqli_num_rows($get_user_post_count);
            }
        ?>        
            <div class="bung data"><span><?php echo $post_count; ?></span></div>
            <span>posts</span>
        </div>
        <div class="col-sm-3">
            <div class="bung data"><span><?php echo $user_made_corrections; ?></span></div>
            <span>corrections made</span>
        </div>
        <div class="col-sm-3">
            <div class="bung data"><span><?php echo $user_got_corrections; ?></span></div>
            <span>corrections recieved</span>
        </div>
    </div>

    <div class="row mt-5 text-center">
        <figure class="col-md-12">
            <!-- CALENDER HERE -->
            <img src="./images/calender.png" alt="" width="60%" class="img-fluid">
        </figure>
    </div>


    <!-- THE USER'SLATEST POSTS -->
    <h2 class="bung mt-5"><?php echo $user_name; ?> 's Latest Posts</h2>
    <div class="row justify-content-around">

        <?php  // THE USER'SLATEST POSTS
        getTheUsersLatestPosts();    ?>

    </div>
</div>