<?php 
  include './header.php';
  // include './footer.php';

  function read_docx($filename, $keyword){

    $striped_content = '';
    $content = '';

    $zip = zip_open($filename);

    if (!$zip || is_numeric($zip)) return false;

    while ($zip_entry = zip_read($zip)) {

        if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

        if (zip_entry_name($zip_entry) != "word/document.xml") continue;

        $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

        zip_entry_close($zip_entry);
    }// end while

    zip_close($zip);

    $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
    $content = str_replace('</w:r></w:p>', "\r\n", $content);
    $striped_content = strip_tags($content);

    return substr_count($striped_content, $keyword);
  }

  // echo read_docx('exam.docx');
  
  if (isset($_POST['search'])) {
    $document = $_POST['document'];
    $keyword = $_POST['keyword'];

    echo read_docx($document, $keyword);
  }
?>
  <div class="container">
    <form action="" method="POST">
      <div class="input-field col s12">
        <select class="browser-default" name="document">
          <option value="" disabled selected>Choose Exam Paper</option>
          <option value="exam.docx">Exam 1</option>
          <option value="2">Exam 2</option>
          <option value="3">Exam 3</option>
        </select>
      </div>
      <div class="input-field col s12">
        <input type="text" placeholder="keyword" name="keyword">
      </div>
      <button type="submit" name="search" class="btn">Search</button>
    </form>
  </div>