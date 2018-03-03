<?php
  require '../authenticate.php';
  require '../branding.php';
  ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--Import Google Icon Font-->
    <script type='text/javascript' src='gen_validatorv4.js'  xml:space="preserve"></script>
    <link href="../css/icons.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="../materialize/css/materialize.min.css"  media="screen,projection"/>
    <script type="text/javascript" src="../js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="../materialize/js/materialize.min.js"></script>
    <script src="https://apis.google.com/js/client:platform.js?onload=start" async defer></script>
    <link rel="stylesheet" href="../css/style.css">
    <title>[*]<?php print $branding_title; ?> Lymphocyte Superusers</title>
    <script src="../js/config.js"></script>
    <script src="../js/jquery.form.js"></script>
  </head>
  <body>
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
            <h3 class="panel-title" title="Lymphocyte App Superusers">Lymphocyte App Superusers</h3>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <form id='lymphFormAssign' class="form-horizontal" name="lymphFormAssign" action='../camicroscope/api/Data/lymphocyteSuperusers.php' method='post' accept-charset='UTF-8'>
                  <div class="input-field col s12">
                    <input id="emailAssign" name="emailAssign" type="text" class="validate">
                    <label for="emailAssign">User's Gmail Address</label>
                  </div>
                  <button id="submitButtonAssign" type="submit" value="Add User" class="btn-large blue waves-effect waves-light btn" action="submit">
                  Add Superuser <i class="material-icons right">person_add</i>
                  </button>
                </form>

                <div class="col-sm-offset-3 col-sm-9">
                  <h5 id="msgAssign" class="msg"></h5>
                </div>
                <form id='lymphFormRemove' class="form-horizontal" name="lymphFormRemove" action='../camicroscope/api/Data/lymphocyteSuperusers.php'  method='post' accept-charset='UTF-8'>
                  <div class="input-field col s12">
                    <input id="emailRemove" name="emailRemove" type="text" class="validate">
                    <label for="emailRemove">User's Gmail Address</label>
                  </div>
                  <button id="submitButtonRemove" type="submit" value="Remove User" class="btn-large blue waves-effect waves-light btn" action="submit">
                  Remove Superuser <i class="material-icons right">person_remove</i>
                  </button>
                </form>
                <div class="col-sm-offset-3 col-sm-9">
                  <h5 id="msgRemove" class="msg"></h5>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <script src="../js/lymph-superusers.js"></script>
  </body>
</html>
