<nav class="navbar navbar-light bg-light navbar-expand sticky-top">

    <a class="navbar-brand" href="../index.php">NoteBook</a>

    <ul class="navbar-nav nav_for_big">
        <li class="nav-item">
            <a class="nav-link" href="./create_post.php"><i class="fas fa-pencil-alt"></i></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./index.php">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./all_posts.php">All Posts</a>
        </li>
        <?php
        if($session->is_signed_in()){
            echo "<li>
                    <a class='nav-link' href='./logout.php'>Log Out</a>
                </li>";
        }else{
            echo "<li>
                    <a class='nav-link' href='./login.php'>Log In</a>
                </li>";
        }
        ?>
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
        <li>
            <a class="nav-link" href="./create_post.php"><i class="fas fa-pencil-alt"></i></a>
        </li>
        <li>
            <a class="nav-link" href="./index.php">Dashboard</a>
        </li>
        <li>
            <a class="nav-link" href="./all_posts.php">All Posts</a>
        </li>
        <?php
        if($session->is_signed_in()){
            echo "<li>
                    <a class='nav-link' href='./logout.php'>Log Out</a>
                </li>";
        }else{
            echo "<li>
                    <a class='nav-link' href='./login.php'>Log In</a>
                </li>";
        }
        ?>
        
    </ul>
</div>