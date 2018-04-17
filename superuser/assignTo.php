<?php 

  require '../authenticate.php';

  include_once("../camicroscope/api/Data/RestRequest.php");
  require_once 'HTTP/Request2.php';

  $config = require '../camicroscope/api/Configuration/config.php';

  $updateUrl   = $config['imageAssignTo']; 

  if (!empty($_SESSION['api_key'])) {
    $api_key = $_SESSION['api_key'];
  }

  $case_id=$_POST['case_id'];
  $assign_to=$_POST['assign_to'];
  
  //echo $assign_to;

  if($assign_to=='-- Select an Email --' or empty($case_id)){
    header("Location: index.php");
    exit();
  } else {
    $updateUrl = $updateUrl . "api_key=".$api_key . "&case_id=".$case_id. "&assign_to=".$assign_to;
    //print_r($updateUrl); 
    $curl = curl_init($updateUrl);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json',"OAuth-Token: $token"));
    $response = curl_exec($curl);
       
    header("Location: index.php");

    exit();
 }
?>
