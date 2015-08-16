<?php

//remove before migrating to PROD
ini_set('display_errors','On');

try{
    $db = new PDO('sqlite:./database.db');
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  //  var_dump($db);
  //  die(); // That will stop the actual rest of the file from loading

} catch(Exception $e) {
//  echo 'Sorry, the connection to the DB was not successful.';
    echo $e->getMessage();
    die(); // That will stop the actual rest of the file from loading
}



?>