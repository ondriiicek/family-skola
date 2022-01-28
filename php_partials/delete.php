<?php
  include('database_hand.php');
  include('insert.php');

  if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $sqlQuery = "DELETE FROM family WHERE id = '$id';";
    mysqli_query($connection, $sqlQuery);
  }

  header("Location: ../index.php");