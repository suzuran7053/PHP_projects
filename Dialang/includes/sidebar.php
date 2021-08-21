
<?php include "includes/admin_sidebar.php"; ?>

<!-- SIDEBAR -->
<div class="col-md-2 sideprofile bg-light">

    <div class="text-center bung">
        <div onclick='openMyMenu()' class='open_sidebar_button' style='z-index:1000;'>
            <i class='fas fa-angle-double-right ml-5 openMenu' style='font-size:5em;'></i>
        </div>
        <ul style="margin-top: 90px;">            
            <li>
                <img src="images/<?php echo $_SESSION["user_image"]; ?>" alt="" style="width:120px;" class="img-fluid rounded-circle">
            </li>
            <li>
                <h4 class="bung"><?php echo $_SESSION["user_name"]; ?></h4>
            </li>
            <li>
                <div>
                    <span>★</span><span>Level <?php echo $_SESSION["user_level"]; ?></span>
                    <p class="small ml-3">(last active: 3h ago)</p>
                </div>
            </li>
            <li>
                <div>
                    <?php  //GET HOW MANY POST THE USER MADE
                    if(isset($_SESSION["user_name"])){
                    $user_id = $_SESSION["user_id"];
                    $query = "SELECT * FROM posts WHERE post_author_id=$user_id";
                    $get_user_post_count = mysqli_query($dbc,$query);
                    $post_count = mysqli_num_rows($get_user_post_count);
                    }
                    ?>
                    <i class="fas fa-pencil-alt mr-1"></i><span class="mr-3"><?php echo $post_count; ?></span>
                    
                    <i class="fas fa-check mr-1"></i><span><?php echo $_SESSION["user_made_corrections"]; ?></span>
                </div>
            </li>
            <li>CALENDER HERE</li>
        </ul>
    </div>
</div>