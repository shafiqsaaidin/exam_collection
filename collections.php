<?php
  include './header.php';
  include './navbar.php';
  include './sidenav.php';
  include 'database.php';

  // File upload
  if (filter_has_var(INPUT_POST, 'file_upload')) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $subject = mysqli_real_escape_string($con, $_POST['subject']);
    $year = mysqli_real_escape_string($con, $_POST['year']);
    $topic = mysqli_real_escape_string($con, $_POST['topic']);
    $file = $_FILES['file'];

    // file properties
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.', $fileName);
    $fileActulExt = strtolower(end($fileExt));
    $allowed = array('pdf');

    if (in_array($fileActulExt, $allowed)) {
      if ($fileError === 0 ) {
        if ($fileSize < 500000) {
          $fileNameNew = uniqid('', true).".".$fileActulExt;
          $fileDestination = 'files/'.$fileNameNew;

          // sql query
          $sql = "INSERT INTO `document` (name, subject, year, path, topic, date)
          VALUE ('$name', '$subject', '$year', '$fileDestination', '$topic', CURRENT_TIMESTAMP)";

          if ($con->query($sql) === TRUE) {
            echo "
            <script>
              $(function(){
                M.toast({html: 'Upload complete'})
              });  
            </script>";
            // move the file to destination folder
            move_uploaded_file($fileTmpName, $fileDestination);
          } else {
            echo "Error: " . $sql . "<br>" . $con->error;
          }
        } else {
          echo "
          <script>
            $(function(){
              M.toast({html: 'Your file is too big!'})
            });  
          </script>";
        }
      } else {
        echo "
        <script>
          $(function(){
            M.toast({html: 'There was an arror uploading your file!'})
          });  
        </script>";
      }
    } else {
      echo "
      <script>
        $(function(){
          M.toast({html: 'File not supported'})
        });  
      </script>";
    }
  }
  
  // Delete file
  if (isset($_REQUEST['id'])) {
    $id = mysqli_real_escape_string($con, $_REQUEST['id']);
    $sql = "DELETE FROM `document` WHERE `id`='$id'";
    
    if ($con->query($sql) === TRUE) {
      echo "
      <script>
        $(function(){
          M.toast({html: 'Delete completed'});
          setTimeout(function(){
            window.location = 'collections.php';
          }, 1000);
        });  
      </script>";
    } else {
      echo "
      <script>
        $(function(){
          M.toast({html: 'Error while delete!'});
          setTimeout(function(){
            window.location = 'collections.php';
          }, 1000);
        });  
      </script>";
    }
  }

  // $con->close();
?>
  <div class="wrapper">
    <div class="wrapper-container">
      <div class="row">
        <div class="col s12 m6"></div>
        <div class="col s12 m6">
          <input id="search" placeholder="Search File" type="text">
        </div>
      </div>
      <br>

      <!-- Upload Modal Trigger -->
      <div class="fixed-action-btn">
        <a href="#modal1" class="btn-floating btn-large blue modal-trigger tooltipped" data-position="top" data-tooltip="Upload New File">
          <i class="large material-icons">cloud_upload</i>
        </a>
      </div>

      <!-- Modal Structure -->
      <div id="modal1" class="modal">
        <div class="modal-content">
          <h4 class="blue-text">File Upload</h4>
          <div class="row">
            <form enctype="multipart/form-data" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
              <div class="row">
                <div class="input-field col s6">
                  <input id="file_name" type="text" name="name">
                  <label for="file_name">File Name</label>
                </div>
                <div class="input-field col s6">
                  <input id="subject" type="text" name="subject">
                  <label for="subject">Subject</label>
                </div>
              </div>

              <div class="row">
                <div class="input-field col s6">
                  <input id="year" type="number" name="year">
                  <label for="year">Year</label>
                </div>

                <div class="input-field col s6">
                  <input id="topic" type="text" name="topic">
                  <label for="topic">Topic</label>
                </div>
              </div>

              <div class="file-field input-field">
                <div class="btn blue white-text">
                  <span>Choose</span>
                  <input type="file" name="file">
                </div>
                <div class="file-path-wrapper">
                  <input class="file-path validate" type="text" placeholder="Select your file">
                </div>
              </div>

              <button type="submit" class="modal-close waves-effect btn blue white-text right" name="file_upload">Submit</button>
            </form>
          </div>
        </div>
        <div class="modal-footer">
          <a href="#!" class="modal-close btn-flat">Close</a>
        </div>
      </div>

      <table id="myTable" class="striped">
        <thead class="blue white-text">
          <tr class="myHead">
            <th>#</th>
            <th>Name</th>
            <th>Subject</th>
            <th>Topic</th>
            <th>Year</th>
            <th>Date Upload</th>
            <th>Uploaded by</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $i = 1;
            $sql = "SELECT * FROM `document`";
            $result = mysqli_query($con, $sql);
            while ($row = mysqli_fetch_array($result)):
          ?>
            <tr>
              <td><?php echo $i; $i++; ?></td>
              <td><a href="<?php echo $row['path']; ?>" target="_blank"><?php echo $row['name']; ?></a></td>
              <td><?php echo $row['subject']; ?></td>
              <td><?php echo $row['topic']; ?></td>
              <td><?php echo $row['year']; ?></td>
              <td><?php echo $row['date']; ?></td>
              <td><?php echo $row['user_id']; ?></td>
              <td class="right">
                <a href="file_edit.php?id=<?php echo $row['id']; ?>" class="tooltipped modal-trigger" data-position="top" data-tooltip="Edit">
                  <i class="material-icons blue-text">edit</i>
                </a>
                <a href="collections.php?id=<?php echo $row['id']; ?>" onclick="return confirm(`Delete this file ?`);" class="tooltipped" data-position="top" data-tooltip="Delete">
                  <i class="material-icons red-text right">delete</i>
                </a>
              </td>
            </tr>
          <?php endwhile ?>
        </tbody>
      </table>
    </div>
  </div>


<?php 
  include './footer.php';
?>