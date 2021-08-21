<?php
echo "<div class='row'>";                

if(isset($_GET["cat_id"])){
    $cat_id = $_GET["cat_id"];
    showThisCategorysPosts($cat_id);       //カテゴリ別記事一覧
}

echo "</div>";
?>