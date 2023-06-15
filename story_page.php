<?php
session_start();
require 'database.php';

//For each concrete story

if(isset($_SESSION['user_id'])){
    $token=$_SESSION['token'];
}
if(!isset($_SESSION['post_id'])){
    $_SESSION['post_id']=(int)$_POST['post_id'];
}
$post_id=$_SESSION['post_id'];
if(!isset($_SESSION['post_title'])){
    $_SESSION['post_title'] = (string)$_POST['post_title'];
}
$post_title=$_SESSION['post_title'];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php echo htmlentities($post_title)?> </title>
    <link href="news.css" type="text/css" rel="stylesheet" />

</head>
<body>
    <h1>The News Site</h1>
    <?php
        $stmt=$mysqli->prepare("select title, story, link, user_id from stories where post_id=?");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('i',$post_id);
        $stmt->execute();
        $stmt->bind_result($title,$story,$link,$user_id);

        //On concrete story page, tile, body and link are showed
        //Code from wiki

        while($stmt->fetch()){
            printf("<div class='post'> \n \t <h2> %s </h2> \n <p> %s </p> \n <a href=%s> Link </a> \n </div>",
                htmlentities($title),
                htmlentities($story),
                htmlentities($link)
            );

        //Only users can use comment button
            if(isset($_SESSION['user_id'])){
            echo "\n \n \n \t <form class='add' action='addcomment.php' method='post'>
                <input type='text' name='comment_text' required>
                <input type='hidden' name='post_id' value=$post_id>
                <input type='submit' value='Add Comment'>
                <input type='hidden' name='token' value='$token'>
                </form>";
            }
        }

        //Comments associated with the post are showed
        $stmt = $mysqli->prepare("select comment_text, users.username, comment_id,user_id, post_id,comment_likes from comments join users on (users.id=user_id) where post_id=?");
            if(!$stmt){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
            $stmt->bind_param('i',$post_id);
            $stmt->execute();
            $stmt->bind_result($comment_text,$username,$comment_id,$user_id, $post_id, $comment_likes);

            while($stmt->fetch()){

        //Only users can delete or edit the comments
                if(isset($_SESSION['user_id']) && $_SESSION['user_id']==$user_id){

                echo "\n<div class='comment'>\n";
                printf("\t <p class='username'> %s </p> \n \t<p class='storytext'> %s </p>" ,
                    htmlentities($username),
                    htmlentities($comment_text)
            );


                echo "\t <input type='hidden' name='comment_id' value=$comment_id>
                    <input type='hidden' name='user_id' value=$post_id>
                    </form>";

                echo "\n \t<form class='edit' action='editcomment.php' method='POST'>
                    <input type='text' name='new_comment' required>
                    <input type='submit' value='Edit Comment'>
                    <input type='hidden' name='comment_id' value=$comment_id>
                    <input type='hidden' name='user_id' value=$post_id>
                    <input type='hidden' name='token' value='$token'>
                    </form>";
                echo "\n \t<form action='deletecomment.php' method='POST'>
                    <input type='submit' value='Delete Comment'>
                    <input type='hidden' name='comment_id' value=$comment_id>
                    <input type='hidden' name='user_id' value=$post_id>
                    <input type='hidden' name='token' value='$token'>
                    </form>";
                echo "\n \t</div>\n";
                }
                else{

                    echo "\n<div class='comment'>\n";
                    printf("\t <p class='username'> %s </p> <p class='storytext'> %s </p>",
                    htmlentities($username),
                    htmlentities($comment_text)
            );
                echo "\t <input type='hidden' name='comment_id' value=$comment_id>
                    <input type='hidden' name='user_id' value=$post_id>
                    </form>";
                echo "\n</div>";
                }
            }
            $stmt->close();

    ?>
    <div>
    <form action="returnmain.php" method="post">
        <input type="submit" value="Return to Main Page">
    </form>
    </div>
</body>
</html>
