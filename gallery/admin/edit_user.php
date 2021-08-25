<?php include("includes/header.php"); ?>
<?php include("includes/photo_library_modal.php"); ?>
 
<?php if (!$session->is_signed_in()) {
    redirect("./admin/login.php");
} ?>

<?php
if (empty($_GET["id"])) {
    redirect("users.php");
} else {
    $user = User::find_by_id($_GET["id"]);
    if (isset($_POST['update'])) {
        if ($user) {
            $user->username = $_POST["username"];
            $user->first_name = $_POST["first_name"];
            $user->last_name = $_POST["last_name"];

            if ($_FILES['user_image']['error'] == 4) {  // If image was not sent !!! This was the solution :)
                $user->save();
                $session->message("The user has been updated!");
                redirect("users.php");
                
            } else {
                $user->set_file($_FILES['user_image']);
                $user->save_user_and_image();
                $session->message("The user has been updated!");
                //redirect("edit_user.php?id=$user->id");
                redirect("users.php");
            }
        }
    }
}
?>


<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="background: rgb(34,193,195); background: linear-gradient(0deg, rgba(34,193,195,1) 0%, rgba(253,187,45,1) 100%);">
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

                <div class="col-md-6 user_image_box">
                    <a href="" data-toggle="modal" data-target="#photo-library"><img class="img-responsive user-edit-image" src="<?php echo $user->image_path_and_placeholder(); ?>" alt="<?php echo $user->username; ?>"></a>
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $user->username; ?>">
                        </div>
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" name="first_name" class="form-control" value="<?php echo $user->first_name; ?>">
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" name="last_name" class="form-control" value="<?php echo $user->last_name; ?>">
                        </div>
                        <div class="form-group">
                            <label for="user_image">Image</label>
                            <input type="file" name="user_image">
                        </div>
                        <div class="form-group">
                            <a id="user-id" class="btn btn-danger" href="delete_user.php?id=<?php echo $user->id; ?>">Delete</a>
                            <input type="submit" name="update" value="Update" class="btn btn-primary pull-right">
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>