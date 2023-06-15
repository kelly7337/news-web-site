<?php

//For users to edit the posts

session_start();
$_SESSION['post_id']=(int)$_POST['post_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Your Post </title>
    <link href="news.css" type="text/css" rel="stylesheet" />

</head>
<body>
    <h1>The News Site</h1>
    <h2>Edit your story! (Please choose your category from one of the following categories: travel, movies, politics, food, others.)</h2>
    <form class="loginform" action="editstory.php" method="POST">
        <label> New Title: </label>
        <input type="text" name="title" required>
        <label> New Body: </label>
        <input type="text" name="story" required>
        <label> New Category: </label>
        <input type="text" name="category">
        <label> New Link (optional): </label>
        <input type="text" name="link">
        <input type="submit" value="Submit your update">
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
    </form>

    <div>
    <form action="returnmain.php" method="post">
        <input type="submit" value="Return to Main Page">
    </form>
    </div>


</body>
</html>
