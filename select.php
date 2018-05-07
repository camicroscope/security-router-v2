<?php

session_start();

require 'authenticate.php';

//require 'branding.php';

//require_once 'config/security_config.php';

$config = require 'config.php';



$_SESSION["name"] = "quip";



//try to fix bug

$dataUrl= "http://" . $config['dataHost'] . "/services/Camicroscope_DataLoader/DataLoader/query/getAll";

$apiKey = $_SESSION["api_key"];

$dataUrl = $dataUrl . "?api_key=".$apiKey;

$cSession = curl_init();

function fetchData($dataUrl){
    $cSession = curl_init();
    try {
        $ch = curl_init();

        if (FALSE === $ch)

            throw new Exception('failed to initialize');

        curl_setopt($ch,CURLOPT_URL, $dataUrl);

        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

        curl_setopt($ch,CURLOPT_HEADER, false);



        $content = curl_exec($ch);

        if (FALSE === $content)
            throw new Exception(curl_error($ch), curl_errno($ch));

        // ...process $content now
    } catch(Exception $e) {
        $content = "Error";
        return $content;
    }
    $content_json = json_decode($content);
    return $content_json;
}


if (empty($content)) {

    // list is empty.

    //session_unset();

    //die();

    echo "<script>console.log('first content empty')</script>";

    //header('Location: forceLogout.php');

    //exit;

}

//end of bug fix


session_start();

$_SESSION["name"] = "quip";
//try to fix bug
$dataUrl= "http://" . $config['dataHost'] . "/services/Camicroscope_DataLoader/DataLoader/query/getAll";
$apiKey = $_SESSION["api_key"];
$dataUrl = $dataUrl . "?api_key=".$apiKey;
$content_json = array();
$content_json = fetchData($dataUrl);
if(empty($content_json) or $content_json=='Error'){
    //header('Location: forceLogout.php');
    //exit;
    echo "<script>console.log('second content empty')</script>";
}

$email=$_SESSION["email"];
$UdataUrl = "http://" . $config['dataHost'] . "/services/u24_user/user_data/query/findUserByEmail";
$apiKey = $_SESSION["api_key"];
$UdataUrl = $UdataUrl . "?api_key=".$apiKey;
$UdataUrl = $UdataUrl . "&email=".$email;
$user_json = array();
$user_json = fetchData($UdataUrl);
if(!empty($user_json) and $user_json!='Error'){
    $item=$user_json[0];
    $a = (array)$item;
    $userType=$a['userType'];
}else
    $userType="user";

$_SESSION["userType"] = $userType;
?>

<!DOCTYPE HTML>

<!--

	Archetype by Pixelarity

	pixelarity.com | hello@pixelarity.com

	License: pixelarity.com/license

-->

<html>



<head>

    <!--title><?php print $config['title']; ?></title-->

    <title><?php print $config['title']; ?></title>
    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->

    <link rel="stylesheet" href="assets/css/main.css" />

    <!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->

    <!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->

    <script>

        function logOut() {

            $.post("security/server.php?logOut", {},
                function () {
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

            <li><a href="<?php print $config['download_link']; ?>">About</a></li>

            <li><a target="_blank" href="https://goo.gl/forms/3LXeLRD4bGERkqFy1">Feedback</a></li>

            <li><a href="#" onclick="logOut()">Logout</a></li>

        </ul>

    </nav>

</header>



<!-- Main -->

<section id="main" class="wrapper">

    <div class="inner">

        <header class="major">

            <h2><?php print $config['title']; ?></h2>

        </header>

        <!-- Content -->

        <div class="content">

            <a href="#" class="image fit"><img src="images/banner1.jpg" alt="" /></a>

        </div>

        <div class="posts">

            <section class="post">
                <!-- a href="FlexTables/index.php" class="image"><img src="images/camic.jpg" alt="" /></a -->
                <a href="table/vtr_pilot_table.php" class="image"><img src="images/camic.jpg" alt=""/></a>
                <div class="content">
                    <!--h3>caMicroscope</h3-->
                    <h3>Curated Results</h3>
                    <!--
                    <p>Visualize digitized pathology images, pathomic features, and annotate whole slide tissue images.</p>
                    <a href="FlexTables/index.php" class="button">More</a>
                    -->
                    <p>Use caMicroscope to view curated images and features from the various registries</p>
                    <a href="table/vtr_pilot_table.php" class="button">More</a>
                </div>
            </section>

            <section class="post">
                <a href="featurescapeapps/featurescape/u24Preview.php" class="image"><img src="images/fscape.jpg" alt="" /></a>
                <div class="content">
                    <h3>FeatureScape</h3>
                    <p>Visual analytics platform for exploring pathomic features generated by analysis of whole slide tissue images to QuIP.</p>
                    <a href="featurescapeapps/featurescape/u24Preview.php" class="button">More</a>
                </div>
            </section>

            <section class="post">
                <a href="FlexTables/index.php" class="image"><img src="images/camic.jpg" alt="" style="filter: grayscale(100%);"/></a>
                <div class="content">
                    <h3>Feature Curation App</h3>
                    <p>For feature curation only</p>
                    <a href="FlexTables/index.php" class="button">More</a>
                </div>
            </section>
            <!--
            <section class="post">
                <a href="table/camicro_qc_table.php" class="image"><img src="images/camic.jpg" alt="" style="filter: grayscale(100%);"/></a>
                <div class="content">
                    <h3>caMicroscope QC</h3>
                    <p>Use caMicroscope to view features that have been extracted but not fully curated</p>
                    <a href="table/camicro_qc_table.php" class="button">More</a>
                </div>
            </section>
             -->
            <?php
            $userType=$_SESSION["userType"];
            $template = <<<EOT
<section class="post">
          <a href="superuser/index.php" class="image"><img src="images/camic.jpg" alt="" style="filter: grayscale(100%);"/></a>
          <div class="content">
                  <h3>Super User Control Images</h3>
                  <p>caMicroscope Super user set up images access control.</p>
                  <a href="superuser/index.php" class="button">More</a>
          </div>
        </section>
EOT;

            if($userType=="superUser"){
                echo $template;
            }
            ?>

            <section class="post">
                <a href="<?php print $config['download_link']; ?>" class="image"><img src="images/code.jpg" alt="" /></a>
                <div class="content">
                    <h3>QuIP Distribution</h3>
                    <p>QuIP is free and open source. You can download and install this software, or report any issues you encounter.</p>

                    <a href="<?php print $config['download_link']; ?>" class="button">More</a>

                </div>

            </section>

            <section class="post">
                <a href="upload.php" class="image"><img src="images/pic05.jpg" alt="" /></a>
                <div class="content">
                    <h3>Image Upload</h3>
                    <p>Upload slide images to caMicroscope.</p>

                    <a href="upload.php" class="button">More</a>

                </div>

            </section>

            <section class="post">
                <a href="Admin/index.php" class="image"><img src="images/pic05.jpg" alt="" /></a>
                <div class="content">
                    <h3>User Managment</h3>
                    <p>Add, delete, and list users.</p>

                    <a href="Admin/index.php" class="button">More</a>

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

<script src="assets/js/jquery.min.js"></script>

<script src="assets/js/jquery.dropotron.min.js"></script>

<script src="assets/js/jquery.scrollex.min.js"></script>

<script src="assets/js/skel.min.js"></script>

<script src="assets/js/util.js"></script>

<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->

<!--script src="assets/js/main.js"></script-->

<script src="js/check_session.js"></script>



</body>



</html>
