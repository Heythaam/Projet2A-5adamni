<?php
include '../../../Controller/PostsC.php';

$postsController = new PostsC(); // Corrected the controller initialization

if(isset($_GET['post_id'])) {
    $postId = $_GET['post_id'];

    $result = $postsController->DeletePost($postId);

    if($result) {
        header("Location: index.php");
        exit();
    } else {
        echo "Failed to delete post!";
    }
} else {
    header("Location: index.php");
    exit();
}
?>
