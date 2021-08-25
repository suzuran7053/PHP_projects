<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()){ redirect("./admin/login.php"); } ?>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <?php include("includes/top_nav.php"); ?>
        <?php include("includes/side_nav.php");?>
    </nav>


    <div id="page-wrapper">
        <?php include("includes/admin_content.php"); ?>        
    </div>

  <?php include("includes/footer.php"); ?>