<?php //COMMON USE FUNCTIONS
function checkQuery($queryName){
    global $dbc;
    if(!$queryName){
        die("QUERY FAILED" . mysqli_error($dbc));
    }
}

function alert($message){
    echo "<script type='text/javascript'>alert('$message');</script>";
}

function redirect($location){
    return header("Location: $location");
    exit;
}

function addWordListModal(){
    $self = $_SERVER["PHP_SELF"];
    echo "
    <div class='modal fade' id='newWord'>
        <div class='modal-dialog modal-dialog-centered'>
            <div class='modal-content new_word_modal'>
                <div class='modal-header'>
                    <h4 class='modal-title'>Add A New Word</h4>
                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                </div>
                <div class='modal-body'>
                    <form class='form-horizontal p-3' method='post' action='$self'>
                        <div class='form-group'>
                            <label class='radio-inline'><input value='1' type='radio' name='word_flag' checked>No flag</label>
                            <label class='radio-inline'><input value='2' type='radio' name='word_flag'><i class='fas fa-check'></i></label>
                            <label class='radio-inline'><input value='3' type='radio' name='word_flag'><i class='fas fa-times'></i></label>
                            <label class='radio-inline'><input value='4' type='radio' name='word_flag'><i class='fas fa-exclamation-circle'></i></label>
                        </div>
                        <div class='form-group'>
                            <label for='word_name' class='d-inlinecontrol-label'>Word<small class='text-danger'> *</small></label>
                            <div class='col-sm-12'>
                                <input name='word_name' type='text' class='form-control' placeholder='Enter a word' required>
                            </div>
                        </div>
                        <div class='form-group'>
                            <label for='word_definition' class='control-label'>Definition<small class='text-danger'> *</small></label>
                            <div class='col-sm-12'>
                                <input name='word_definition' type='text' class='form-control' placeholder='Enter the definition' required>
                            </div>
                        </div>

                        <div class='form-group'>
                            <label for='word_memo' class='control-label'>Memo</label>
                            <div class='col-sm-12'>
                                <input name='word_memo' type='text' class='form-control' placeholder='Write additional information if you like'>
                            </div>
                        </div>
                        <div class='form-group'>
                            <label for='word_remind' class='control-label'><i class='mr-1 fas fa-bullhorn'></i>Reminder</label>
                            <div class='col-sm-3'>
                                <input name='word_remind' type='number' class='form-control' min='1' max='365'>days time
                            </div>
                        </div>
                        <div class='text-center'>
                            <input class='btn purple' type='submit' value='Create' name='add_word'>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>";
}

function insertNewWord(){
    global $dbc;
    if(isset($_POST["add_word"])){            
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
}
?>


<?php  // INDEX
function getLatestPosts(){
    global $dbc;
    if(!isset($_SESSION["user_name"])){  //ログインしてない人(Public)
        $query = "SELECT * FROM posts WHERE post_access=1 ORDER BY post_id DESC LIMIT 16";
    }else if(isset($_SESSION["user_name"])){  //ログインしてる人( + All Users)
        $query = "SELECT * FROM posts WHERE post_access=1 OR post_access=2 ORDER BY post_id DESC LIMIT 16";
    }
    
    $select_latest_posts = mysqli_query($dbc, $query);
    while($row = mysqli_fetch_assoc($select_latest_posts)){
        $post_id = $row["post_id"];
        $post_image = $row["post_image"];
        $post_title = $row["post_title"];
        $post_date = date("Y/n/j D AG:i",  strtotime($row["post_date"]));
        $post_content = substr($row["post_content"], 0, 100) . "...";
        $post_likes_count = $row["post_likes_count"];
        $post_correction_count = $row["post_correction_count"]; 

        $post_author_id =  $row["post_author_id"];
        $query = "SELECT * FROM users WHERE user_id=$post_author_id";
        $get_author_data = mysqli_query($dbc, $query);
        checkQuery($get_author_data);
        while($row = mysqli_fetch_assoc($get_author_data)){
            $author_name = $row["user_name"];
            $author_image = $row["user_image"];
        }

        if(isset($_SESSION["user_name"])){  //ログインしてたらユーザープロフィールに飛べる
            $author_link = "
            <a href='./mypage.php?source=user_detail&user_id=$post_author_id' class='d-block'>
                <img src='./images/$author_image' alt='' width='25px' class='mr-1 image-fluid rounded-circle'>
                <span>$author_name</span>
            </a>";
        }else{
            $author_link ="
            <a href='' class='d-block'>
                <img src='./images/$author_image' alt='' width='25px' class='mr-1 image-fluid rounded-circle'>
                <span>$author_name</span>
            </a>";
        }


    echo "                        
        <div class='col-md-3 mt-3'>
            <div class='img_box'>
                <a href='index.php?source=view_correct_post&p_id=$post_id'>
                    <img class='img-fluid' src='images/$post_image' alt='$post_title'>
                </a>
            </div>            
            <div>
                <a href='index.php?source=view_correct_post&p_id=$post_id'>
                    <h5 class='bung my-1'>$post_title</h5>
                </a>
            </div>
            <div class='d-flex justify-content-between'>
                $author_link
                <div style='font-size: 0.8em'>
                    <i class='far fa-heart mr-1'></i>$post_likes_count</li>
                    <i class='fas fa-check mr-1'></i>$post_correction_count</li>
                </div>
            </div>
            <span style='font-size: 0.8em'><i class='fas fa-clock'></i><time>$post_date</time></span>
            <p class='p-0'>$post_content</p>
        </div>";
    }
}


function getPostsByTopic(){
    global $dbc;
    global $topic_name;
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    if(!isset($_SESSION["user_name"])){  //ログインしてない人(Public)
        $query = "SELECT * FROM posts WHERE post_access=1 AND post_topic='$topic_name' LIMIT 16";
    }else if(isset($_SESSION["user_name"])){  //ログインしてる人( + All Users)
        $query = "SELECT * FROM posts WHERE post_access=1 OR post_access=2 post_topic='$topic_name' LIMIT 16";
    }    //Friendsでの絞り方、学んでから追加する。
    
    $select_topic_posts = mysqli_query($dbc, $query);
    while($row = mysqli_fetch_assoc($select_topic_posts)){
        $post_id = $row["post_id"];
        $post_image = $row["post_image"];
        $post_title = $row["post_title"];
        $post_date = date("Y/n/j D AG:i",  strtotime($row["post_date"]));
        $post_content = substr($row["post_content"], 0, 100) . "...";
        $post_likes_count = $row["post_likes_count"];
        $post_correction_count = $row["post_correction_count"]; 
        $post_author_id =  $row["post_author_id"];
        $query = "SELECT * FROM users WHERE user_id=$post_author_id";
        $get_author_data = mysqli_query($dbc, $query);
        checkQuery($get_author_data);
        while($row = mysqli_fetch_assoc($get_author_data)){
            $author_name = $row["user_name"];
            $author_image = $row["user_image"];
        }
        if(isset($_SESSION["user_name"])){  //ログインしてたらユーザープロフィールに飛べる
            $author_link = "
            <a href='./mypage.php?source=user_detail&user_id=$post_author_id' class='d-block'>
                <img src='./images/$author_image' alt='' width='25px' class='mr-1 image-fluid rounded-circle'>
                <span>$author_name</span>
            </a>";
        }else{
            $author_link ="
            <a href='' class='d-block'>
                <img src='./images/$author_image' alt='' width='25px' class='mr-1 image-fluid rounded-circle'>
                <span>$author_name</span>
            </a>";
        }

    echo "                        
        <div class='col-md-3 mt-3'>
            <a href='index.php?source=view_correct_post&p_id=$post_id'>
                <div class='img_box'>
                    <img class='img-fluid' src='images/$post_image' alt='$post_title'>
                </div>
            </a>
            <h5 class='bung my-1'>
                <a href='index.php?source=view_correct_post&p_id=$post_id'>$post_title</a>
            </h5>
            <div class='d-flex justify-content-between'>
                $author_link
                <div style='font-size: 0.8em'>
                    <i class='far fa-heart mr-1'></i>$post_likes_count</li>
                    <i class='fas fa-check mr-1'></i>$post_correction_count</li>
                </div>
            </div>
            <span style='font-size: 0.8em'><i class='fas fa-clock'></i><time>$post_date</time></span>
            <p class='p-0'>$post_content</p>
        </div>";
    }
}
?>







<?php  // MYPAGE
// GET MY LATEST POSTS ~ myprofile.php
function getMyLatestPosts(){
    global $dbc;
    $user_id = $_SESSION["user_id"];    

    $query = "SELECT * FROM posts WHERE post_author_id='$user_id' ORDER BY post_date DESC";
    $select_all_posts = mysqli_query($dbc, $query);
    while ($row = mysqli_fetch_assoc($select_all_posts)) {
        $post_id = $row["post_id"];
        $post_title = $row["post_title"];
        $post_content = substr($row["post_content"], 0, 100) . "... ";
        $post_image = $row["post_image"];
        $post_date = $row["post_date"];
        $post_date = date("n/j D G:i",  strtotime($post_date));
        $post_likes_count = $row["post_likes_count"];
        $post_correction_count = $row["post_correction_count"];
        $post_view_count = $row["post_view_count"];
        $post_access = $row["post_access"];

        $query = "SELECT * FROM comments WHERE comment_post_id=$post_id";
        $get_comment_count = mysqli_query($dbc, $query);
        $comment_count = mysqli_num_rows($get_comment_count);

        if($post_access=='Private'){  // class='ml-2 text-light'
            $eye = "<small class='ml-2' style='color: #CACACA;'><i class='fas fa-eye-slash'></i></small>";
        }else{
            $eye = "";
        }

        echo "
        <div class='col-md-6 mt-3'>
            <div class='row'>
                <div class='col-md-6'>
                    <a href='mypage.php?source=view_post&p_id=$post_id'>
                        <h4>$post_title.$eye</h4>
                        <div class='row justify-content-between align-items-center'>
                            <div class='col-6 text-left pr-0'>
                                <span style='font-size: .8em'><i class='fas fa-clock mr-1'></i><time>$post_date</time></span>
                            </div>
                            <div class='col-6 text-right pl-0' style='font-size: .8em'>
                                <span><i class='far fa-eye mr-1'></i>$post_view_count</span>
                                <span><i class='fas fa-heart mr-1'></i>$post_likes_count</span> 
                                <span><i class='far fa-comment mr-1'></i>$comment_count</span>
                                <span><i class='fas fa-check mr-1'></i>$post_correction_count</span>
                            </div>
                        </div>
                        <p class='m-0'>$post_content</p>
                    </a>
                    <div class='float-right'>
                        <a href='mypage.php?source=edit_post&edit_id=$post_id' class='text-info'> Edit</a>
                        <a onClick=\"javascript: return confirm('Are you sure you want to delete?'); \" href='mypage.php?source=mypage&delete_id=$post_id' class='text-danger ml-3'><i class='mr-1 far fa-trash-alt'></i></a>
                    </div>
                </div>
                <div class='col-md-6 mb-3'>
                    <a href='mypage.php?source=view_post&p_id=$post_id'>
                        <div class='img_box'>
                            <img src='./images/$post_image' alt='$post_title'>
                        </div>
                    </a>
                </div>
            </div>
        </div>";
    }
}


//DELETE POST ~ myprofile.php
function deletePost(){
    global $dbc;
    if (isset($_GET["delete_id"])) {
        $delete_id = $_GET["delete_id"];
        //別のページからでもURLにdelete_userでidを指定したら削除できてしまうことを防ぐVALIDATION
        $user_id = $_SESSION["user_id"];  
        $query = "SELECT * FROM posts WHERE post_id = $delete_id";
        $check_author_and_user_query = mysqli_query($dbc, $query);
        checkQuery($check_author_and_user_query);
        while($row = mysqli_fetch_assoc($check_author_and_user_query)){
            $post_author_id = $row["post_author_id"];
            if($post_author_id == $user_id){  //post_author本人にしかdeleteできないよう実装
                //ここからDELETE実装
                $query = "DELETE FROM posts WHERE post_id=$delete_id";
                $delete_post_query = mysqli_query($dbc, $query);
                if ($delete_post_query) {
                    alert("The post has been deleted!");
                }
            }
        }        
    }
}

// GET THE USER'S LATEST POSTS ~ user_detail.php
function getTheUsersLatestPosts(){
    global $dbc;
    $user_id = $_GET["user_id"];
    $query = "SELECT * FROM posts WHERE post_author_id='$user_id' AND post_access!='Private' ORDER BY post_date DESC";
    $select_all_posts = mysqli_query($dbc, $query);
    while ($row = mysqli_fetch_assoc($select_all_posts)) {
        $post_id = $row["post_id"];
        $post_title = $row["post_title"];
        $post_content = substr($row["post_content"], 0, 100) . "... ";
        $post_image = $row["post_image"];
        $post_date = $row["post_date"];
        $post_date = date("n/j D G:i",  strtotime($post_date));
        $post_likes_count = $row["post_likes_count"];
        $post_correction_count = $row["post_correction_count"];
        $post_view_count = $row["post_view_count"];

        $query = "SELECT * FROM comments WHERE comment_post_id=$post_id";
        $get_comment_count = mysqli_query($dbc, $query);
        $comment_count = mysqli_num_rows($get_comment_count);

        echo "
        <div class='col-md-6 mt-3'>
            <div class='row'>
                <div class='col-md-6'>
                    <a href='mypage.php?source=view_post&p_id=$post_id'>
                        <h4>$post_title</h4>
                        <div class='row justify-content-between align-items-center'>
                            <div class='col-6 text-left pr-0'>
                                <span style='font-size: .8em'><i class='fas fa-clock mr-1'></i><time>$post_date</time></span>
                            </div>
                            <div class='col-6 text-right pl-0' style='font-size: .8em'>
                                <span><i class='far fa-eye mr-1'></i>$post_view_count</span>
                                <span><i class='fas fa-heart mr-1'></i>$post_likes_count</span> 
                                <span><i class='far fa-comment mr-1'></i>$comment_count</span>
                                <span><i class='fas fa-check mr-1'></i>$post_correction_count</span>
                            </div>
                        </div>
                        <p class='m-0'>$post_content</p>
                    </a>
                </div>
                <div class='col-md-6 mb-3'>
                    <a href='mypage.php?source=view_post&p_id=$post_id'><img src='./images/$post_image' alt='' width='100%'></a>
                </div>
            </div>
        </div>";
    }
}

?>