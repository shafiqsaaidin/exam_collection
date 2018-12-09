<?php
  include './header.php';
  include './navbar.php';
  include './sidenav.php';
  include 'database.php';
  require 'pdfparser-master/vendor/autoload.php';

  $string = array();

  // search query
  if (filter_has_var(INPUT_POST, 'search')) {
    $parser = new \Smalot\PdfParser\Parser();

    $file = $_POST['file'];
    $keyword1 = mysqli_real_escape_string($con, $_POST['keyword1']);
    $keyword2 = mysqli_real_escape_string($con, $_POST['keyword2']);
    $keyword3 = mysqli_real_escape_string($con, $_POST['keyword3']);
    $keyword4 = mysqli_real_escape_string($con, $_POST['keyword4']);
    $keyword5 = mysqli_real_escape_string($con, $_POST['keyword5']);
    
    
    $pdf    = $parser->parseFile($file);
    
    $text = $pdf->getText();
    
    $words = array($keyword1 , $keyword2 , $keyword3, $keyword4, $keyword5);

    foreach ($words as $word) {
      $string[] = substr_count($text, $word);
    }

    // echo $string;
  }
?>

  <div class="wrapper">
    <div class="wrapper-container">
      <div class="row">
        <h5>Keyword Analysis</h5>
  
        <br>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
          <div class="input-field">
            <select class="browser-default" name="file">
              <option value="" disabled selected>Choose your option</option>
              <?php
                $sql = "SELECT name, path FROM document";
                $result = mysqli_query($con, $sql);

                while ($row = mysqli_fetch_array($result)):
              ?>
                <option value="<?php echo $row['path']; ?>"><?php echo $row['name']; ?></option>
              <?php endwhile ?>
            </select>
          </div>
          
          <div class="row">
            <div class="input-field col s12 l4">
              <input placeholder="Keyword 1" type="text" name="keyword1">
            </div>
            <div class="input-field col s12 l4">
              <input placeholder="Keyword 2" type="text" name="keyword2">
            </div>
            <div class="input-field col s12 l4">
              <input placeholder="Keyword 3" type="text" name="keyword3">
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12 l6">
              <input placeholder="Keyword 4" type="text" name="keyword4">
            </div>
            <div class="input-field col s12 l6">
              <input placeholder="Keyword 5" type="text" name="keyword5">
            </div>
          </div>
          <button type="submit" class="btn blue right" name="search">search</button>
        </form>
        <br><br>
        
        <?php if (!empty($string)): ?>
          <h5>Search Result</h5>
          <ul class="collection">
            <li class="collection-item">File: <?php echo $_POST['file']; ?></li>
          </ul>
        <?php else: ?>
          <p>No data</p>
        <?php endif ?>
        <div class="chart-container">
          <canvas id="myChart" width="600" height="250"></canvas>
        </div>
        
      </div>
    </div>
  </div>

<?php 
  include './footer.php';
?>
<script>
$(function(){
  // pie chart
  var ctx = document.getElementById("myChart").getContext('2d');
  var myChart = new Chart(ctx, {
      type: 'pie',
      data: {
          labels: [
            <?php foreach ($words as $x): ?>
              "<?php echo $x; ?>",
            <?php endforeach ?>
          ],
          datasets: [{
              label: '# of Votes',
              data: [
                <?php foreach ($string as $y):?>
                  "<?php echo $y?>",
                <?php endforeach ?>
              ],
              backgroundColor: [
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
                  'rgba(255, 159, 64, 1)'
              ],
              borderWidth: 1
          }]
      },
      options: {

      }
  });
});  
</script>