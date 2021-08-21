<!-- LOGIN MODAL -->
<div class="modal fade" id="loginModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Login</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form action="includes/login.php" method="post">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input name="username" type="text" class="form-control" placeholder="Enter username" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input name="password" type="password" class="form-control" placeholder="Enter password">
                    </div>
                    <div class="text-center">
                        <input type="submit" name="login" class="btn btn-light" value="Submit">
                    </div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <a href="">Forgot password?</a>
            </div>
        </div>
    </div>
</div>



<nav class="navbar navbar-expand text-white sticky-top">
    <a class="navbar-brand" href="index.php">
        <img src="images/dialang.png" alt="dialang logo" style="width:100px;">
    </a>

    <ul class="nav navbar-nav mr-auto">
        <li class="nav-item mx-3">
            <a class="nav-links" href="./index.php?source=add_post"><i class="fas fa-pencil-alt"></i></a>
        </li>
        <li class="nav-item mx-3">
            <a class="nav-links" href=""><i class="fas fa-check"></i></a>
        </li>
    </ul>

    <ul class="nav navbar-nav">  
        
        <?php
        if(isset($_SESSION["user_name"])){
        ?> 
        <!-- HOME -->
        <li class="nav-item mx-2 align-self-center">          
            <a class="nav-links" href="mypage.php"><i class="fas fa-home"></i></a>
        </li>
        <!-- ALERT / DROPDOWN -->
        <li class="dropdown mx-2 align-self-center">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fas fa-bullhorn"></i><b class="caret"></b></a>
            <ul class="dropdown-menu alert-dropdown">
                <li>
                    <a href="#">Alert Name</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">View All</a>
                </li>
            </ul>
        </li>    
        <!-- PROFILE / MYPAGE  -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                <img src="images/<?php echo $_SESSION["user_image"];?>" alt="" style="width:40px;" class="img-fluid rounded-circle">
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="./mypage.php"><i class="mr-2 fas fa-check"></i>My Page</a>
                <a class="dropdown-item" href="./mypage.php"><i class="mr-2 fas fa-book-open"></i>Note</a> 
                <a class="dropdown-item" href="./mypage.php?source=wordlist"><i class="mr-2 fas fa-list-ul"></i>Word List</a>
                <a class="dropdown-item" href="./mypage.php"><i class="mr-2 fas fa-heart"></i>Favourites</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="./mypage.php?source=setting"><i class="mr-2 fas fa-cog"></i>Setting</a>
                <a class="dropdown-item" href="includes/logout.php"><i class="mr-2 fas fa-sign-out-alt"></i>Log Out</a>
            </div>
        </li>
        <?php }else{ ?>
            
        <li class="nav-item align-self-center mx-3" data-toggle="modal" data-target="#loginModal">
            <span class="cursor">Login</span>
        </li>
        <?php
        } ?>
    </ul>
</nav>