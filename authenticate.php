<?php
$config = require 'config.php';

// start sessions
session_start();

// renew sessions between 30 and 60 min old
require 'session_renewer.php';

if($config['disable_security']){
	 /* Disable authentication*/
	 $_SESSION["api_key"] = $config['api_key'];
	 $_SESSION["email"] = "viewer@quip"; //dummy user.
} else {
	if (!isset($_SESSION["api_key"])) {
	    session_unset();
	    header("Location:http://".$_SERVER["HTTP_HOST"].$config['folder_path']."index.php");
	}
}

/*
You can use this file to control access to any .php file
All you need to do is:
<?php
require('authenticate.php');
?>
<html>
  <head>
  </head>
  <body>
    hello
  </body>
</html>

*/
