<?php
include '../../../Controller/CommentsC.php';

$commentsController = new CommentsC();

if(isset($_GET['comment_id'])) {
    $commentId = $_GET['comment_id'];

    $result = $commentsController->deleteComment($commentId);

    if($result) {
        header("Location: index.php");
        exit();
    } else {
        echo "Failed to delete comment!";
    }
} else {
    header("Location: index.php");
    echo 'Deleted!!!!';
    exit();
}
?>
