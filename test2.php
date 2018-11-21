<?php 
  // Include 'Composer' autoloader.
  require 'pdfparser-master/vendor/autoload.php';

  $parser = new \Smalot\PdfParser\Parser();
  $pdf    = $parser->parseFile('exam.pdf');
  
  $text = $pdf->getText();
  
  echo substr_count($text, 'Architectural');

?>