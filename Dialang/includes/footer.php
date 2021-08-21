
<!-- Footer -->
<footer class="mt-5 py-3 bg-dark text-white">
    <div class="text-right mr-5">
        <span>&copy; Dialang 2021</span>
    </div>
</footer>



<script>
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

    //SIDEBAR SLIDE
    function closeMyMenu() {
        $('#myMenu').css('width', '0');
    }
    function openMyMenu() {
        $('#myMenu').css('width', '300px');
        //$('#main').css('transition', 'margin-left .5s');
        //padding: 20px;
    }
</script>

</body>

</html>