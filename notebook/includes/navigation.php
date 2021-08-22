
<nav class="navbar navbar-dark bg-dark navbar-expand sticky-top" role="navigation">
　　<a class="navbar-brand" href="./index.php">NoteBook</a> 
    <ul class="navbar-nav nav_for_big">    
    <?php // GET CATEGORIES
        $categories = Category::find_all_cat();
        foreach($categories as $category){
            echo "<li><a class='nav-link' href='./view_category.php?id=$category->id'>$category->name</a></li>";
        }
    ?>
        <li class="nav-item">
            <a class="nav-link" href="./admin/index.php"><i class="fas fa-cog"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto ham">
        <li class="nav-item">
            <i class="fas fa-bars"></i>
        </li>
    </ul>
</nav>


<div class="nav_for_small">
    <ul class="text-light text-center">
        <li class="p-3 text-right">
            <span class="closebtn"><i class="fas fa-times mr-3"></i></span>
        </li>
        <?php // GET CATEGORIES
        $categories = Category::find_all_cat();
        foreach($categories as $category){
            echo "<li><a class='nav-link' href='./view_category.php?id=$category->id'>$category->name</a></li>";
        } ?>
        <li class="nav-item">
            <a class="nav-link" href="./admin/index.php"><i class="fas fa-cog"></i></a>
        </li>
    </ul>
</div>