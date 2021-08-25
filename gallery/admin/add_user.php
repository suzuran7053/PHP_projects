<?php include("includes/header.php"); ?>
<?php if (!$session->is_signed_in()) {
    redirect("./admin/login.php");
} ?>

<?php

if (isset($_POST['create'])) {
    $user = new User;
    if ($user) {
        $user->username = $_POST["username"];
        $user->first_name = $_POST["first_name"];
        $user->last_name = $_POST["last_name"];
        $user->password = $_POST["password"];
        
        if(isset($_FILES['user_image'])){
            $user->set_file($_FILES['user_image']);    
            $user->save_user_and_image();  
            $session->message("User '$user->username' has been created!");      
        }else{
            $user->save();
            $session->message("User '$user->username' has been created!");
        }        
        redirect("users.php");
    }
} 
?>

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <?php include("includes/top_nav.php"); ?>
    <?php include("includes/side_nav.php"); ?>
</nav>


<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Users
                    <small>Subheading</small>
                </h1>

                <form action="" method="post" enctype="multipart/form-data">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" name="first_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" name="last_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <input type="file" name="user_image" required>
                        </div>    
                        <div class="form-group">
                            <input type="submit" name="create" class="btn btn-primary pull-right" value="Create">
                        </div>

                    </div>
                    
                </form>

            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>