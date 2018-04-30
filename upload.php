<?php
    session_start();
    require 'authenticate.php'
    ?>
<html>
    <!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="materialize/css/materialize.min.css"  media="screen,projection"/>
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="materialize/js/materialize.min.js"></script>
    <script src="js/jquery-form.js"></script>
    <script type="text/javascript" src="materialize/js/materialize.min.js"></script>
    <div class="container">
        <h4> Upload Images </h4>
        <p>Pick an unique Image ID (Letters, Numbers, Dash(-), and Underscore(_) only) and upload an image file.
        <form id="uploadme" role="form" action="quip-loader/submitData" method="post" enctype="multipart/form-data">
            <div class="input-field col s12">
                <input id="imageid" name="case_id" type="text" pattern="^[a-zA-Z0-9-_]+$" class="validate">
                <label for="imageid">Image ID</label>
            </div>
            <div class="file-field input-field">
                <div class="btn">
                    <span>File</span>
                    <input id="upload_image" name="upload_image" type="file">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text">
                </div>
            </div>
            <button id="submitButton" type="submit" value="Upload Image" class="btn-large blue waves-effect waves-light btn" action="submit">
            Upload <i class="material-icons right">send</i>
            </button>
        </form>
        <div class="progress">
            <div id="progressbar" class="determinate" style="width: 0%"></div>
        </div>
        <div id="status"></div>
        <br>
        <p>After upload is completed...</p>
        <button id="submitButton" class="btn-large blue waves-effect waves-light btn" onclick="javascript:history.back()">
        Go Back <i class="material-icons right">arrow_back</i>
        </buton>
    </div>
    </div>
    <script src="js/uploader.js"></script>
</html>
