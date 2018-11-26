<?php 
  // Include 'Composer' autoloader.
  require 'pdfparser-master/vendor/autoload.php';

  $string = '';

  $parser = new \Smalot\PdfParser\Parser();
  $pdf    = $parser->parseFile('files/5bfa6dce9195a5.35804514.pdf');
  
  $text = $pdf->getText();
  
  // echo substr_count($text, 'Architectural');

  $words = array("Architectural","software","engineer","design","plan");

  foreach($words as $word) {
    // echo $word." occurance are ".substr_count($text, $word)." times <br />";
    $string .= $word." occurance are ".substr_count($text, $word)."<br>";
  }

  var_dump($string);

?>