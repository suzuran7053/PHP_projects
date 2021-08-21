

<!-- Modal -->
<div class="modal fade" id="delete_confirmation_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="float-right mr-3" style="font-size: 1.6em;">&times;</span>
            </button>
            <div class="modal-body">
                <h3 class="text-dark">Are you sure you want to delete this post?</h3>
            </div>
            <div class="modal-footer">
                <form method="post" action="">
                    <!--<input type="hidden" name="post_id" value="<?php echo $post_id; ?>">-->
                    <input class="btn btn-danger modal_delete_link" type="submit" name="delete" value="Delete">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </form> 
            </div>
        </div>
    </div>
</div>

<?php
    if(isset($_SESSION["user_id"])){
        $user_id = $_SESSION["user_id"];
    }else{
        //redirect("index.php");
    }

    if(isset($_POST["delete"])){
        $post_id = $_GET["post_id"];

        // GET "author_id" OF THE POST
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $query = "SELECT post_author_id FROM posts WHERE post_id = $post_id";
        $get_author_id_query = mysqli_query($dbc, $query);
        while ($row = mysqli_fetch_assoc($get_author_id_query)) {
            $post_author_id = $row["post_author_id"];
        }
        checkQuery($get_author_id_query);

        //ONLY THE AUTHOR CAN DELETE THE POST
        if($user_id = $post_author_id){
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $query = "DELETE FROM posts WHERE post_id = $post_id";
            $delete_post_query = mysqli_query($dbc, $query);
            checkQuery($delete_post_query);
            alert("POST DELETED");
            header("Location: index.php");
        }        
    }