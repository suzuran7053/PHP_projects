<?php include "includes/header.php" ?>
<?php include "includes/navigation.php" ?>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR (col-sm-3) -->
        <?php
        if(isset($_SESSION["user_name"])){            
           include "includes/admin_sidebar.php";
        }
        echo "   
            <div onclick='openMyMenu()' class='open_sidebar_button' style='z-index:1000;'>
                <i class='fas fa-angle-double-right ml-5 openMenu' style='font-size:5em;'></i>
            </div>
            ";
        ?>

        <!-- CONTENT -->
        <?php
        if (isset($_GET["source"])) {
            $source = $_GET["source"];
        } else {
            $source = "";
        }
        

        switch ($source) {
            
           /*  case "preview_post";
                include "preview_post.php";   //Preview Post
            break;           
            case "friends";
                include "view_my_friends.php";      //My Wordlist
                break; */
            case "view_post";            
                include "includes/view_post.php";     //View Post
            break;
            case "edit_post";            
                include "includes/edit_post.php";     //Edit Post
            break;
            case "wordlist";
                include "includes/wordlist.php";   //Wordlist
            break;   
            case "find_users";
                include "includes/view_all_users.php";   // FIND FRIENDS
            break;
            case "user_detail";
                include "includes/user_detail.php";   // USER DETAILS
            break;
            case "setting";
                include "includes/setting.php";   // SETTING
            break;
            default:                              
                include "includes/myprofile.php";   //MYPROFILE
                break;
        }
        ?>
    </div>
</div>
<?php  // WORDLIST MODAL
    if(isset($_SESSION["user_name"])){
        addWordListModal();           
    ?>
    <div>
        <a href="" class="sticky" data-toggle="modal" data-target="#newWord"><i class="fas fa-plus-circle"></i></a>
    </div>
<?php
}
?>
<?php include "includes/footer.php" ?>