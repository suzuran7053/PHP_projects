<?php include("includes/header.php"); ?>
<?php 
    if(!$session->is_signed_in()){
        $session->message("Sorry, you are not allowed to create a post.");
        redirect("./index.php"); 
    } 
?>
<?php include("includes/navigation.php"); ?>

<?php
    $message = "";
    if(isset($_POST["create"])){
        $post = new Post;
        $post->cat_id = $_POST['cat'];
        //$post->date = time();
        $post->date = date("Y-m-d H:i:s");
        $post->flag = $_POST['flag'];
        $post->title = $_POST['title'];
        $post->sub_title = $_POST['sub_title'];
        $post->content = $_POST['content'];
        $post->tags = $_POST['tags'];

        if($post->create()){
            $session->message("Post created successfully!");
            redirect("view_post.php?id=". $post->id);
        }else{
            $session->message(join("<br>", $post->errors)); //join() returns a string from the elements of an array.
        }
    } 
?>


<div class="container" style="margin-top: 80px;">
    <div class="row justify-content-center">
        <div class="col-10">
            <h1 class="text-center">CREATE A POST</h1>
                <p class="bg-success"><?php echo $message; ?></p>
                
                <div class="row">
                    <div class="col-12">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="date">Date</label>
                                <?php                
                                    $today = date('Y-m-d\TH:i', strtotime("now"));
                                ?>
                                <input value="<?php echo $today; ?>" class="form-control bg-light border-0" name="post_date" type="datetime-local">
                            </div>

                            <div class="form-group">
                                <select name="cat" class="custom-select-sm">
                                    <option selected disabled required>Select Category</option>
                                    <?php
                                        $categories = Category::find_all_cat();
                                        foreach($categories as $category){
                                    ?>
                                        <option value="<?php echo $category->id;?>"><?php echo $category->name;?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="title">Title<small class="text-danger">*</small></label>
                                <input class="form-control" type="text" name="title" required>
                            </div>
                            <div class="form-group">
                                <label for="sub_title">Subtitle</label>
                                <input class="form-control" type="text" name="sub_title">
                            </div>
                            <div>
                                <label for="summernote">Content<small class="text-danger">*</small></label>
                                <textarea id="summernote" name="content" id="" cols="30" rows="20" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="title">#Tags<small class="text-danger">*</small></label>
                                <input class="form-control" type="text" name="tags" required>
                            </div>
                            <div class="form-group">
                                <label for="title">Flag</label>
                                <input class="form-control" type="text" name="flag">
                            </div>
                            <input type="submit" name="create" value="POST" class="btn btn-secondary btn-block">           
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>