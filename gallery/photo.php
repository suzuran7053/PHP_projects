<?php include("includes/header.php"); ?>
<?php
require_once("admin/includes/init.php");

if (empty($_GET['id'])) {
    redirect("index.php");
}

$photo = Photo::find_by_id($_GET['id']);
/*var_dump($photo);
object(Photo)#5 (12) { 
    ["id"]=> string(2) "28" 
    ["title"]=> string(2) "23" 
    ["alternate_text"]=> string(0) "" 
    ["caption"]=> string(0) "" 
    ["description"]=> string(0) "" 
    ["filename"]=> string(13) "images-23.jpg" 
    ["type"]=> string(10) "image/jpeg" 
    ["size"]=> string(5) "22792" 
    ["tmp_path"]=> NULL 
    ["upload_directory"]=> string(6) "images" 
    ["errors"]=> array(0) { } 
    ["upload_errors_array"]=> array(8) { 
        [0]=> string(18) "There is no error." 
        [1]=> string(71) "The uploaded file exceeds the upload_max_filesize directive in php.ini." 
        [2]=> string(90) "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form." 
        [3]=> string(46) "The uploaded file was only partially uploaded." 
        [4]=> string(21) "No file was uploaded." 
        [6]=> string(27) "Missing a temporary folder." 
        [7]=> string(29) "Failed to write file to disk." 
        [8]=> string(40) "A PHP extension stopped the file upload." 4
    }
} 
*/

// POST A COMMENT
if (isset($_POST['submit'])) {
    $author = trim($_POST['author']); // Just take out space in case users use space
    $body = trim($_POST['body']);
    $new_comment = Comment::create_comment($photo->id, $author, $body);
    if ($new_comment && $new_comment->save()) {
        //if everything went OK, redirect 
        redirect("photo.php?id=$photo->id");
    } else {
        echo $message = "There was some problems saving";
    }
} else {
    $author = "";
    $body = "";
}

// TO LOOP THROUGH IN THE BELOW
$comments = Comment::find_the_comments($photo->id);


?>


<!-- Navigation -->
<?php include("includes/navigation.php"); ?>

<!-- Page Content -->
<div class="container">
    <div class="row">


        <!-- Blog Post Content Column -->
        <div class="col-lg-12">

            <h1><?php echo $photo->title;?></h1>
            <p class="lead">
                by <a href="#">Start Bootstrap</a>
            </p>
            <hr>
            <p><span class="glyphicon glyphicon-time"></span> Posted on August 24, 2013 at 9:00 PM</p>
            <hr>
            <img class="img-responsive" style="width: 100%;" src="admin/<?php echo $photo->picture_path();?>" alt="">
            <hr>
            <p class="lead"><?php echo $photo->caption;?></p>
            <p><?php echo $photo->description;?></p>
            <hr>



            <div class="well">
                <h4>Leave a Comment:</h4>
                <form role="form" method="post">
                    <div class="form-group">
                        <label for="author">Author</label>
                        <input type="text" name="author" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="comment">Comment</label>
                        <textarea name="body" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <hr>


            <!-- Posted Comments -->
            <?php foreach ($comments as $comment) { ?>
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment->author; ?>
                            <small>August 25, 2014 at 9:30 PM</small>
                        </h4>
                        <?php echo $comment->body; ?>
                    </div>
                </div>
            <?php } ?>


            </div>

        </div>
        <!-- Blog Sidebar Widgets Column 
        <div class="col-md-4">
            <?php //include("includes/sidebar.php"); ?>
        </div> -->
        <!-- /.row -->
    </div>
    <?php include("includes/footer.php"); ?>