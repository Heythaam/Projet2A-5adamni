<?php

include '../../../Controller/CommentsC.php';

$commentsController = new CommentsC();

if(isset($_POST['post_comment'])) {
    
    $username = $_POST['username'];
    $commentContent = $_POST['comment'];
    $postId = $_POST['post_id'];
    session_start();
    if(isset($_SESSION['id'])){
        $user_id=$_SESSION['id'];
    }

    $result = $commentsController->InsererComments($username, $commentContent, $postId,$user_id);

    if($result) {
        header("Location: index.php");
        exit();
    } else {
        echo "Failed to add comment!";
    }
} else {
    header("Location: index.php");
    exit();
}
?>
