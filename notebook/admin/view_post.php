<?php include("includes/header.php"); ?>
<?php //if(!$session->is_signed_in()){ redirect("./admin/login.php"); } ?>
<?php include("includes/navigation.php"); ?>

<?php
if (empty($_GET['id'])) {
    redirect("./index.php");
}
$post = post::find_by_id($_GET['id']);
$session->check_message();
?>


<!-- Page Content -->
<div class="container" style="margin-top:80px;">
    <?php 
        $session->check_message();
        if($message){
            //echo "<p class='bg-info p-2 text-center'>".$message."</p>";
            alert($message);
        }
    ?>
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
            
            <a class="float-left text-danger" href="edit_post.php?id=<?php echo $post->id;?>">Edit</a>     
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