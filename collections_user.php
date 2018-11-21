<?php
  include './header.php';
  include './navbar.php';
  include './sidenav.php';
  include './database.php';
  
  // Delete file
  if (isset($_POST['delete'])) {
    $id = mysqli_real_escape_string($con, $_POST['doc_id']);
    $sql = "DELETE FROM `document` WHERE `id`='$id'";

    if ($con->query($sql) === TRUE) {
      echo "
      <script>
        $(function(){
          M.toast({html: 'Delete completed'})
        });  
      </script>";
    } else {
      echo "
      <script>
        $(function(){
          M.toast({html: 'Error while delete!'})
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

      <table id="myTable" class="highlight">
        <thead class="blue white-text">
          <tr class="myHead">
            <th>#</th>
            <th>Name</th>
            <th>Subject</th>
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
              <td><?php echo $row['year']; ?></td>
              <td><?php echo $row['date']; ?></td>
              <td><?php echo $row['user_id']; ?></td>
              <td>
                <form action="" method="POST">
                  <input type="hidden" name="doc_id" value="<?php echo $row['id']; ?>">
                  <div class="switch">
                    <label>
                      <input type="checkbox" class="filled-in"/>
                      <span>Save</span>
                    </label>
                  </div>
                </form>
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