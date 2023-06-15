<?php
session_start();
require 'database.php';

//For users to delete their own stories

$post_id=(int)$_POST['post_id'];

//token
if(!hash_equals($_SESSION['token'], $_POST['token'])){
        die("Request forgery detected");
}

$stmt = $mysqli->prepare("delete from comments where post_id=?");


if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
}

$stmt->bind_param('i', $post_id);
$stmt->execute();
$stmt->close();


$stmt = $mysqli->prepare("delete from stories where post_id=?");

if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
}

$stmt->bind_param('i', $post_id);
$stmt->execute();
$stmt->close();


header('Location:main.php');
exit;
?>
