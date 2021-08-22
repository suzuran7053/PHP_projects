<?php include("includes/header.php"); ?>
<?php
require_once("admin/includes/init.php");

if (empty($_GET['id'])) {
    redirect("index.php");
}

$post = post::find_by_id($_GET['id']);
/*var_dump($post);
object(post)#5 (12) { 
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
/* if (isset($_POST['submit'])) {
    $author = trim($_POST['author']); // Just take out space in case users use space
    $body = trim($_POST['body']);
    $new_comment = Comment::create_comment($post->id, $author, $body);
    if ($new_comment && $new_comment->save()) {
        //if everything went OK, redirect 
        redirect("post.php?id=$post->id");
    } else {
        echo $message = "There was some problems saving";
    }
} else {
    $author = "";
    $body = "";
} */

// TO LOOP THROUGH IN THE BELOW
//$comments = Comment::find_the_comments($post->id);


?>


<!-- Navigation -->
<?php include("includes/navigation.php"); ?>

<!-- Page Content -->
<div class="container" style="margin-top:80px;">
    <div class="row mb-5">

        <div class="mx-auto col-11 text-center">
            <?php
                // GET THE CATEGORY COLOUR
                $cat = Category::find_cat_by_id($post->cat_id);
                // FORMAT date
                $date = date("Y/n/j",  strtotime($post->date));      
            ?>
            <div class="d-inline text-left pb-3">
                <h5 class="fas fa-grip-vertical mr-2" style="color:<?php echo $cat[0]->colour; ?>"></h5><?php echo $cat[0]->name; ?>
            </div>
            
            <h1 class="mt-3"><?php echo $post->title;?></h1>
            <div class="my-3" style="border-bottom: dotted 5px <?php echo $cat[0]->colour; ?>"></div>            
            <span class="text-right d-block"><i class="fas fa-clock mr-1"></i><time><?php echo $date;?></time></span>
            <div class="text-right">
                <span class="tags"><?php echo $post->tags;?></span>
            </div>
            <div class="text-left">
                <h2 class="my-4"><small><?php echo $post->sub_title;?></small></h2>
                <p class="m-5">
                    <?php echo $post->content;?>
                </p>
            </div>
        </div>
    </div>
    <hr>
    <div class="row mt-5">
        <div class="mx-auto col-6 text-center">
            <h4>Leave a Comment:</h4>
            <form role="form" method="post">
                <div class="form-group">
                    <label for="author">Name</label>
                    <input type="text" name="author" class="form-control">
                </div>
                <div class="form-group">
                    <label for="comment">Comment</label>
                    <textarea name="body" class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Comment</button>
            </form>
        </div>
    </div>
    <hr>


            <!-- Posted Comments 
            <?php //foreach ($comments as $comment) { ?>
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php //echo $comment->author; ?>
                            <small>August 25, 2014 at 9:30 PM</small>
                        </h4>
                        <?php //echo $comment->body; ?>
                    </div>
                </div>
            <?php //} ?>-->


</div>
<?php include("includes/footer.php"); ?>