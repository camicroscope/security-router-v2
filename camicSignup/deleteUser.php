<?php

  //require '../authenticate.php'; 

  $email=$_POST['email'];

  $command='sh delete_user.sh'. ' ' . $email;

  $output =shell_exec($command);

  //print_r($output);

  header('Location: user_list.php');
  exit;

?>
