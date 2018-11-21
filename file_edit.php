<?php 
  include './header.php';
  include './navbar.php';
  include './sidenav.php';
  include 'database.php';

  // handle the get request base on user id
  if (isset($_REQUEST['id'])) {
    $id = mysqli_real_escape_string($con, $_REQUEST['id']);
    $sql = "SELECT * FROM `document` WHERE `id`='$id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
  }

  if (isset($_POST['update'])) {
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $subject = mysqli_real_escape_string($con, $_POST['subject']);
    $year = mysqli_real_escape_string($con, $_POST['year']);

    $sql = "UPDATE `document` SET id='$id', name='$name', subject='$subject', year='$year' WHERE id='$id'";
    if (mysqli_query($con, $sql)) {
      echo "
      <script>
        $(function(){
          M.toast({html: 'Update completed'});
          setTimeout(function(){
            window.location = 'collections.php';
          }, 3000);
        });  
      </script>";
    } else {
      echo "
      <script>
        $(function(){
          M.toast({html: 'Update error'})
        });  
      </script>";
    }
  }
?>

<div class="wrapper">
  <div class="wrapper-container">
    <div class="row">
      <form enctype="multipart/form-data" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="row">
          <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
          <div class="input-field col s6">
            <input id="file_name" type="text" name="name" value="<?php echo $row['name']; ?>">
            <label for="file_name">File Name</label>
          </div>
          <div class="input-field col s6">
            <input id="subject" type="text" name="subject" value="<?php echo $row['subject']; ?>">
            <label for="subject">Subject</label>
          </div>
        </div>

        <div class="row">
          <div class="input-field col s6">
            <input id="year" type="number" name="year" value="<?php echo $row['year']; ?>">
            <label for="year">Year</label>
          </div>
          <div class="file-field input-field col s6">
            <div class="btn blue white-text">
              <span>Choose</span>
              <input disabled type="file" name="file">
            </div>
            <div class="file-path-wrapper">
              <input class="file-path validate" type="text" value="<?php echo $row['path']; ?>">
            </div>
          </div>
        </div>

        <a href="collections.php" class="btn white black-text">Back</a>
        <button type="submit" class="modal-close waves-effect btn blue white-text right" name="update">Update</button>
      </form>
    </div>
  </div>
</div>



<?php 
  include './footer.php';
?>