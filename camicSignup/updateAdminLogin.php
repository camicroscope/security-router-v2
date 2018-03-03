<?php

  require '../authenticate.php';

  include_once('htpasswd.php');

  require_once 'HTTP/Request2.php';
  include_once("../camicroscope/api/Data/RestRequest.php");
  $config = require '../camicroscope/api/Configuration/config.php';


  if(!function_exists('hash_equals')) {
    function hash_equals($str1, $str2) {
    if(strlen($str1) != strlen($str2)) {
      return false;
    } else {
      $res = $str1 ^ $str2;
      $ret = 0;
      for($i = strlen($res) - 1; $i >= 0; $i--) $ret |= ord($res[$i]);
      return !$ret;
      }
    }
  }

  $getUrl   = $config['findAdmin'];

  if (!empty($_SESSION['api_key'])) {
    $api_key = $_SESSION['api_key'];
  }

  $getUrl  = $getUrl . "api_key=" . $api_key;
  $url=$getUrl;
  //echo $url;

  $getRequest = new RestRequest($url,'GET');
  $response=$getRequest->execute();
  $admin = $getRequest->responseBody ;
  $admin2 = json_decode($admin,true);
  //print_r($admin2);

  $oldPasswordStored = $admin2[0]['password'];
  //echo $oldPasswordStored;

  //$hashed_password = crypt('quip2017'); // let the salt be automatically generated
  //echo $hashed_password;
  //$encrpt_passwd='$1$JvoSPkuO$koIXFbLOxXkS4qjfPkChc1';

  $oldpasswd=$_POST['oldpasswd'];
  //$user_input='quip2016';
  //echo phpversion();

  /* You should pass the entire results of crypt() as the salt for comparing a
   password, to avoid problems when different hashing algorithms are used. (As
   it says above, standard DES-based password hashing uses a 2-character salt,
   but MD5-based hashing uses 12.) */

 $returnvalue0='';
 if (hash_equals($oldPasswordStored, crypt($oldpasswd, $oldPasswordStored)))
     $returnvalue0=0;
 else  $returnvalue0 = -1;

  // path to your .htpasswd file
  $htpasswd = new htpasswd('/etc/apache2/.htpasswd');

  $newpasswd=$_POST['newpasswd'];
  $newpasswd2=$_POST['newpasswd2'];

  $returnvalue =  strcmp($newpasswd,$newpasswd2);
  //$returnvalue0 =  strcmp($oldpasswd,$oldPasswordStored);

  if ($returnvalue0 != 0)
  { $message = "Your old password does NOT match the password in the database.";
    header('Location: error.php?message=' . $message);
    exit;
  }


  if ($returnvalue != 0)
  { $message = "Your new password is NOT the same! Please enter the same new password twice.";
    header('Location: error.php?message=' . $message);
    exit;
  }

  $htpasswd->user_delete('admin');
  $user="admin";
  //add new user
  //echo "add new user \n";
  $newpassword = $htpasswd->crypt_apr1_md5($newpasswd);
  //echo $newpassword ;

  $htpasswd->user_add($user,$newpassword)

  // A list of random user names
  //$users = array('$username');

  // Checking to see which users exist
  //foreach($users as $user)
	//echo "The username $user does ".($htpasswd->user_exists($user) ? 'exist' : 'not exist')."\n";

  // Trying to add all usernames with password 'apples'
	//foreach($users as $user)
  //echo "The username $user ".($htpasswd->user_add($user,'$youpassword') ? 'has been added' : 'already exists')."\n";

  // Trying to remove user 'santa'
  //echo "Removing user 'santa' if present\n";
  //$htpasswd->user_delete('santa');

  // Trying to update user innvo with new password 'oranges', will add user if they do not exist
  //if($htpasswd->user_update('innvo','oranges'))
  //echo "Updated password for 'innvo'\n";

?>


 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">

     <!--Import Google Icon Font-->
     <link href="../css/icons.css" rel="stylesheet">
     <link type="text/css" rel="stylesheet" href="../materialize/css/materialize.min.css"  media="screen,projection"/>
     <script type="text/javascript" src="../js/jquery-2.1.1.min.js"></script>
     <script type="text/javascript" src="../materialize/js/materialize.min.js"></script>
     <script src="https://apis.google.com/js/client:platform.js?onload=start" async defer></script>
     <link rel="stylesheet" href="../css/style.css">
     <title>[*]<?php print $branding_title; ?></title>
   </head>

   <body>
     <!--Import jQuery before materialize.js-->


     <div class="navbar-fixed">
       <nav class="blue darken-3">
         <div class="nav-wrapper">
           <a href="index.php" class="brand-logo">
             <i class="microscope">
               <img src="../svg/camic_vector.svg" id="svg1" class="camic_logo" width="100%" height="100%" viewBox="0 0 640 480" preserveAspectRatio="xMaxYMax"/>
             </i>
             [*]<?php print $branding_title; ?>
           </a>
         </div>
       </nav>
     </div>

     <main>
     <div class="container">
         <div class="spacerTop"></div>

         <div class="col-md-offset-1 col-md-10">
             <div class="panel panel-default">
                 <div class="panel-heading">
                     <h3 class="panel-title" title="Web Interface for Signup New users to QuIP."><span class="glyphicon glyphicon-file"></span>caMicroscope Admin Credential Update</h3>
                 </div>
                 <div class="panel-body">
                     <div class="row">
                         <div class="col-md-12">
                            Your user Name: "<?php echo $user ?>"<br/>
                            Your new password: "<?php echo $_POST['newpasswd'] ?>"<br/>
                            Your crypted new password: "<?php echo $newpassword ?>"<br/>
                            Your login credential has been updated!<br/>
                          </div>
                     </div>
                 </div>
                 <a href="index.php" class="waves-effect waves-light btn-large">Back to Admin Panel</a>
             </div>
         </div>
     </div>
   </div>
     </main>

     <div class="page-footer blue darken-4">
       <p style="color:white;">U24 CA18092401A1, <b>Tools to Analyze Morphology and Spatially Mapped Molecular Data</b>; <i>Joel Saltz
         PI</i> Stony Brook/Emory/Oak Ridge/Yale<br>NCIP/Leidos 14X138, <b>caMicroscope &ndash; A Digital Pathology
         Integrative Query System</b>; <i>Ashish Sharma PI</i> Emory/WUSTL/Stony Brook<br />
       </p>
     </div>
   </body>
 </html>
