<?php include "includes/header.php" ?>
<?php include "includes/navigation.php" ?>

<?php
alert("This username has already taken. Please try another one.");


if (!isset($_SESSION["user_name"])) { ?>
    <div class="jumbotron jumbotron-fluid" style="background-color: #C1FC4D;">
        <div class="container">
            <div class="row justify-content-around">
                <div class="col-md-5">
                    <h1 class="bung"><span class="display-3">A</span>WESOME<br>INTERACTIVE LANGUAGE<br>LEARNING TOOL</h1>
                    <ul class="mt-4">
                        <li>
                            <h5><i class="far fa-smile mr-2"></i>Completely FREE</h5>
                        </li>
                        <li>
                            <h5><i class="fas fa-rocket mr-2"></i>Study with people all over the world</h5>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h4 class="modal-title">Register</h4>
                    <form action="includes/signin.php" method="post">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input name="username" type="text" class="form-control" placeholder="Enter username">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input name="password" type="password" class="form-control" placeholder="Create a password">
                        </div>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input name="email" type="email" class="form-control" placeholder="Enter your email address">
                        </div>

                        <div class="form-group d-inline-block">
                            <label for="user_lang">Language you want to learn</label>
                            <select name="user_lang" class="form-control" required>
                                <option value="" disabled selected>What language do you want to learn?</option>
                        <?php
                        $query = "SELECT * FROM languages";
                        $select_all_language = mysqli_query($dbc, $query);
                        checkQuery($select_all_language);
                        while($row = mysqli_fetch_assoc($select_all_language)){
                            $la_id = $row["la_id"];
                            $la_name = $row["la_name"];
                        ?>
                                <option value="<?php echo $la_id; ?>"><?php echo $la_name; ?></option>
                        <?php
                        }
                        ?>  </select>
                        </div>

                        <div class="form-group d-inline-block">
                            <label for="user_nlang">Native Language</label>
                            <select name="user_nlang" class="form-control" required>
                                <option value="" disabled selected>What's your native language?</option>
                        <?php
                        $query = "SELECT * FROM languages";
                        $select_all_language = mysqli_query($dbc, $query);
                        checkQuery($select_all_language);
                        while($row = mysqli_fetch_assoc($select_all_language)){
                            $la_id = $row["la_id"];
                            $la_name = $row["la_name"];
                        ?>
                                <option value="<?php echo $la_id; ?>"><?php echo $la_name; ?></option>
                        <?php
                        }
                        ?>  </select>
                        </div>

                        <div class="text-center">
                            <input type="submit" name="register" class="btn btn-dark" value="Register">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>


<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR (col-sm-3) -->
        <?php
        if (isset($_SESSION["user_name"])) {                
           include "includes/admin_sidebar.php";
            echo "   
                <div onclick='openMyMenu()' class='open_sidebar_button'>
                    <i class='fas fa-angle-double-right ml-5' style='font-size:5em;'></i>
                </div>
                <div id='main'>
                ";
        } else {
            echo "
                <div class='col-md-2 sideprofile'>
                    <div class='bg-light text-center bung'>
                        <ul style='margin-top: 70px;'>
                            <li>SOME THING HERE FOR PEOPLE WHO HAVEN'T LOGGED IN</li>
                        </ul>
                    </div>
                </div>
                <div id='main'>";
        }
        ?>

        <!-- CONTENT -->
        <?php  //IF LOGGED IN, CAN JUMP TO ALL PAGES, 
        if (isset($_SESSION["user_name"])) {
            if (isset($_GET["source"])) {
                $source = $_GET["source"];
            } else {
                $source = "";
            }

            switch ($source) {
                case "add_post";
                    include "add_post.php";        //Add Post
                    break;/* 
                case "preview_post";
                    include "preview_post.php";      //投稿前プレビュー
                    break;*/
                case "view_correct_post";
                    include "includes/view_correct_post.php"; //1記事 & 添削ボタン
                    break;
                    /*  case "register";   
                    include "includes/signin.php";
                break; */
                default:
                    include "feed_post.php";         //記事一覧TOP
                    break;
            }
        } else {  // OTHERWISE, REDIRECT TO THE HOME
            include "feed_post.php";
        }
        ?>

        </div>
    </div>
</div>

<?php
// CREATE NEW WORD
if (isset($_POST["add_word"])) {
    $user_id = $_SESSION["user_id"];
    $word_flag_id = $_POST["word_flag_id"];
    $word_name = $_POST["word_name"];
    $word_definition = $_POST["word_definition"];
    $word_memo = $_POST["word_memo"];
    $word_reminder = $_POST["word_reminder"];

    $query = "INSERT INTO ";
    $query .= "words(word_flag_id,word_name,word_definition,word_memo,word_remind,word_user_id) ";
    $query .= "VALUES($word_flag_id,'$word_name','$word_definition','$word_memo',$word_reminder,$user_id)";
    $add_word_query = mysqli_query($dbc, $query);
    checkQuery($add_word_query);
}

// WORDLIST MODAL
if (isset($_SESSION["user_name"])) {
    addWordListModal();

?>
    <div>
        <a href="" class="sticky" data-toggle="modal" data-target="#newWord"><i class="fas fa-plus-circle"></i></a>
    </div>
<?php
}
?>

<?php include "includes/footer.php" ?>