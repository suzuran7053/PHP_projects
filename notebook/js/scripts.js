$(document).ready(function() {
    $(".ham").click(function() {
        $(".nav_for_small").css("width", "250px");
    })
    $(".closebtn").click(function() {
        $(".nav_for_small").css("width", "0px");
    })   

    
})


// WHY DO THE FOLLOWING ONES WORK ONLY ONCE????
$(".post").mouseenter(function(){
        $(this).addClass("animate__animated animate__pulse");
    })
$(".nav-link").mouseenter(function(){
    $(this).addClass("animate__animated animate__flipInX");
})






/* $(document).ready(function() {
    var user_href;
    var user_href_splitted;
    var user_id;
    var image_src;
    var image_src_splitted;
    var image_name;
    var photo_id;



    $(".modal_thumbnails").click(function() { // Target and click
        $("#set_user_image").prop('disabled', false); // Target the ID and set the particular attribute false

        // TO GET THE user_id
        user_href = $("#user-id").prop('href'); // Pull href out and assign it into a variable
        user_href_splitted = user_href.split("="); // Make an array splitting everything before = and after =
        user_id = user_href_splitted[user_href_splitted.length - 1]; // Finally get the user_id
        // TO GET THE image_name
        image_src = $(this).prop("src");
        image_src_splitted = image_src.split("/");
        image_name = image_src_splitted[image_src_splitted.length - 1]; // Finally get the image_name

        // Both attr() and prop() are used to get or set the value of the specified property of an element attribute
        // But attr() returns the default value (Original state) of a property whereas prop() returns the current value (Current state).
        photo_id = $(this).attr("data");
        $.ajax({
            url: "includes/ajax_code.php", // We will be sending all $_POST to the url
            data: { photo_id: photo_id },
            type: "POST",
            success: function(data) {
                if (!data.error) { // If the returned data doesn't have error message
                    $("#modal_sidebar").html(data); // Put data inside the html of #modal_sidebar
                }
            }
        })
    });

    $("#set_user_image").click(function() {
        $.ajax({
            url: "includes/ajax_code.php", // We will be sending all $_POST to the url
            data: { filename: image_name, user_id: user_id },
            type: "POST",
            success: function(data) {
                if (!data.error) { // If data doesn't have error message
                    $(".user_image_box a img").prop('src', data);
                }
            }
        });
    })


    $('#summernote').summernote({
        height: 300
    });

});


// Sidebar in edit_photo.php
$('.info-box-header').click(function() {
    $(".inside").slideToggle("fast");
    $('#toggle').toggleClass("glyphicon-menu-down glyphicon , glyphicon-menu-up glyphicon ");
})

// Confirm deletion in photos/users/comments.php
$(".delete_link").click(function() {
    return confirm("Are you sure you want delete this item?");
}) */