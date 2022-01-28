<?php include_once 'database_hand.php'; 
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $age = $_POST['age'];
  $relation = $_POST['relation'];
  $gender = $_POST['gender'];
  
  $identification = $_POST['identification'];
  $isValid = true;

  $sql_select = "SELECT * FROM family;";
  $data = mysqli_query($connection, $sql_select);
  
  if( !$identification ){
    while( $row = mysqli_fetch_assoc($data) ){
      if( $row['first_name'] == $first_name && $row['last_name'] == $last_name ){
        $isValid = false;
        header("Location: ../index.php?error=duplicity&fn=$first_name&ln=$last_name&age=$age&rel=$relation&gen=$gender");
      }
    } 
  }

  if( $isValid ){
    if( !$identification ){
      $sql = "INSERT INTO family(first_name, last_name, age, relation, gender, identification) 
            VALUES('$first_name', '$last_name', '$age', '$relation', '$gender', null);";
    }
    else{
      $sql = "INSERT INTO family(first_name, last_name, age, relation, gender, identification) 
            VALUES('$first_name', '$last_name', '$age', '$relation', '$gender', '$identification');";
    }
    mysqli_query($connection, $sql);
    header("Location: ../index.php");
  }
?>