<?php

//Code from wiki

$mysqli = new mysqli('localhost', 'wustl_inst', 'wustl_pass', 'news_site');

if($mysqli->connect_errno) {
        printf("Connection Failed: %s\n", $mysqli->connect_error);
        exit;
}
?>
