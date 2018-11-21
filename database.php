<?php
  $server = 'localhost';
  $username = 'root';
  $password = '';
  $db = 'secorpus';

  // create connection
  $con = new mysqli($server, $username, $password, $db);

  // check connection
  if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
  }

  // echo "Connected";
?>