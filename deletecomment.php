<?php
session_start();
require 'database.php';

//For users to delete their own comments

$comment_id=(int)$_POST['comment_id'];

//token
if(!hash_equals($_SESSION['token'], $_POST['token'])){
        die("Request forgery detected");
}
$stmt = $mysqli->prepare("delete from comments where comment_id=?");

if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
}

$stmt->bind_param('i', $comment_id);
$stmt->execute();
$stmt->close();

header('location:story_page.php');
exit;
?>
