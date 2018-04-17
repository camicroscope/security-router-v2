<?php

  //require '../authenticate.php';

  ini_set('display_errors', 'On');
  error_reporting(E_ALL | E_STRICT);

  require_once 'HTTP/Request2.php';
  include_once("../camicroscope/api/Data/RestRequest.php");
  $config = require '../camicroscope/api/Configuration/config.php';

  $getUrl   = $config['findAllBindaasUsers'];

  if (!empty($_SESSION['api_key'])) {
    $api_key = $_SESSION['api_key'];
  }

  $getUrl  = $getUrl . "api_key=" . $api_key;
  $url=$getUrl;
  //echo $url;

  $getRequest = new RestRequest($url,'GET');

  $response=$getRequest->execute();

  $emailList = $getRequest->responseBody ;
  //echo $emailList;
  //print_r($emailList);
  $emaillist2 = json_decode($emailList,true);

  //echo "\r\n";
  print_r($emaillist2);
 // echo "\r\n";
  //print_r($emailList[0]["email"]);
  //echo "\r\n";

  $findUser=true;

  if($emaillist2)
     $findUser=true;
  else
     $findUser=false;

 // existing user in bindaas
  $command='sh list_user.sh';
  $output1 =shell_exec($command);
  preg_match_all("/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/", $output1, $matches,PREG_PATTERN_ORDER);
  $user_count= sizeof($matches[0]);


  if($findUser){
     foreach ($emaillist2 as $person) {

      $mongo_email = $person["email"] ;
      $oldEmail=false;
      for( $i = 0; $i<$user_count; $i++ ) {
         $bindaas_email= $matches[0][$i] ;
         if ( $mongo_email == $bindaas_email){
           $oldEmail=true;
         }
       }

      if(!$oldEmail){
        $fname=$person["fname"];
        $lname=$person['lname'];
        $username=$person['username'];
        $expirationDate='01/01/2020';
        $command='sh add_user.sh' . ' ' . $username . ' ' . $mongo_email . ' ' .  $expirationDate ;
        $output1 =shell_exec($command);
        $output1 = str_replace('"', "'", $output1);
        $errorPosition = strpos($output1, "error");

        if ($errorPosition > -1 ){
          $output = "error occured.";
        } else if ($errorPosition == false ) {
           $output = "done sucessfully.";
        } else {
          $output = "done sucessfully.";
        }
        echo $output ;
      }
   }

  }


 header('Location: user_list.php');
 exit;

 ?>
