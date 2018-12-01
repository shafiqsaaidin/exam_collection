<?php
  include './header.php';
  include './navbar.php';
  include './sidenav.php';
  include 'database.php';
  require 'pdfparser-master/vendor/autoload.php';

  // declare empty virable to store arrays of file
  $pdf = '';
  $output = array();

  // search query
  if (filter_has_var(INPUT_POST, 'search')) {
    $keyword = mysqli_real_escape_string($con, $_POST['keyword']);
    $parser = new \Smalot\PdfParser\Parser();

    $sql = "SELECT name, path, year FROM document";
    $result = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_array($result)) {
      $pdf = $parser->parseFile($row['path']);
      $text = $pdf->getText();
      $output[] = $row['name'] ." - " . $row['year'] . "<span class='blue white-text badge'>".substr_count($text, $keyword)."</span>"; 
    }
  }
    
?>

<div class="wrapper">
  <div class="wrapper-container">
    <h5>Search Keyword in all files</h5>
    <br>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
      <div class="input-field">
        <input id="keyword" type="text" name="keyword">
        <label for="keyword">Keyword</label>
      </div>
      <button type="submit" class="btn blue right" name="search">search</button>
    </form>
    <br>
    <br>
    <!-- Search Result -->
    <?php if (!empty($output)): ?>

      
      <ul class="collection with-header">
        <li class="collection-header blue white-text"><h5>Search Result : <span class="black-text"><?php echo $_POST['keyword']; ?></span></h5></li>
        <?php foreach ($output as $x): ?>
          <li class="collection-item"><?php echo $x; ?></li>
        <?php endforeach ?>
      </ul>
    <?php else: ?>
      <p>No data</p>
    <?php endif ?>
  </div>
</div>

<?php 
  include './footer.php';
?>