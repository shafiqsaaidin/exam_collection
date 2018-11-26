<?php
  include './header.php';
  include './navbar.php';
  include './sidenav.php';
  include 'database.php';

  // Delete data
  if (isset($_REQUEST['id'])) {
    $id = mysqli_real_escape_string($con, $_REQUEST['id']);
    $sql = "DELETE FROM `favourite` WHERE `id`='$id'";
    
    if ($con->query($sql) === TRUE) {
      echo "
      <script>
        $(function(){
          M.toast({html: 'Delete completed'});
          setTimeout(function(){
            window.location = 'favourite.php';
          }, 1000);
        });  
      </script>";
    } else {
      echo "
      <script>
        $(function(){
          M.toast({html: 'Error while delete!'});
          setTimeout(function(){
            window.location = 'favourite.php';
          }, 1000);
        });  
      </script>";
    }
  }
?>
<div class="wrapper">
  <div class="wrapper-container">
    <div class="row">
      <?php 
        $sql = "SELECT favourite.id, document.name, document.subject, document.topic, document.year, document.path
                FROM favourite
                INNER JOIN document ON favourite.doc_id = document.id";
        $result = mysqli_query($con, $sql);
        while ($row = mysqli_fetch_array($result)):
      ?>
        <div class="col s12 m4">
          <div class="card grey darken-1">
            <div class="card-content white-text">
              <span class="card-title"><?php echo $row['name']; ?></span>
              <p>Subject: <?php echo $row['subject']; ?></p>
              <p>Topic: <?php echo $row['topic']; ?></p>
              <p>Year: <?php echo $row['year']; ?></p>
            </div>
            <div class="card-action white">
              <a href="favourite.php?id=<?php echo $row['id']; ?>">
                <i class="material-icons red-text right">delete</i>
              </a>
              <a href="<?php echo $row['path'] ?>" target="_blank">
                <i class="material-icons blue-text right">pageview</i>
              </a>
            </div>
          </div>
        </div>
      <?php endwhile ?>
    </div>
  </div>
</div>
<?php 
  include './footer.php';
?>