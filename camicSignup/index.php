<?php
session_start();
require '../authenticate.php';
require '../branding.php';

require_once '../config/security_config.php';
$_SESSION["name"] = "quip";
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
          <a href="#!" class="brand-logo">
            <i class="microscope">
              <img src="../svg/camic_vector.svg" id="svg1" class="camic_logo" width="100%" height="100%" viewBox="0 0 640 480" preserveAspectRatio="xMaxYMax"/>
            </i>
            [*]<?php print $branding_title; ?>
          </a>
        </div>
      </nav>
    </div>

    <div id="modal1" class="modal modal-fixed-footer">
      <div class="modal-content">
        <div class="container">
          <h4> Add a User </h4>
          <form id='registerForm' class="form-horizontal" name="registerForm" action='registerNew.php' method='post' accept-charset='UTF-8'>
                <div class="input-field col s12">
                  <input id="fname" name="fname" type="text" class="validate">
                  <label for="fname">User's First Name</label>
                </div>
                <div class="input-field col s12">
                  <input id="lname" name="lname" type="text" class="validate">
                  <label for="lname">User's Last Name</label>
                </div>
                <div class="input-field col s12">
                  <input id="email" name="email" type="text" class="validate">
                  <label for="email">User's Gmail Address</label>
                </div>
                <button id="submitButton" type="submit" value="Add User" class="btn-large blue waves-effect waves-light btn" action="submit">
                Sign Up User <i class="material-icons right">person_add</i>
                </button>
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <a href="../index.php" class="modal-action modal-close waves-effect waves-green btn-flat ">Close</a>
      </div>
    </div>

    <div id="modal2" class="modal modal-fixed-footer">
      <div class="modal-content">
        <div class="container">
          <h4> Change Admin Password </h4>
          <form id='adminpw' class="form-horizontal" name="adminpw" action='updateAdminLogin.php' method='post' accept-charset='UTF-8'>
                <div class="input-field col s12">
                  <input id="oldpasswd" name="oldpasswd" type="password">
                  <label for="oldpasswd">Current Password</label>
                </div>
                <div class="input-field col s12">
                  <input id="newpasswd" name="newpasswd" type="password">
                  <label for="newpasswd">New Password</label>
                </div>
                <div class="input-field col s12">
                  <input id="newpasswd2" name="newpasswd2" type="password">
                  <label for="newpasswd2">Confirm New Password</label>
                </div>
                <button id="submitButton" type="submit" value="Change Password" class="btn-large blue waves-effect waves-light btn" action="submit">
                Change Password <i class="material-icons right">person_add</i>
                </button>
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Close</a>
      </div>
    </div>


    <main>
      <div class="container">
        <div class="row">
          <a href="#modal1">
            <div class="col s12 l6">
              <div class="card" id="view">
                <div class="top_bar">Add User</div>
                <div class="card-image">
                  <div class="darkimg">
                    <img src="../img/view.png">
                  </div>
                </div>
                <div class="card-content">
                  <p class="card-text flow-text">Sign up a New User for caMicroscope</p>
                </div>
              </div>
            </div>
          </a>
          <a href="#modal2">
            <div class="col s12 l6">
              <div class="card" id="view">
                <div class="top_bar">Change Admin Password</div>
                <div class="card-image">
                  <div class="darkimg">
                    <img src="../img/view.png">
                  </div>
                </div>
                <div class="card-content">
                  <p class="card-text flow-text">Change the password required to access this section</p>
                </div>
              </div>
            </div>
          </a>
          <a href="../camicSignup/user_list.php">
            <div class="col s12 l6">
              <div class="card" id="view">
                <div class="top_bar">List Users</div>
                <div class="card-image">
                  <div class="darkimg">
                    <img src="../img/view.png">
                  </div>
                </div>
                <div class="card-content">
                  <p class="card-text flow-text">A list of users who can access caMicroscope</p>
                </div>
              </div>
            </div>
          </a>
          <a href="../camicSignup/lymphSuperuser.php">
            <div class="col s12 l6">
              <div class="card" id="view">
                <div class="top_bar">Lymphocyte Superusers</div>
                <div class="card-image">
                  <div class="darkimg">
                    <img src="../img/view.png">
                  </div>
                </div>
                <div class="card-content">
                  <p class="card-text flow-text">Manage users with Lymphocyte Superuser Access</p>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>
    </main>
    <script>
    $('.modal').modal();
    </script>

    <div class="page-footer blue darken-4">
      <p style="color:white;">U24 CA18092401A1, <b>Tools to Analyze Morphology and Spatially Mapped Molecular Data</b>; <i>Joel Saltz
        PI</i> Stony Brook/Emory/Oak Ridge/Yale<br>NCIP/Leidos 14X138, <b>caMicroscope &ndash; A Digital Pathology
        Integrative Query System</b>; <i>Ashish Sharma PI</i> Emory/WUSTL/Stony Brook<br />
      </p>
    </div>
  </body>
</html>
