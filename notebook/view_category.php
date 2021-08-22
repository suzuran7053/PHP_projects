<?php 
include("includes/header.php");
include("includes/navigation.php");

if (empty($_GET["id"])) {
    redirect("index.php");
}
$category = Category::find_cat_by_id($_GET["id"]);
$posts = Post::find_post_by_cat($_GET["id"]);
?>

<!-- Page Content -->
<div class="container" style="margin-top:80px;">
    <div class="row">    
        <div class="col-md-12 col-xl-10 mx-auto">
        
            <h1 class="text-center"><?php echo $category[0]->name; ?></h1>
            <div style="border-bottom: dotted 5px <?php echo $category[0]->colour; ?>"></div>

            <div class="row justify-content-center my-5">        
                <?php
                foreach($posts as $post){                    
                    if(strlen($post->sub_title)>50){
                        $sub_title = substr($post->sub_title, 0, 50) . "...";
                    }else{
                        $sub_title = $post->sub_title;
                    }
                    // FORMAT date
                    $date = date("Y/n/j",  strtotime($post->date));
                ?>
                    <div class="col-md-6 col-xl-4">
                        <a href="view_post.php?id=<?php echo $post->id;?>">
                            <div class="post">
                                <h3 class="f"><?php echo $post->title; ?></h3>
                                <div class="text-right">
                                    <time><?php echo $date; ?></time>
                                </div>
                                <p class="text-left"><?php echo $sub_title; ?></p>
                            </div>    
                        </a>
                    </div>
            <?php } ?>
            </div>
        </div>
    </div>

</div>
<?php include("includes/footer.php"); ?>