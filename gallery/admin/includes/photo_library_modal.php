
<?php require_once("init.php"); ?>
<?php
$photos = Photo::find_all();
?>

<!-- PHOTO LIBRARY MODAL START HERE -->
<div class="modal fade" id="photo-library">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Gallery System Library</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-9">
                    <div class="thumbnails row">

                        <?php foreach ($photos as $photo) { ?>

                        <div class="col-xs-2">
                            <a role="checkbox" aria-checked="false" tabindex="0" id="" href="#" class="thumbnail">
                                <!-- It doesn't mean we definitely need to use 'data' attribute below to echo $photo->id. 
                                    We can use other HTML element and can hide it for example.
                                    We use this to get the particular photo's id using Jquery like "photo_id = $(this).attr("data");" [script.js] -->
                                <img class="modal_thumbnails img-responsive" src="<?php echo $photo->picture_path(); ?>" data="<?php echo $photo->id; ?>">
                            </a>
                            <div class="photo-id hidden"></div> <!-- Anything in here will be hidden. hidden is a pre-defined class-->
                        </div>

                        <?php } ?>

                    </div>
                </div>
                <!--col-md-9 -->

                <div class="col-md-3">
                    <div id="modal_sidebar">
                    </div>
                </div>

            </div>
            <!--Modal Body-->
            <div class="modal-footer">
                <div class="row">
                    <!--Closes Modal-->
                    <button id="set_user_image" type="button" class="btn btn-primary" disabled="true" data-dismiss="modal">Apply Selection</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- PHOTO LIBRARY MODAL END -->