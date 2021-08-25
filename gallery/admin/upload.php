<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()){ redirect("./admin/login.php"); } ?>

<?php
    $message = "";
    //if(isset($_POST["submit"])){
    if(isset($_FILES['file'])){  
        $photo = new Photo;
        $photo->user_id = $_SESSION["user_id"];
        $photo->title = $_POST['title'];
        $photo->set_file($_FILES['file']);  // $_FILES['file_upload'] came from the name of file input in HTML

        if($photo->save()){
            $message = "Photo uploaded successfully";
        }else{
            $message = join("<br>", $photo->errors); //join() returns a string from the elements of an array.
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
                    Upload A New Photo                    
                </h1>
                <p class="bg-success"><?php echo $message; ?></p>
                
                <div class="row">
                    <div class="col-md-6">
                        <?php echo $message; ?>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input class="form-control" type="text" name="title" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <input type="file" name="file">
                            </div>
                            <input type="submit" name="submit">                
                        </form>
                    </div>
                </div>


                <!-- Row for DROPZONE -->
                <div class="row">
                    <div class="col-lg-12">
                        <form action="upload.php" class="dropzone"></form>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>