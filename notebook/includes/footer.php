
<footer class="mt-5 py-3 bg-dark text-white">
    <div class="text-right mr-5">
        <span>&copy; Notebook 2021</span>
    </div>
</footer>


  <!-- jQuery -->
  <script src="./admin/js/jquery.js"></script>
  <!-- Custom JS -->
  <script src="./admin/js/script.js"></script>


  <!-- Include SUMMERNOTE js -->
  <!-- https://summernote.org/getting-started/#embed -->
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
  <script src="js/scripts.js"></script>
  
  <!-- Include GOOGLE CHART -->
  <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Views', 10 <?php //echo $session->count; ?>],
          ['Comments', <?php echo Comment::count_all(); ?>],
          ['Users', <?php echo User::count_all(); ?>],
          ['Photos', <?php echo Photo::count_all(); ?>]          
        ]);

        var options = {
          legend: 'none',  // the info on the right side
          pieSliceText: 'label',
          title: 'My Daily Activities',
          backgroundColor: 'translarent'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>







  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  </body>

  </html>