<?php

  require '../authenticate.php';
  require '../branding.php';

  $command='sh list_user.sh';

  $output1 =shell_exec($command);

  preg_match_all("/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/", $output1, $matches,PREG_PATTERN_ORDER);

  $user_count= sizeof($matches[0]);

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
            <h3 class="panel-title" title="Web Interface for Signup New users to QuIP."><span class="glyphicon glyphicon-file"></span>caMicroscope User List</h3>
         </div>
         <div class="panel-body">
            <div class="row">
               <div class="col-md-12">
                  <div class="form-group row">
                     <label class="col-sm-3 control-label">Current User List:</label>
                  </div>
                  <?php   for( $i = 0; $i<$user_count; $i++ ) { ?>
                  <form id='deleteUserForm' class="form-horizontal" name="deleteUserForm" action='deleteUser.php' method='post' accept-charset='UTF-8'>
                     <input id="email" type="hidden" name="email" value="<?php echo $matches[0][$i] ?>" >
                     <div class="form-group row">
                        <label  class="col-sm-8 control-label"><?php echo $matches[0][$i] ?></label>
                     </div>
                     <div class="form-group row">
                        <div class="col-sm-offset-3 col-sm-8">
                           <input id="submitButton" type="submit" value="Delete Above User" class="btn btn-sm btn-block btn-success" title="Delete Above User">
                        </div>
                     </div>
                  </form>
                  <?php } ?>
               </div>
            </div>
         </div>
         <div class="panel-body">
            <div class="row">
               <div class="col-md-12">
                  <div class="form-group row">
                     <label class="col-sm-3 control-label">Add User From Mongodb:</label>
                  </div>
                  <form id='addUserForm' class="form-horizontal" name="addUserForm" action='add_user_from_mongo.php' method='post' accept-charset='UTF-8'>
                     <div class="form-group row">
                        <div class="col-sm-offset-3 col-sm-8">
                           <input id="submitButton" type="submit" value="Add User From MongoDB" class="btn btn-sm btn-block btn-success" title="Add User From MongoDB">
                        </div>
                     </div>
                  </form>
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
