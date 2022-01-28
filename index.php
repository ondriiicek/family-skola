<?php include_once 'php_partials/database_hand.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="referrer" content="strict-origin" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.lineicons.com/3.0/lineicons.css" rel="stylesheet">
  <link rel="stylesheet" href="css/normalize/normalize.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <title>Document</title>
</head>
<body>
<main class="familyMainBg">
  <?php 
    $order = 'DESC';

    //Vyhladavanie podla Krstneho mena
    if(isset($_POST["search"])){
      $name = $_POST["first_name"];
      $sql_query = "SELECT * FROM family WHERE first_name = '$name';";
    }
    //Zoradenia podla veku || krstneho mena || priezviska
    elseif(isset($_GET["sort"])){
      $sort_by = $_GET["sort"];
      $order = $_GET["order"];
      $sql_query = "SELECT * FROM family ORDER BY $sort_by $order";
    }
    else{
      $sql_query = "SELECT * FROM family;";
    }
    $data = mysqli_query($connection, $sql_query);
    $data_check = mysqli_num_rows($data);
  ?>

  <div class="familyContainer">
    <?php 
      if( $data_check > 0 ){
        echo '<form action="?search" method="POST" class="searchForm">
                <input type="text" name="first_name" class="searchBar" placeholder="Krstné meno">
                <input type="submit" name="search" value="Vyhľadať" class="searchSubmit">
              </form>
        ';
        echo '<div class="sortingPart">';
      
          $order == 'DESC' ? $order = 'ASC' : $order = "DESC";
          echo '<a>Zoradiť podľa</a>';
          echo'<a href="?sort=age&&order='.$order.'">Veku</a>';
          echo'<a href="?sort=first_name&&order='.$order.'">Mena</a>';
          echo'<a href="?sort=last_name&&order='.$order.'">Priezviska</a>';

        echo '</div>';
      }
    ?>
  
    <?php
      if(isset($_GET['error'])){
        echo'
          <div class="echoOverlay">
            <h1>Rodinný príslušník existuje</h1>
            <a class="showInput"> Pridať Rodné číslo</a>
            <a href="index.php" class="backBtn">Späť</a>
          </div>';
      }
    ?>
    <section class="myFamily"> 
      <?php
        if( $data_check > 0 ){
          while( $row = mysqli_fetch_assoc($data) ){
            echo '<section class="familyCard">';
            echo'<div class="buttonContainer">
                  <a href="php_partials/delete.php?delete='.$row['id'].'">X</a>
                 </div>';
            if( $row['gender'] == 'Muz'){
              if( $row['age'] >= 18 ){
                echo '<img src="img/man.png" alt="" class="familyImage">';
              }
              else{
                echo '<img src="img/boy.png" alt="" class="familyImage">';
              }
            }
            else if( $row['gender'] == 'Zena' ){
              if( $row['age'] >= 18 ){
                echo '<img src="img/woman.png" alt="" class="familyImage">';
              }
              else{
                echo '<img src="img/girl.png" alt="" class="familyImage">';
              }
            }
            echo'  
              <h3><span>Meno: </span>'.$row['first_name'].'</h3>
              <h3><span>Priezvisko : </span>'.$row['last_name'].'</h3>
              <p><span>Vek: </span>'.$row['age'].'</p>
              <p><span>Pribuzenstvo: </span>'.$row['relation'].'</p>
            ';
            if( $row['identification'] == null ){
              echo'<p><span>RČ: </span>Nezadané</p>';
            }
            else{
              echo'<p><span>RČ: </span>'.$row['identification'].'</p>';
            }
            echo'</section>';
          }
        }
      ?>
    </section>
    <?php
      if(isset($_POST["search"])){
        echo'<a class="backToMain" href="index.php"> späť</a>';
      }
      else{
        echo'<a class="showInput"> Pridať Člena</a>';
      }
    ?>
    <div class="overlay">
      <form action="php_partials/insert.php" method="POST" class="familyForm" >
        <?php 
          if(isset($_GET['error'])){
            echo' 
                  <input type="text" name="first_name" placeholder="Krstne meno" value="'.$_GET["fn"].'">
                  <input type="text" name="last_name" placeholder="Priezvisko" value="'.$_GET["ln"].'">
                  <input type="text" name="age" placeholder="Vek" value="'.$_GET["age"].'">
                  <input type="text" name="relation" placeholder="Príbuzenstvo" value="'.$_GET["rel"].'">
                  <input type="text" name="identification" placeholder="Rodné číslo"> 
                ';

            $checked_male = '';
            $checked_female = '';

            if( $_GET["gen"] == 'Muz' ){
              $checked_male = 'checked';
            }
            else{
              $checked_female = 'checked';
            }

            echo'
              <input type="radio" name="gender" id="male" value="Muz" '.$checked_male.'>
              <label for="male">Muž</label>
              <input type="radio" name="gender" id="female" value="Zena" '.$checked_female.'>
              <label for="female">Žena</label>
            ';

          }
          else{
            echo'
                  <input type="text" name="first_name" placeholder="Krstné meno">
                  <input type="text" name="last_name" placeholder="Priezvisko">
                  <input type="text" name="age" placeholder="Vek">
                  <input type="text" name="relation" placeholder="Príbuzenstvo">
                  <input type="radio" name="gender" id="male" value="Muz">
                  <label for="male">Muž</label>
                  <input type="radio" name="gender" id="female" value="Zena">
                  <label for="female">Žena</label>
            ';
          }
        ?>
        <button type="submit" name="submit" id="submitMember"><span>+</span> Pridat Clena</button>
      </form>
    </div>
  </div>
</main>
  <script src="https://code.iconify.design/2/2.0.3/iconify.min.js"></script>
  <script src="js/showInput.js"></script>
  <script src="js/enableButton.js"></script>
</body>
</html>
