<?php
session_start();
echo "{\"issued\": \"" . $_SESSION["last_seen"] ."\", \"now\": \"" . time() . "\"}";
?>
