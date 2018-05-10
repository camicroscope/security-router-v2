<?php

  //require '../authenticate.php';
  $base_config = require '../config.php';

  $email=$_POST['email'];

  $command='sh delete_user.sh'. ' ' . $email . ' '. $base_config['trusted_secret'] . ' ' . $base_config['trusted_url'];

  $output =shell_exec($command);

  //print_r($output);

  header('Location: user_list.php');
  exit;

?>
