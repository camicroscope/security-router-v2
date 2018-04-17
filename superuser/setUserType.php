<?php 

  require '../authenticate.php';

  include_once("../camicroscope/api/Data/RestRequest.php");
  require_once 'HTTP/Request2.php';

  $config = require '../camicroscope/api/Configuration/config.php';

  $updateUrl   = $config['setUserType']; 
  //print_r($updateUrl); 
  
  if (!empty($_SESSION['api_key'])) {
    $api_key = $_SESSION['api_key'];
  }

  $fname=$_POST['fname'];
  $lname=$_POST['lname'];
  $email=$_POST['email'];
  $userType=$_POST['userType'];
  
  $updateUrl = $updateUrl . "api_key=".$api_key . "&fname=".$fname. "&lname=".$lname. "&email=".$email. "&userType=".$userType;
  //print_r($updateUrl);
  $curl = curl_init($updateUrl);
  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
  curl_setopt($curl, CURLOPT_HEADER, false);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json',"OAuth-Token: $token"));
  $response = curl_exec($curl);
  //print_r($response);
       
  header("Location: index.php");

  exit();
 
?>