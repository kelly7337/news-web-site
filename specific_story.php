<?php
    //for different catagory
    session_start();
    if(isset($_SESSION['user_id'])){
    $username= (string) $_SESSION['user'];
    $user_id = (int) $_SESSION['user_id'];
    $token=$_SESSION['token'];
    }

    $_SESSION["post_id"]=null;
    $_SESSION["post_title"]=null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="file.css" type="text/css" rel="stylesheet" />
    <title>The Quarterly</title>
    <link href="news.css" type="text/css" rel="stylesheet" />
</head>

<body>
<h1>Welcome to the News Site</h1>
<nav>
    <form action="main.php" >
        <input type="submit" value="all">
    </form>
    <form action="specific_story.php" method="post">
        <input type="submit" name="category" value="politics">
        <input type="hidden" value="politics">
    </form>
    <form action="specific_story.php" method="post">
        <input type="submit" name="category" value="travel">
        <input type="hidden" value="travel">
    </form>
    <form action="specific_story.php" method="post">
    <input type="submit" name="category" value="movies">
        <input type="hidden" value="movies">
    </form>
    <form action="specific_story.php" method="post">
        <input type="submit" name="category" value="food">
        <input type="hidden" value="food">
    </form>
    <form action="specific_story.php" method="post">
        <input type="submit" name="category" value="others">
        <input type="hidden" value="others">
    </form>
</nav>
<?php
    require 'database.php';

    $category = (string) $_POST['category'];

    //Only user can find logout button

    if(isset($_SESSION['user_id'])){
        printf("<p > Hello, %s ! </p>",
                htmlentities($username));
        printf("<p> Want to logout? Click here! </p>");

        echo "\n\t<div class='log'>
            <form action='logout.php' method='POST'>
            <input type='submit' value='Log Out'>
            </form>
            </div>";
        }
    else{

    //Guest can find log in button
        echo "\n \t <div>
        <form action='login.html' method='POST'>
            <input type='submit' value='Log In'>
        </form>
    </div>";
    }
    echo "\n <div>";


    $stmt = $mysqli->prepare("select title, story, link, user_id, post_id from stories where category=?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param("s",$category);
    $stmt->execute();
    $stmt->bind_result($submission_title,$submission_story,$submission_link,$submission_user,$submission_id);


    while($stmt->fetch()){
        echo "\n\t <div class='story'>\n";

        printf("\t<a class='title' href=%s> %s </a>",
        htmlentities($submission_link),
        htmlentities($submission_title)
    );

    //view the post
    echo "\n\t <form action='story_page.php' method='post'>
            <input type='submit' value='View and Comment'>
            <input type='hidden' name='post_id' value=$submission_id>
            <input type='hidden' name='post_title' value='$submission_title'>
            </form>";

    //Only users can delete or edit the posts
        if(isset($_SESSION['user_id']) && $_SESSION['user_id']==$submission_user){
           //delete the post
            echo "\n\t<form action='deletestory.php' method='POST'>
            <input type='submit' value='Delete Post'>
            <input type='hidden' name='post_id' value=$submission_id>
            <input type='hidden' name='token' value='$token'>
            </form>";

           //edit the post
            echo "\n\t <form action='editstory_page.php' method='POST'>
            <input type='submit' value='Edit Post'>
            <input type='hidden' name='post_id' value=$submission_id>
            <input type='hidden' name='token' value='$token'>
            </form>";

        }
        echo "\n\t </div>\n";
    }
    $stmt->close();
?>
</div>
<div>
    <p> Post your story here! </p>
    <form action="submit_page.php" method="post">
        <input id="submit" type="submit" value="Post Your Story">
    </form>
</div>


</body>

</html>
