<?php
session_start();
require 'database.php';
if(!isset($_SESSION['user_id'])){
    echo htmlentities("You must have an account to submit a story.");
}
else{

//token
 if(!hash_equals($_SESSION['token'], $_POST['token'])){
        die("Request forgery detected");
}


$user_id = (int)$_SESSION['user_id'];
$title = (string) $_POST['title'];
$story = (string) $_POST['story'];

if($_POST['link']==""){
    $_POST['link']="#";
} else if (!preg_match('/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i',$_POST['link'])) {
    echo htmlentities("Invalid URL");
    exit;
}
$link = (string)$_POST['link'];


if($_POST['category']==""){
    $category=null;
} else if ($_POST['category']=="politics") {
    $category = (string) $_POST['category'];
} else if ($_POST['category']=="travel") {
    $category = (string) $_POST['category'];
} else if ($_POST['category']=="movies") {
    $category = (string) $_POST['category'];
} else if ($_POST['category']=="food") {
    $category = (string) $_POST['category'];
} else if ($_POST['category']=="others") {
    $category = (string) $_POST['category'];
} else {
    echo htmlentities("Invalid Category Type");
    exit;
}

$stmt = $mysqli->prepare("insert into stories(user_id, title, story, link, category) values (?, ?, ?, ?, ?)");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
}

$stmt->bind_param('issss', $user_id,$title,$story,$link,$category);
$stmt->execute();
$stmt->close();

header('Location:main.php');
exit;
}
?>
