<?php

session_start();

$config = require '../config.php';


session_start();

?>

    <!DOCTYPE HTML>

    <!--

	Archetype by Pixelarity

	pixelarity.com | hello@pixelarity.com

	License: pixelarity.com/license

-->

    <html>



    <head>
        <title>
            <?php print $config['title']; ?>
        </title>
        <meta charset="utf-8" />

        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <!--[if lte IE 8]><script src="../assets/js/ie/html5shiv.js"></script><![endif]-->

        <link rel="stylesheet" href="../assets/css/main.css" />

        <!--[if lte IE 8]><link rel="stylesheet" href="../assets/css/ie8.css" /><![endif]-->

        <!--[if lte IE 9]><link rel="stylesheet" href="../assets/css/ie9.css" /><![endif]-->

        <script>
            function logOut() {

                $.post("security/server.php?logOut", {},
                    function() {
                        window.location = "index.php";
                    });
                gapi.auth.signOut();
            }
        </script>

    </head>



    <body>



        <!-- Header -->

        <header id="header">

            <nav id="nav">

                <ul>

                    <li><a href="../select.php">Back</a></li>

                    <li><a target="_blank" href="https://goo.gl/forms/3LXeLRD4bGERkqFy1">Feedback</a></li>


                </ul>

            </nav>

        </header>



        <!-- Main -->

        <section id="main" class="wrapper">

            <div class="inner">

                <header class="major">

                    <h2>
                        <?php print $config['title']; ?> Admin Panel
                    </h2>

                </header>

                <!-- Modals -->
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
                            Sign Up User
                            </button>
                      </form>
                    </div>
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
                            Change Password
                            </button>
                      </form>
                    </div>
                  </div>
                </div>

                <!-- Content -->

                <div class="content">

                    <a href="#" class="image fit"><img src="../images/banner1.jpg" alt="" /></a>

                </div>

                <div class="posts">

                        <section class="post">
                            <a href="#modal1" class="image" rel="modal:open"><img src="../images/pic05.jpg" alt="" /></a>
                            <div class="content">
                                <h3>Add User</h3>
                                <p>Sign up a New User for caMicroscope</p>

                                <a href="#modal1" class="button" rel="modal:open">More</a>

                            </div>

                        </section>

                        <section class="post">
                            <a href="#modal2" class="image" rel="modal:open"><img src="../images/pic05.jpg" alt="" /></a>
                            <div class="content">
                                <h3>Change Admin Password</h3>
                                <p>Change the password required to access this section</p>

                                <a href="#modal2" rel="modal:open" class="button">More</a>

                            </div>

                        </section>

                        <section class="post">
                            <a href="user_list.php" class="image"><img src="../images/pic05.jpg" alt="" /></a>
                            <div class="content">
                                <h3>List Users</h3>
                                <p>A list of users who can access caMicroscope</p>

                                <a href="user_list.php" class="button">More</a>

                            </div>

                        </section>

                        <section class="post">
                            <a href="lymphSuperuser.php" class="image"><img src="../images/pic05.jpg" alt="" /></a>
                            <div class="content">
                                <h3>Lymphocyte Superusers</h3>
                                <p>Manage users with Lymphocyte Superuser Access</p>

                                <a href="lymphSuperuser.php" class="button">More</a>

                            </div>

                        </section>

                </div>

        </section>



        <!-- Footer -->

        <footer id="footer">

            <div class="content">

                <div class="inner">



                    <section class="about">

                        <?php print $config['footer']; ?>

                    </section>


                </div>

            </div>

        </footer>





        <!-- Scripts -->

        <script src="../assets/js/jquery.min.js"></script>

        <script src="../assets/js/jquery.dropotron.min.js"></script>

        <script src="../assets/js/jquery.scrollex.min.js"></script>

        <script src="../assets/js/skel.min.js"></script>

        <script src="../assets/js/util.js"></script>

        <!-- jQuery Modal -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />

        <!--[if lte IE 8]><script src="../assets/js/ie/respond.min.js"></script><![endif]-->

        <!--script src="../assets/js/main.js"></script-->

        <script src="../js/check_session.js"></script>



    </body>



    </html>
