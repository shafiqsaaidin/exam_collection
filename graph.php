<?php
  include './header.php';
  // include './navbar.php';
  // include './sidenav.php';
  include 'database.php';
  include './footer.php';
?>
<div class="wrapper">
  <div class="wrapper-container">
    <div class="chart-container">
      <h5>Set 1</h5>
      <canvas id="set 1" width="600" height="250"></canvas>
      <br>

      <h5>Set 2</h5>
      <canvas id="set 2" width="600" height="250"></canvas>
      <br>

      <h5>Set 3</h5>
      <canvas id="set 3" width="600" height="250"></canvas>
      <br>

      <h5>Set 4</h5>
      <canvas id="set 4" width="600" height="250"></canvas>

      <script>
        $(function(){
          <?php 
            $sql = "SELECT * FROM graph";
            $result = mysqli_query($con, $sql);

            while ($row = mysqli_fetch_array($result)):
          ?>
            // bar chart
            var ctx = document.getElementById("<?php echo $row['set_name']; ?>");
            var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: ["Lecture 7", "Lecture 8", "Lecture 9", "Lecture 10", "Lecture 11", "Lecture 12"],
              datasets: [{
                label: '# Frequency',
                data: [
                  "<?php echo $row['lecture_7']; ?>",
                  "<?php echo $row['lecture_8']; ?>",
                  "<?php echo $row['lecture_9']; ?>",
                  "<?php echo $row['lecture_10']; ?>",
                  "<?php echo $row['lecture_11']; ?>",
                  "<?php echo $row['lecture_12']; ?>"
                ],
                backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(153, 102, 255, 0.2)',
                  'rgba(255, 159, 64, 0.2)',
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(153, 102, 255, 0.2)',
                  'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                  'rgba(255,99,132,1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(153, 102, 255, 1)',
                  'rgba(255, 159, 64, 1)',
                  'rgba(255,99,132,1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(153, 102, 255, 1)',
                  'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
              }]
            },
            options: {
              responsive: false,
              scales: {
                xAxes: [{
                  ticks: {
                    maxRotation: 90,
                    minRotation: 80
                  }
                }],
                yAxes: [{
                  ticks: {
                    beginAtZero: true
                  }
                }]
              }
            }
          });
          <?php endwhile ?>
        });
      </script>
    </div>
  </div>
</div>