<?php
session_start();
require 'database.php';

$stmt = $mysqli->prepare("SELECT COUNT(*), id, hashed_password from users where username=?");


$stmt->bind_param('s',$user);
$_SESSION['user'] = (string) $_POST['username'];
$user = $_SESSION['user'];
if( !preg_match('/^[\w_\-]+$/', $user) ){
        echo "Invalid username. You can only use alphanumeric characters, hyphens, and underscores.";
        exit;
}
$stmt->execute();

$stmt->bind_result($cnt, $user_id, $pwd_hash);
$stmt->fetch();


$pwd_guess = (string) $_POST['password'];

if($cnt==1 && password_verify($pwd_guess, $pwd_hash)){
    $_SESSION['user_id'] = $user_id;
    header('LOCATION:main.php');
} else {
    header('LOCATION:loginfail.html');
}

$stmt->close();

$_SESSION['token'] = bin2hex(random_bytes(32));
?>
