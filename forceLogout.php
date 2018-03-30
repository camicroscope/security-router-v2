<?php
?>

<html>
    <head>
        <title></title>
        <meta charset="utf-8">
         <script  src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
         <script src="js/modernizr-2.8.3.min.js"></script>
         <script src="https://apis.google.com/js/client:platform.js?onload=start" async defer></script>
         <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
         <script src="featurescapeapps/js/findapi_config.js"></script>
    </head>

    <body>
        <script>
         $(document).ready(function(){
            $.post("security/server.php?logOut", {},
                    function () {
                        window.location = "index.php";
                    });
            gapi.auth.signOut();
        })
    </script>
</body></html>
