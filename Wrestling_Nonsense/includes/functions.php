<?php

/*COMMON FUNCTIONS*/
function checkQuery($query){
    global $dbc;
    
    if(!$query){
        die("FAILED TO INSERT INTO DATABASE" . mysqli_error($dbc));
    }
}
function redirect($location){
    return header("Location: $location");
    exit;
}

function alert($message){
    echo "<script type='text/javascript'>alert('$message');</script>";
}


function ifItIsMethod($method=null){
    if($_SERVER["REQUEST_METHOD"] == strtoupper($method)){
        return true;
    }
    return false;
}
function isLoggedIn(){
    if(isset($_SESSION["user_name"])){
        return true;
    }
    return false;
}
function checkIfUserIsLoggedInAndRedirect($redirectLocation=null){
    if(isLoggedIn()){
        redirect($redirectLocation);
    }
}


/*SIGN IN*/
function register_user($username, $password){
    global $dbc;
    $username = mysqli_real_escape_string($dbc, $username);
    $password = mysqli_real_escape_string($dbc, $password);
    $hash = password_hash($password, PASSWORD_DEFAULT);        
    $query = "INSERT INTO users ";
    $query .= "(user_name, user_password, user_image) ";
    $query .= "VALUES('$username', '$hash', 'user_image_default.jpg')";
    $register_user_query = mysqli_query($dbc, $query);
    checkQuery($register_user_query);
}   

/*LOGIN*/
function login_user($username, $password){
    global $dbc;

    // CLEANING UP AND OVERRIDE THE VARIABLES!!
    $username = trim($username);
    $password = trim($password);

    $username = mysqli_real_escape_string($dbc, $username);
    $password = mysqli_real_escape_string($dbc, $password);

    $query = "SELECT * FROM users WHERE user_name='$username'";
    $select_user_query = mysqli_query($dbc, $query);
    if(!$select_user_query){
        die ("QUERY FAILD" . mysqli_error($dbc));
    }
    while($row = mysqli_fetch_array($select_user_query)){
        $db_user_id = $row["user_id"];
        $db_user_name = $row["user_name"];
        $db_user_image = $row["user_image"];
        $db_hash = $row["user_password"];
    }
    //VARIDATION!!
    if (password_verify($password, $db_hash)) {
        //ページトップで　session_start();　でTURN ONしておくこと
        $_SESSION["user_id"] = $db_user_id;
        $_SESSION["user_name"] = $db_user_name;
        $_SESSION["user_image"] = $db_user_image;
    }else{
        alert("Sorry, you failed to login");
    }
}



// FOR 'categories.php' 
    function createCategoriesTable(){
        global $dbc;
        $query = "SELECT * FROM categories ORDER BY cat_id ASC";
        $select_all_categories = mysqli_query($dbc, $query);

        while ($row = mysqli_fetch_assoc($select_all_categories)) {
            $cat_id = $row["cat_id"];
            $cat_title = $row["cat_title"];
            echo "<form method='post' action='' class='row mb-1'>";
                echo "<input type='hidden' value='$cat_id' name='cat_id'>";
                echo "<input type='hidden' value='$cat_title' name='old_cat_title'>";
                echo "<input type='text' placeholder='$cat_title' value='$cat_title' name='new_cat_title'>";
                echo "<input type='submit' value='Edit' class='btn btn-sm btn-info ml-2' name='edit_cat'>";
                echo "<input type='submit' value='Delete' class='btn btn-sm btn-danger ml-2' name='delete_cat'>";
            echo "</form>";
        }
    }

    function editCategory(){
        global $dbc;
        if(isset($_SESSION["user_id"])){
            if(isset($_POST["edit_cat"])){
                $edit_cat_id = $_POST["cat_id"];
                if(empty($_POST["new_cat_title"]) || $_POST["new_cat_title"] == "" || $_POST["new_cat_title"]==$_POST["old_cat_title"]){
                    $new_cat_title = $_POST["old_cat_title"];
                }else{
                    $new_cat_title = $_POST["new_cat_title"];
                }
                $query = "UPDATE categories SET cat_title='$new_cat_title' WHERE cat_id=$edit_cat_id";
                $update_categories_query = mysqli_query($dbc, $query);
                checkQuery($update_categories_query);                
                redirect("index.php?source=setting");
            }
        }else{
            redirect("index.php");
        }
    }

    function deleteCategory(){
        global $dbc;
        
        if(isset($_SESSION["user_id"])){
            if(isset($_POST["delete_cat"])){
                $delete_cat_id = $_POST["cat_id"];
                $query = "DELETE FROM categories WHERE cat_id=$delete_cat_id";
                $delete_category_query = mysqli_query($dbc, $query);
                checkQuery($delete_category_query);
                redirect("index.php?source=setting");
            }
        }else{
            redirect("index.php");
        }
    } 
    
    function insertCategories(){
        global $dbc;
        if (isset($_POST["new_cat_submit"])) {
            $cat_title = $_POST["cat_title"];

            if (!empty($cat_title)) {
                $query = "INSERT INTO categories(cat_title) ";
                $query .= "VALUES('$cat_title')";

                $add_category_query = mysqli_query($dbc, $query);
                checkQuery($add_category_query);
            }
            redirect("index.php?source=setting#other_setting");
        }
    }






    /*index.php*/
    function showNewPosts(){
        echo '<div class="col-md-12" style="padding-top:50px;">
                <h1 class="font">New Post</h1>
                <div class="row">';

        global $dbc;
        $query = "SELECT *, ";
        $query .= "users.user_id, users.user_name, users.user_image ";
        $query .= "FROM posts ";
        $query .= "INNER JOIN users ON users.user_id = posts.post_author_id ";
        $query .= "ORDER BY post_date DESC LIMIT 12";

        $select_all_posts_query = mysqli_query($dbc, $query);
        checkQuery($select_all_posts_query);
    
        while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
            $post_id = $row["post_id"];
            $post_title = $row["post_title"];
            $post_date = $row["post_date"];
            $post_date = date("Y/n/j D",  strtotime($post_date));
            $post_image = $row["post_image"];
            $post_content = $row["post_content"];
            //$author_name = $row["user_name"];
            $author_image = $row["user_image"];
            if(strlen($post_title)>20){
                $post_title = substr($post_title, 0, 20) .".."; 
            }
            if(strlen($post_content)>80){
                $post_content = substr($post_content, 0, 80) ."..."; 
            }
        echo "
        <div class='col-lg-3 col-6 mb-3'>
            <a href='index.php?source=view_post&post_id=$post_id'>
                <div class='img_box'>
                    <img class='image-fluid' src='images/$post_image' alt=''>
                </div>                                    
                <h5 class='font-weight-bold m-0'><small>$post_title</small></h5>
            </a>
            <div class='text-right'>
                <span style='font-size: 0.8em'><i class='fas fa-clock mr-1'></i><time>$post_date</time></span>
                <img class='image-fluid rounded-circle' src='images/$author_image' alt='' style='width: 20px; height: 20px;'> 
            </div>
            <a href='index.php?source=view_post&post_id=$post_id'>
                <p style='font-size: 0.8em'>$post_content</p>
            </a>
        </div>";
        }
        echo "</div></div>";                
    }


    //At the bottom in 'view_post.php'
    function showTheLastPost(){
        global $dbc;
        //if(isset($_SESSION["user_id"])){
            $post_id = $_GET["post_id"];
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $query = "SELECT * FROM posts ";
            $query .= "WHERE post_id < $post_id ";
            $query .= "ORDER BY post_date DESC LIMIT 1";

            $select_the_last_post = mysqli_query($dbc, $query);
            checkQuery($select_the_last_post);

            if(mysqli_num_rows($select_the_last_post) > 0) {
                while ($row = mysqli_fetch_assoc($select_the_last_post)) {
                    $post_id = $row["post_id"];
                    $post_title = $row["post_title"];
                    $post_image = $row["post_image"];
                    $post_content = $row["post_content"];
                    if(strlen($post_title)>20){
                        $post_title = substr($post_title, 0, 20) .".."; 
                    }
                    if(strlen($post_content)>80){
                        $post_content = substr($post_content, 0, 80) ."..."; 
                    }
                    echo "<div class='col-4'>
                            <a href='index.php?source=view_post&post_id=$post_id'>
                                <div class='img_box'>
                                    <img class='image-fluid' src='images/$post_image' alt=''>
                                </div>                                    
                                <h5 class='font-weight-bold'><small>$post_title</small></h5>
                            </a>
                            <div>
                                <a href='index.php?source=view_post&post_id=$post_id'>
                                    <p style='font-size: 0.7em'>$post_content</p>
                                </a>
                            </div>
                        </div>";
                }
            }else{
                echo "<div class='col-4 align-self-center'>
                        <h4 class='text-center'>No Post</h4>
                    </div>";
            }   
        //}
    }


    //At the bottom in 'view_post.php'
    function showTheNextPost(){
        global $dbc;        
        //if(isset($_SESSION["user_id"])){
            $post_id = $_GET["post_id"];
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $query = "SELECT * FROM posts ";
            $query .= "WHERE post_id > $post_id ";
            $query .= "ORDER BY post_date ASC LIMIT 1";

            $select_the_next_post = mysqli_query($dbc, $query);
            checkQuery($select_the_next_post);
            if(mysqli_num_rows($select_the_next_post) > 0) {
                while ($row = mysqli_fetch_assoc($select_the_next_post)) {
                    $post_id = $row["post_id"];
                    $post_title = $row["post_title"];
                    $post_image = $row["post_image"];
                    $post_content = $row["post_content"];
                    if(strlen($post_title)>20){
                        $post_title = substr($post_title, 0, 20) .".."; 
                    }
                    if(strlen($post_content)>80){
                        $post_content = substr($post_content, 0, 80) ."..."; 
                    }
                    echo "<div class='col-4'>
                            <a href='index.php?source=view_post&post_id=$post_id'>
                                <div class='img_box'>
                                    <img class='image-fluid' src='images/$post_image' alt=''>
                                </div>                                    
                                <h5 class='font-weight-bold'><small>$post_title</small></h5>
                            </a>
                            <div>
                                <a href='index.php?source=view_post&post_id=$post_id'>
                                    <p style='font-size: 0.7em'>$post_content</p>
                                </a>
                            </div>
                        </div>";
                }
            }else{
                echo "<div class='col-4 align-self-center'>
                        <h4 class='text-center'>No Post</h4>
                    </div>";
            }   
        //}
    }



    function showThisCategorysPosts($cat_id){
        global $dbc; 

        //SHOW THE SELECTED CATEGORY TITLE ON THE TOP
        $query = "SELECT cat_id, cat_title FROM categories WHERE cat_id=$cat_id";
        $get_cat_title_query = mysqli_query($dbc, $query);
        while($row = mysqli_fetch_array($get_cat_title_query)){
            $cat_title = $row["cat_title"];
        }        
        echo '<div class="col-md-12" style="margin-top:50px;">
                <h1 class="font text-center">';
        echo $cat_title;
        echo    '</h1>
                <div class="row my-5">';

        //GET ALL POSTS IN THE CATEGORY      
        $query = "SELECT * , ";
        $query .= "categories.cat_id, categories.cat_title, ";
        $query .= "users.user_id, users.user_name, users.user_image ";
        $query .= "FROM posts ";        
        $query .= "INNER JOIN categories ON categories.cat_id  = $cat_id ";
        $query .= "INNER JOIN users ON posts.post_author_id = users.user_id ";
        $query .= "WHERE posts.post_category_id = $cat_id ";
        $query .= "ORDER BY post_date DESC";
    
        $select_cat_all_posts_query = mysqli_query($dbc, $query);
        checkQuery($select_cat_all_posts_query);
    
        while ($row = mysqli_fetch_assoc($select_cat_all_posts_query)) {
            $post_id = $row["post_id"];
            $post_title = $row["post_title"];
            $post_date = $row["post_date"];
            $post_date = date("Y/n/j D",  strtotime($post_date));
            $post_image = $row["post_image"];
            $post_content = $row["post_content"];
            $author_image = $row["user_image"];
            if(strlen($post_title)>20){
                $post_title = substr($post_title, 0, 20) .".."; 
            }
            if(strlen($post_content)>80){
                $post_content = substr($post_content, 0, 80) ."..."; 
            }
            echo "
            <div class='col-lg-3 col-6 mb-3'>
                <a href='index.php?source=view_post&post_id=$post_id'>
                    <div class='img_box'>
                        <img class='image-fluid' src='images/$post_image' alt=''>
                    </div>                                    
                    <h5 class='font-weight-bold m-0'><small>$post_title</small></h5>
                </a>
                <div class='text-right'>
                    <span style='font-size: 0.8em'><i class='fas fa-clock mr-1'></i><time>$post_date</time></span>
                    <img class='image-fluid rounded-circle' src='images/$author_image' alt='' style='width: 20px; height: 20px;'>                                    
                </div>
                <a href='index.php?source=view_post&post_id=$post_id'>
                    <p style='font-size: 0.8em'>$post_content</p>
                </a>
            </div>";
        }                
        echo "</div></div>";       
    }