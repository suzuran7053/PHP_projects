<?php include("includes/header.php"); ?>
<?php //if(!$session->is_signed_in()){ redirect("./admin/login.php"); } ?>
<?php include("includes/navigation.php"); ?>

<div class="container" style="margin-top: 80px;">
    <div class="row justify-content-center">
        <div class="col-10">            
            <?php 
            $session->check_message();
            if($message){
                //echo "<p class='bg-info p-2 text-center'>".$message."</p>";
                alert($message);
            }
            ?>
            <h1>Dashboard</h1>
            <div class="row">
                <div class="col-sm-4 my-5">
                    <div class="text-center">
                        <i class="far fa-eye d-block" style="font-size: 4em;"></i>
                        <span style="font-size: 2.5em;"><?php echo $session->count;?><small>views</small></span>
                    </div>
                </div>
                <div class="col-sm-4 my-5">
                    <a href="all_posts.php">
                        <div class="text-center">
                            <i class="far fa-file-code d-block" style="font-size: 4em;"></i>
                            <span style="font-size: 2.5em;"><?php echo Post::count_all(); ?><small>posts</small></span>
                        </div>
                    </a>
                </div>
                <div class="col-sm-4 my-5">
                    <div class="text-center">
                        <i class="far fa-calendar-check d-block" style="font-size: 4em;"></i>
                        <?php
                        $sql = "SELECT date FROM post ORDER BY date DESC LIMIT 1";
                        $last_post = Post::find_by_query($sql);
                        ?>
                        <small>last posted </small><span style="font-size: 2.5em;"><?php echo date("n/j", strtotime($last_post[0]->date)); ?></span>
                    </div>
                </div>
            </div>

            <!-- GOOGLE PIECHART -->
            <div class="row">
                <div class="col-12">
                    <div id="piechart" style="height: 400px;">
                </div>
            </div>

        </div>
    </div>
</div>
  
  

<?php include("includes/footer.php"); ?>