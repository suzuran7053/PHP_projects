<!-- Login Modal -->
<?php
    if(isset($_POST["login"])){    
        login_user($_POST["username"], $_POST["password"]);
    }
?>
<div class="modal fade" id="loginModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <div class="modal-title text-center">
                    <h2>Login</h2>
                </div>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body text-center">
                <div class="panel-body">
                    <form id="login-form" role="form" autocomplete="on" class="form" method="post" action="index.php">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                                <input name="username" type="text" class="form-control" placeholder="Enter Username">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
                                <input name="password" type="password" class="form-control" placeholder="Enter Password">
                            </div>
                        </div>
                        <div class="form-group">
                            <input name="login" type="submit" class="btn btn-sm btn-info" value="Login" type="OK">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
    if(isset($_POST["signin"])){    
        register_user($_POST["username"], $_POST["password"]);
    }
?>
<!-- Sign up Modal -->
<div class="modal fade" id="signinModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <div class="modal-title text-center">
                    <h2>Sign up</h2>
                </div>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body text-center">
                <div class="panel-body">
                    <form id="signin-form" role="form" autocomplete="off" class="form" method="post" action="index.php">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                                <input name="username" type="text" class="form-control" placeholder="Enter Username">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
                                <input name="password" type="password" class="form-control" placeholder="Enter Password">
                            </div>
                        </div>
                        <div class="form-group">
                            <input name="signin" class="btn btn-sm btn-info" value="Submit" type="submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




<nav class="navbar sticky-top text-light" role="navigation">

    <div class="mr-auto">
        <a href="index.php"><img src="./images/logo.png" alt="wrestling nonsense logo" class="image-fluid" style="width: 80px;"></a>
        <?php
        //if(isset($_SESSION["user_name"])){
            $add_post_link = "./index.php?source=add_post";
        /*} else{
            $add_post_link = "./index.php";
        } */
        ?>
        <a href="<?php echo $add_post_link; ?>" class="ml-3" style="font-size: 20px;"><i class="fas fa-pencil-alt"></i></a>
    </div>


    <?php
    //if (isLoggedIn()) {
        echo '<ul class="mb-0 text-white font" id="nav-lg" style="width: 60vw;">';
        $query = "SELECT * FROM categories";
        $select_all_categories_query = mysqli_query($dbc, $query);
        while ($row = mysqli_fetch_assoc($select_all_categories_query)) {
            $cat_id = $row["cat_id"];
            $cat_title = $row["cat_title"];
            echo "<li class='mx-3 nav-item'><a href=index.php?source=cat_post&cat_id=$cat_id>$cat_title</a></li>";
        }
        echo '</ul>';
    //}
    ?>

    <ul class="mb-0" id="user_menu">
        <li class="nav-item">

            <?php
            if (!isLoggedIn()) {
                echo '
                <a href="" class="btn btn-dark" data-toggle="modal" data-target="#loginModal">Log in</a>
                <a href="" class="btn btn-info" data-toggle="modal" data-target="#signinModal">Sign up</a>';
            } else {
                $user_id = $_SESSION["user_id"];
                $query = "SELECT * FROM users WHERE user_id = $user_id";
                $get_user_info = mysqli_query($dbc, $query);
                checkQuery($get_user_info);
                while($row = mysqli_fetch_assoc($get_user_info)){
                    $user_img = $row["user_image"];
                    $user_name =$row["user_name"];
                }            
            ?>
                <form action="index.php?source=search" method="post" class="d-inline">
                    <input name="search_keyword" type="text">
                    <button class="btn pl-0" type="submit" name="search_submit">
                        <i class="fas fa-search text-white" style="font-size: 20px;"></i>
                    </button>
                </form>

                <a href="index.php?source=setting"><i class="fas fa-cog mr-2" style="font-size: 20px;"></i></a>
                <a href="includes/logout.php"><i class="fas fa-sign-out-alt mr-2" style="font-size: 20px;"></i></a>
                
                <img src="./images/<?php echo $user_img; ?>" alt="<?php echo $user_name; ?>" style="width:40px; height:40px;" class="img-fluid rounded-circle">

            <?php
            }    
            ?>
        </li>
    </ul>

    <!-- HUMBURGAR-->
    <ul class="nav navbar-nav align-content-center" id="nav-sm">
        <li class="nav-item">
            <form action="index.php?source=search" method="post" class="d-inline">
                <input name="search_keyword" type="text" style="width: 25vw; vertical-align: middle;">
                <button class="btn pl-0" type="submit" name="search_submit" style="vertical-align: middle;">
                    <i class="fas fa-search text-white" style="font-size: 20px;"></i>
                </button>
            </form>
        </li>
        <li class="nav-item">
            <div onclick="openNav()" class="d-inline" style="vertical-align: middle;"><i class="fas fa-bars" style="font-size:2em;"></i></div>
        </li>
        
    </ul>
    
    <div id="mySidenav" class="ham font">
        <div class="text-right mt-4">
            <a class="closebtn" style="font-size: 1.3em;" href="javascript:void(0)" onclick="closeNav()"><i class="fas fa-times mr-3"></i></a>
        </div>
        <ul class="text-center font">            
            
            <?php
            if (!isLoggedIn()) {
                echo '
                <li class="d-block m-4"><a href="" class="btn btn-dark" data-toggle="modal" data-target="#loginModal">Log in</a></li>
                <li class="d-block m-4"><a href="" class="btn btn-info" data-toggle="modal" data-target="#signinModal">Sign up</a></li>';
            } //else {
            ?>                
                <li class="d-block m-4">
                    <a href="#"><img src="./images/<?php echo $user_img; ?>" alt="<?php echo $user_name; ?>" style="width:75px; height:75px;" class="img-fluid rounded-circle"></a>
                </li>         

                <?php
                $query = "SELECT * FROM categories";
                $select_all_categories_query = mysqli_query($dbc, $query);

                while ($row = mysqli_fetch_assoc($select_all_categories_query)) {
                    $cat_id = $row["cat_id"];
                    $cat_title = $row["cat_title"];
                    echo "<li class='d-block m-4'><a href='index.php?source=cat_post&cat_id=$cat_id'>$cat_title</a></li>";
                }
                ?>
            
                <div class="mx-auto dropdown-divider" style="width: 60%;"></div>
                <li class="d-block m-4">
                    <a href="index.php?source=setting"><i class="mr-2 fas fa-cog"></i>Setting</a>
                </li>
                <li class="d-block m-4">
                    <a href="includes/logout.php"><i class="mr-2 fas fa-sign-out-alt"></i>Log Out</a>
                </li>
            <?php
            //}
            ?>
        </ul>
    </div>
</nav>