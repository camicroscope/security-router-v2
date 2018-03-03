<?php
$config = require 'config.php';
require_once('security/trusted_app_client.php');

// need to duplicate some code from server.php to keep it independent
function get_api_key($email, $client) {
    try{
        $serverResponse = $client -> requestShortLivedKey($email);
        $serverResponse = json_decode($serverResponse , true);
        $apiKey = $serverResponse["api_key"];
        return $apiKey;
    }catch(Exception $e) {
        error_log("Unable to retrieve api_key for $email : " .$e->getMessage());
        return NULL;
    }
}

function renew_key(){
  global $config;
  $client = new TrustedApplicationClient();
  $client->initialize($config['trusted_id'], $config['trusted_secret'], $config['trusted_url']);
  $_SESSION["last_seen"] = time();
  try {
      $api_key = get_api_key($_SESSION["email"], $client);
      if (isset($api_key)) {
          $_SESSION["api_key"] = $api_key;
      }
  } catch(ErrorException $exception) {
      $exception;
      // TODO what to do with exceptions here
  }
}


// renew if last login is between 30 min and an hour old
$should_renew = ((time() - $_SESSION["last_seen"] < (60*60)) and (time() - $_SESSION["last_seen"] > (30*60)));
// if last request is over some amount of time ago...
if ($should_renew) {
  renew_key();
}
