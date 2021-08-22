<footer class="mt-5 py-3">
    <div class="text-right mr-5">
        <span>&copy; Notebook 2021</span>
    </div>
</footer>
<!-- jQuery -->
<script src="./js/jquery.js"></script>
<!-- Custom JS -->
<script src="./js/script.js"></script>

  
<!-- Summernote-->
<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>



  <!-- Include GOOGLE CHART -->
  <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['HTML', <?php echo count(Post::find_post_by_cat(1)); ?>],
          ['CSS', <?php echo count(Post::find_post_by_cat(2)); ?>],
          ['Javascript', <?php echo count(Post::find_post_by_cat(3)); ?>],
          ['jQuery', <?php echo count(Post::find_post_by_cat(4)); ?>],
          ['Bootstrap', <?php echo count(Post::find_post_by_cat(5)); ?>],
          ['PHP', <?php echo count(Post::find_post_by_cat(6)); ?>],
          ['Laravel', <?php echo count(Post::find_post_by_cat(7)); ?>] 
          ['Other', <?php echo count(Post::find_post_by_cat(8)); ?>] 
        ]);

        var options = {
          title: 'Post Category',
          titleTextStyle: {color: 'gray'},
          //backgroundColor: '#130E1B',
          legend: {position: 'bottom', textStyle: {color: 'gray'}},          
          pieSliceText: 'label',          
          is3D: true,
          colors:['#FAB26A','#68E7FA', '#F5FA68', '#68BBFA', '#A868FA', '#6D68FA', '#FA6A6A', '#FA6AE2']
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>




  </body>

  </html>