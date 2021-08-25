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
                <h1 class="page-header">All Comments</h1>
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
                            $comments = Comment::find_all();                                
                            foreach ($comments as $comment) { 
                        ?>
                            <tr>    
                                <td><?php echo $comment->id; ?></td>
                                <td>
                                    <?php echo $comment->author; ?>
                                    <div class="action_links">
                                        <a class="delete_link" href="delete_comment.php?id=<?php echo $comment->id; ?>">Delete</a>
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