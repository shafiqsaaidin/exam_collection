<?php 
  // Include 'Composer' autoloader.
  include 'database.php';
  require 'pdfparser-master/vendor/autoload.php';

  $pdf = '';
  $file = array();
  $parser = new \Smalot\PdfParser\Parser();

  $sql = "SELECT name, path FROM document";
  $result = mysqli_query($con, $sql);

  while ($row = mysqli_fetch_array($result)) {
    $file[$row[0]] = $row[1];
  }

  foreach ($file as $x => $y) {
    $pdf = $parser->parseFile($y);
    $text = $pdf->getText();
    echo $x . substr_count($text, 'software')."<br>";
  }

  


  // $text = $pdf->getText();
  
  // // echo substr_count($text, 'Architectural');

  // $words = "software";

  // foreach($words as $word) {
  //   // echo $word." occurance are ".substr_count($text, $word)." times <br />";
  //   $string .= $word." occurance are ".substr_count($text, $word)."<br>";
  // }

  // var_dump($string);

?>