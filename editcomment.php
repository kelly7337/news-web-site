<?php
session_start();
require 'database.php';

//For users to edit their comments

$comment_id=(int) $_POST['comment_id'];
$new_comment=(string)$_POST['new_comment'];

if(!hash_equals($_SESSION['token'], $_POST['token'])){
        die("Request forgery detected");
}

$stmt = $mysqli->prepare("update comments set comment_text=? where comment_id=?");

if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
}

$stmt->bind_param('si', $new_comment, $comment_id);
$stmt->execute();
$stmt->close();

header('Location:story_page.php');
exit;
?>
