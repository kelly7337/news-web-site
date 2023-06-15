<?php
session_start();
require 'database.php';

//For user edit the story

$post_id=(int)$_SESSION['post_id'];
$new_title = (string)$_POST['title'];
$new_story = (string)$_POST['story'];


if($_POST['link']==""){
    $_POST['link']="#";
} else if (!preg_match('/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i',$_POST['link'])) {
    echo "Invalid URL";
    exit;
}
$new_link = $_POST['link'];

if($_POST['category']==""){
    $new_category=null;
} else if ($_POST['category']=="politics") {
    $new_category = (string) $_POST['category'];
} else if ($_POST['category']=="travel") {
    $new_category = (string) $_POST['category'];
} else if ($_POST['category']=="movies") {
    $new_category = (string) $_POST['category'];
} else if ($_POST['category']=="food") {
    $new_category = (string) $_POST['category'];
} else if ($_POST['category']=="others") {
    $new_category = (string) $_POST['category'];
} else {
    echo "Invalid Category Type";
    exit;
}

//token
if(!hash_equals($_SESSION['token'], $_POST['token'])){
        die("Request forgery detected");
}

$stmt = $mysqli->prepare("update stories set title=?, story=?, link=?, category=? where post_id=?");

if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
}

$stmt->bind_param('ssssi', $new_title, $new_story, $new_link, $new_category, $post_id);
$stmt->execute();
$stmt->close();

header('Location:main.php');
exit;
?>
