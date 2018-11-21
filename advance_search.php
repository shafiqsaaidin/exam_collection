<?php
  include './header.php';
  include './navbar.php';
  include './sidenav.php';
  include 'database.php';
  require 'pdfparser-master/vendor/autoload.php';

  $output = '';

  // search text function
  function textSearch($doc, $word) {
    $parser = new \Smalot\PdfParser\Parser();
    $pdf    = $parser->parseFile($doc);
    
    $text = $pdf->getText();
    
    return substr_count($text, $word);
  }

  // search query
  if (filter_has_var(INPUT_POST, 'search')) {
    $file = $_POST['file'];
    $keyword = $_POST['keyword'];
    
    $output = textSearch($file, $keyword);
  }
?>

  <div class="wrapper">
    <div class="wrapper-container">
      <div class="row">
        <h5>Advance Search</h5>
        <p>Search keyword in file</p>
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
          
          <div class="input-field">
            <input placeholder="Enter Keyword" type="text" name="keyword">
          </div>
          <button type="submit" class="btn blue right" name="search">search</button>
        </form>
        <br><br>
        <h5>Search Result</h5>
        <?php if ($output != ''): ?>
          <ul class="collection">
            <li class="collection-item">File: <?php echo $_POST['file']; ?></li>
            <li class="collection-item">Word: <?php echo $_POST['keyword']; ?></li>
            <li class="collection-item">Result: <?php echo $output; ?></li>
          </ul>
          <p></p>
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