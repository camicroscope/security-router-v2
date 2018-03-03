<?php

  require '../authenticate.php';

  include_once("../camicroscope/api/Data/RestRequest.php");
  require_once 'HTTP/Request2.php';

  $config = require '../camicroscope/api/Configuration/config.php';

  $postUrl   = $config['postUser'];

  if (!empty($_SESSION['api_key'])) {
    $api_key = $_SESSION['api_key'];
  }

  $fname=$_POST['fname'];
  $lname=$_POST['lname'];
  $email=$_POST['email'];
  $email = strtolower($email);
  $username=$fname . $lname;
  $expirationDate='01/01/2020';
  $category="bindaas_user" ;

  $command='sh add_user.sh' . ' ' . $username . ' ' . $email . ' ' .  $expirationDate ;

  $output1 =shell_exec($command);
  $output1 = str_replace('"', "'", $output1);
  $errorPosition = strpos($output1, "error");

  if ($errorPosition > -1 ){
    $output = "error occured.";
  } else if ($errorPosition == false ) {
    $output = "done sucessfully.";
    $output1="Your input has been sucessfully added to Bindaas database!";
  } else
     $output = "done sucessfully.";

  //The JSON data.
  $u24_user = array(
     'fname' => $fname,
     'lname' => $lname,
	   'username' =>$username,
	   'email' => $email,
     'category' => $category
  );

	$url = $postUrl . "?api_key=".$api_key;
  $printres = "";
  $printres .= "posting data\n";
  $printres .=  $url;
  //print_r($url);

  $ch = curl_init();
  $headers= array('Accept: application/json','Content-Type: application/json');
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($u24_user, JSON_NUMERIC_CHECK));

  $result = curl_exec($ch);
  $printres .=  $result;

  if($result === false){
     $result =  curl_error($ch);
  }
  curl_close($ch);

  $printres .=  $result;
  $printres .=  "done";

  $rightposition = strpos($result, "{ 'count':'1'}");

  if ($rightposition > -1 ){
     $output2="Your input has been sucessfully added to MongoDB database!";
  } else if ($rightposition == false ) {
      $output2="Error occurs!";
  } else
     $output2 = $result;

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
                     <h3 class="panel-title" title="Web Interface for Signup New users to QuIP."><span class="glyphicon glyphicon-file"></span>caMicroscope User Signup</h3>
                 </div>
                 <div class="panel-body">
                   <code>
                     <?php echo $printres?>
                   </code>
                     <div class="row">
                         <div class="col-md-12">
                            Input Data:<br/>
                            User's First Name: "<?php echo $_POST["fname"] ?>"<br/>
                            User's Last Name: "<?php echo $_POST["lname"] ?>"<br/>
                            User's Gmail Address: "<?php echo $_POST["email"] ?>"<br/>
                            User Name: "<?php echo $username ?>"<br/>
                            Expiration Date: "<?php echo $expirationDate ?>"<br/>
                             -- Save user info to Bindaas --<br/>
                            <?php echo $output ?><br/>
                            <?php echo $output1 ?><br/>
                             -- Save user info to MongoDB --<br/>
                            Result: "<?php echo $output2 ?>"<br/>

                          </div>
                        <a href="index.php" class="waves-effect waves-light btn-large">Back to Admin Panel</a>
                     </div>
                 </div>
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
