<?php include "includes/admin_header.php"; ?>

<div id="wrapper">


    <!-- Navigation -->
    <?php include "includes/admin_navigation.php"; ?>


    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome to admin!
                        <small>Author</small>
                    </h1>

                    <div class="col-sm-6">

                        <?php //ADD CATEGORIES FUNCTION
                                insertCategories(); ?>
                        
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="cat_title">Add Category</label>
                                    <input type="text" name="cat_title" class="form-control">
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="submit" class="btn btn-success" value="Add Category">
                                </div>
                            </form>

                        <?php

                        if(isset($_GET["edit"])){   //IF 'EDIT' BUTTON IS CLICKED..
                            $edit_id = $_GET["edit"];
                            // CREATE EDIT FORM FUNC
                            createEditForm();
                        }
                        
                        // UPDATE FCATEGORIES FUNC
                        updateCategories();

                        ?>
                    </div>      

                    <div class="col-sm-6">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td>Id</td>
                                    <td>Category</td>
                                </tr>
                            </thead>
                            <tbody>

                                <?php //CREATE CATEGORIES TABLE FUNC
                                createCategoriesTable(); ?>

                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

    <?php include "includes/admin_footer.php"; ?>