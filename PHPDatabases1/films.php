<?php

require_once('database.php');

//check if an id is set
if(!empty($_GET['id'])){
  $film_id = intval($_GET['id']);
  
  try{
  //    $result = $db->query('select * from film where film_id = ' . $film_id);
      $result = $db->prepare('select * from film where film_id = ?');
      $result->bindParam(1, $film_id);
      $result->execute();

  } catch (Exception $e) {
      $e->getMessage();
      die();
  }

  $film = $result->fetch(PDO::FETCH_ASSOC);
  if($film == FALSE){
    echo 'Sorry, a film could not be found with the provided ID.';
    die();
  }
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

  <meta charset="UTF-8">
  <title>PHP Data Objects</title>
  <link rel="stylesheet" href="style.css">

</head>

<body id="home">

  <h1>Sakila Sample Database</h1>

  <h2>
    <?php 
      if(isset($film)){
        echo '<b>Title: </b>'. $film['title'] .'</br>';
        echo '<b>Film ID: </b>'. $film['film_id'].'</br>';
        echo '<b>Description: </b>'. $film['description'].'</br>';
        echo '<b>Release Year: </b> '. $film['release_year'].'</br>';
        echo '<b>Film Length (mins) : </b>'. $film['length'].'</br>';
//         print_r($film);
      }
    ?>
  </h2>
  

</body>

</html>


