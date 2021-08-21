<?php include "includes/db.php" ?>
<?php include "includes/header.php" ?>

<body>

    <?php include "includes/landing_navigation.php" ?>

    <div style="background-image:url(images/landing-background.jfif); background-repeat: no-repeat; background-size:cover">
        <!-- Page Content -->
        <div class="container">
            <div class="row">
                <div class="col-sm-6 mt-5">
                    <h1 class="bung pink"><span class="display-3">A</span>WESOME<br>INTERACTIVE LANGUAGE<br>LEARNING TOOL</h1>
                    <ul class="text-white mt-4">
                        <li><h4><i class="far fa-smile mr-2"></i>Completely FREE</h4></li>
                        <li><h4><i class="fas fa-rocket mr-2"></i>Study with people all over the world</h4></li>
                    </ul>
                </div>
               

                <!-- SIGNUP FORM -->
                <div class="col-sm-5 mt-5 p-5">
                <?php include "landing/signup_form.php" ?>                    
                
                
            </div>
        </div>
    </div>
    <?php include "includes/footer.php" ?>