<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()){ redirect("./admin/login.php"); } ?>
<?php

$comments = Comment::find_the_comments($_GET['id']);

?>


<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="background: rgb(34,193,195); background: linear-gradient(0deg, rgba(34,193,195,1) 0%, rgba(253,187,45,1) 100%);">
    <?php include("includes/top_nav.php"); ?>
    <?php include("includes/side_nav.php"); ?>
</nav>


<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Comments                    
                </h1>
                <p class="bg-success"><?php echo $message; ?></p>
                
                <div class="col-md-12">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Author</th>
                                <th>Body</th>
                            </tr>
                        </thead>
                        <tbody>                            
                        <?php                             
                            foreach ($comments as $comment) { 
                        ?>
                            <tr>    
                                <td><?php echo $comment->id; ?></td>
                                <td>
                                    <?php echo $comment->author; ?>
                                    <div class="action_links">
                                        <a href="delete_comment_photo.php?id=<?php echo $comment->id; ?>">Delete</a>
                                        <!--<a href="edit_comment.php?id=<?php// echo $comment->id; ?>">Edit</a>-->
                                    </div>                            
                                </td>

                                <td><?php echo $comment->body; ?></td>
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