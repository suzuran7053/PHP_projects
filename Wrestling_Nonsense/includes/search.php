<div class="row">

<?php
if(isset($_POST["search_submit"])){
    $keyword = $_POST["search_keyword"];
?>
    <div class="col-md-9" style="margin-top:50px;">        

<?php
    $query = "SELECT * ,";
    $query .= "users.user_id, users.user_name, users.user_image ";
    $query .= "FROM posts ";
    $query .= "INNER JOIN users ON posts.post_author_id = users.user_id ";
    $query .= "WHERE post_content LIKE '%$keyword%' ";
    $query .= "ORDER BY post_id DESC";

    $search_post = mysqli_query($dbc, $query);
    checkQuery($search_post);
    if(mysqli_num_rows($search_post) == 0){
        echo "<h1 class='font my-3'>No result for '" .$keyword. "'</h1>";
    }else{
        echo "<h1 class='font my-3'>Search Result for '".$keyword. "'</h1>
                <div class='row'>";                
            while ($row = mysqli_fetch_assoc($search_post)) {
            $post_id = $row["post_id"];
            $post_image = $row["post_image"];
            $post_title = $row["post_title"];
            $post_date = date("Y/n/j D",  strtotime($row["post_date"])); 
            $post_content = $row["post_content"];
            if(strlen($post_title)>15){
                $post_title = substr($post_title, 0, 17) .".."; 
            }
            if(strlen($post_content)>50){
                $post_content = substr($post_content, 0, 50) ."..."; 
            }
            $author_id = $row["user_id"];
            $author_name = $row["user_name"];
            $author_image = $row["user_image"];

    ?>
                <div class='col-lg-3 col-6'>
                    <a href='index.php?source=view_post&post_id=<?php echo $post_id; ?>'>
                        <div class='img_box'>
                            <img class='image-fluid' src='images/<?php echo $post_image; ?>' alt='<?php echo $post_title; ?>'>
                        </div>                                    
                        <h5 class='font-weight-bold'><small><?php echo $post_title; ?></small></h5>
                    </a>
                    <div class='text-right'>
                        <span style='font-size: 0.8em'><i class='fas fa-clock mr-1'></i><time><?php echo $post_date; ?></time></span>
                        <img class='image-fluid rounded-circle' src='images/<?php echo $author_image; ?>' alt='<?php echo $author_name; ?>' style='width: 20px;'>                   </div>
                    <a href='index.php?source=view_post&post_id=<?php echo $post_id; ?>'>
                        <p style='font-size: 0.8em'><?php echo $post_content; ?></p>
                    </a>
                </div>

    <?php
        }
    }
}
    ?>
        </div>
    </div>
</div>