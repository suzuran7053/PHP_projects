<?php include("includes/header.php"); ?>
<?php include("includes/navigation.php"); ?>

<?php
if (empty($_GET["id"]) || !$session->is_signed_in()) {
    $session->message("Sorry, you are not allowed to edit a post.");
    redirect("index.php");
} else {
    $post = Post::find_by_id($_GET["id"]);
    if(!empty($_SESSION["message"])){
        $message = $_SESSION["message"];
    }else{
        $message = "";
    } 
}



// UPDATE
if (isset($_POST['update'])) {
    $post->cat_id = $_POST['cat_id'];
    $post->date = $_POST['date'];
    $post->flag = $_POST['flag'];
    $post->title = $_POST['title'];
    $post->sub_title = $_POST['sub_title'];
    $post->content = $_POST['content'];
    $post->tags = $_POST['tags'];

    if($post->update()){
        $session->message("Post uploaded successfully");
        redirect("view_post.php?id=". $post->id);
    }else{
        $message = join("<br>", $post->errors); //join() returns a string from the elements of an array.
    }
}
?>


<div class="container" style="margin-top: 80px;">
    <div class="row justify-content-center">
        <div class="col-10">
            <h1 class="text-center">EDIT A POST</h1>
            <?php
            if($message){
                echo "<p class='bg-success p-1'>".$message."</p>";
            }?>
                           
                <div class="row">
                    <div class="col-12">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="date">Date<small class="text-danger">*</small></label>
                                <?php $date = date('Y-m-d\TH:i', strtotime($post->date)); ?>
                                <input value="<?php echo $date; ?>" class="form-control bg-light border-0" name="date" type="datetime-local">
                            </div>

                            <div class="form-group">
                                <select name="cat_id" class="custom-select-sm">
                                <?php 
                                $category = Category::find_cat_by_id($post->cat_id); 
                                    echo "<option value='". $category[0]->id ."' class='form-control' selected>". $category[0]->name ."</option>";
                                $categories = Category::find_all_cat(); 
                                foreach ($categories as $category){
                                    if($category->id != $post->cat_id){
                                        echo "<option value='.$category->id.' class='form-control'>" .$category->name. "</option>";
                                    }
                                }
                                ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="title">Title<small class="text-danger">*</small></label>
                                <input class="form-control" type="text" name="title" value="<?php echo $post->title; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="sub_title">Subtitle</label>
                                <input class="form-control" type="text" name="sub_title" value="<?php echo $post->sub_title; ?>">
                            </div>
                            <div>
                                <label for="summernote">Content<small class="text-danger">*</small></label>
                                <textarea id="summernote" name="content" id="" cols="30" rows="20"><?php echo $post->content; ?></textarea>
                            </div>
                            <div class="form-group mt-3">
                                <label for="tags">#Tags<small class="text-danger">*</small></label>
                                <input class="form-control" type="text" name="tags" value="<?php echo $post->tags; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="flag">Flag</label>
                                <input class="form-control" type="text" name="flag" value="<?php echo $post->flag; ?>">
                            </div>
                            <input type="submit" name="update" value="UPDATE" class="btn btn-danger btn-block">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>
