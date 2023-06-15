<?php
session_start();
if(!isset($_SESSION['user_id'])){
    echo "You must have an account to submit a story.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Your Story</title>
    <link href="news.css" type="text/css" rel="stylesheet" />

</head>
<body>
    <h1>The News Site</h1>
    <h2> Please choose your category from one of the following categories: travel, movies, politics, food, others. </h2>
    <form class="loginform" action="submit.php" method="post">
        <label> Title: </label>
        <input type="text" name="title" required>
        <label> Body: </label>
        <input type="text" name="story" required>
        <label> Category: </label>
        <input type="text" name="category">
        <label> Link (optional): </label>
        <input type="text" name="link">
        <input type="submit" value="Post Your Story">
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
    </form>

    <div>
    <form action="returnmain.php" method="post">
        <input type="submit" value="Return to Main Page">
    </form>
    </div>


</body>
</html>
