<div class="col-md-10 mx-auto post-wrapper px-5" style="margin-top: 70px;">
            <h1 class="mb-5 display-4">
                Members List
            </h1>
    <?php
    $query = "SELECT * FROM users";
    $select_all_users = mysqli_query($dbc, $query);
    checkQuery($select_all_users);
    while ($row = mysqli_fetch_assoc($select_all_users)) {
        $user_id = $row["user_id"];
        $user_name = $row["user_name"];
        $user_nlang_id = $row["user_nlang"];
        $user_lang_id = $row["user_lang"];
        $user_target = $row["user_target"];
        $user_image = $row["user_image"];
        $user_level = $row["user_level"];
        $user_joined = $row["user_joined"];
        $user_profile = $row["user_profile"];

        if (strlen($user_profile) > 150) {
            $user_short_profile = substr($user_profile, 0, 150);
            $user_left_profile = substr($user_profile, 151);
        }
        $query = "SELECT * FROM languages";
        $select_all_langs = mysqli_query($dbc, $query);
        checkQuery($select_all_langs);
        while ($row = mysqli_fetch_assoc($select_all_langs)) {
            if ($user_nlang_id == $row["la_id"]) {
                $user_nlang_name = $row["la_name"];
            }
            if ($user_lang_id == $row["la_id"]) {
                $user_lang_name = $row["la_name"];
            }
        }
    ?>

        <div class="row justify-content-center">
        <a href="./mypage.php?source=user_detail&user_id=<?php echo $user_id; ?>">
            <div class="col-1">
                <img src="./images/<?php echo $user_image; ?>" class="image-fluid rounded-circle" width="60px">
            </div>
            <div class="col-2">
                <h5 class="bung"><?php echo $user_name; ?></h5></a>
                <span style="font-size: 0.8em;"><i class="mr-1 fas fa-globe-asia"></i><?php echo $user_nlang_name; ?></span>
                <span style="font-size: 0.8em;"><i class="mr-1 fas fa-pen"></i><?php echo $user_lang_name; ?></span>
            </div>
            <div class="col-6">
                <p class="mb-0"><?php echo $user_short_profile; ?></p>

                <a href="#more_<?php echo $user_id; ?>_info" class="float-right text-success" data-toggle="collapse">...Read more</a>

                <div id="more_<?php echo $user_id; ?>_info" class="collapse">
                    <?php echo $user_left_profile; //表示しきれなかった分のprofile分を表示?>  
                </div>


            </div>
            <div class="col-2">
                <a href="" class="btn btn dark"><i class="fas fa-user-plus"></i></a>
            </div>
        </div>
        <hr>
    <?php
    }
    ?>
</div>