<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()){ redirect("./admin/login.php"); } ?>

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
                    Photos
                </h1>
                <p class="bg-success"><?php echo $message; ?></p>

                <div class="col-md-12">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Id</th>
                                <th>File Name</th>
                                <th>Title</th>
                                <th>Size</th>
                                <th>Comment</th>
                            </tr>
                        </thead>
                        <tbody>                            
                        <?php
                            // SHOW ONLY THE PHOTOS THAT WERE CREATED THE USER CURRENTLY LOGGING IN
                            // Using concatination "->photos()"  This method is in User class (user.php)
                            $photos = User::find_by_id($_SESSION["user_id"])->photos();
                            //$photos = Photo::find_all();  <-- This will show all the photos created by all users                          
                            foreach ($photos as $photo) { 
                        ?>
                            <tr>    
                                <td>
                                    <img class="admin-photo-thumbnail" src="<?php echo $photo->picture_path() ?>" alt="">
                                    <div class="action_link">
                                        <a class="delete_link" href="delete_photo.php?id=<?php echo $photo->id; ?>">Delete</a>
                                        <a href="edit_photo.php?id=<?php echo $photo->id; ?>">Edit</a>
                                        <a href="../photo.php?id=<?php echo $photo->id; ?>">View</a>
                                    </div>
                                </td>
                                <td><?php echo $photo->id; ?></td>
                                <td><?php echo $photo->filename; ?></td>
                                <td><?php echo $photo->title; ?></td>
                                <td><?php echo $photo->size; ?></td>
                                <td>
                                    <a href="comment_photo.php?id=<?php echo $photo->id; ?>">
                                    <?php 
                                        $comments = Comment::find_the_comments($photo->id);
                                        echo count($comments); // Showing the number of comments of each photo
                                    ?>
                                    </a>
                                </td>
                            </tr>
                        <?php 
                            }
                        ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>