<?php 
include("includes/header.php");
include("includes/navigation.php");
$posts = Post::find_all();
?>

<div class="container" style="margin-top:80px;">
    <div class="row">    
        <div class="col-md-12 col-xl-10 mx-auto">

            <div class="row justify-content-center">
                <?php 
                foreach ($posts as $post) { 
                    // GET THE CATEGORY COLOUR
                    $cat = Category::find_cat_by_id($post->cat_id);
                    if(strlen($post->sub_title)>50){
                        $sub_title = substr($post->sub_title, 0, 50) . "...";
                    }else{
                        $sub_title = $post->sub_title;
                    }
                    $date = date("Y/n/j", strtotime($post->date));                  
                ?>                    
                    <div class="col-md-6 col-xl-4 posts">
                        <a href="view_post.php?id=<?php echo $post->id;?>" class="text-dark" style="text-decoration: none;">
                            <div class="post">
                                <div style="border-bottom: dotted 5px <?php echo $cat[0]->colour; ?>">
                                    <span class="cat_name text-left mb-3 p-3" style="background:<?php echo $cat[0]->colour; ?>;"><?php echo $cat[0]->name; ?></span>                   
                                </div>
                                <h3 class="f my-3"><?php echo $post->title; ?></h3>
                                <div class="text-right">
                                    <time><?php echo $date; ?></time>
                                </div>
                                <p class="text-left"><?php echo $sub_title; ?></p>
                                <div clas="text-right">
                                    <a class="text-danger" href="edit_post.php?id=<?php echo $post->id;?>">Edit</a>
                                </div>  
                            </div>  
                        </a>
                    </div>
                <?php } ?>
            </div>

        </div>
    </div>
</div>



<?php include("includes/footer.php"); ?>