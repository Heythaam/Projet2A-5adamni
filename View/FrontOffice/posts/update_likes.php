<?php

// update_likes.php
include '../Controller/PostsC.php';

// Create an instance of the PostsC class
$postsController = new PostsC();

// Check if post ID is provided in the AJAX request
if(isset($_POST['postId'])) {
    $postId = $_POST['postId'];
    
    // Update likes count in the database using the PostsC class method
    $result = $postsController->updateLikesInDatabase($postId);

    if ($result) {
        // Retrieve updated likes count from database using the PostsC class method
        $newLikesCount = $postsController->getLikesCountFromDatabase($postId);
        if ($newLikesCount !== false) {
            // Return new likes count as response
            echo $newLikesCount;
        } else {
            // Return error response if likes count retrieval failed
            http_response_code(500);
            echo "Failed to retrieve updated likes count";
        }
    } else {
        // Return error response if likes count update failed
        http_response_code(500);
        echo "Failed to update likes count";
    }
} else {
    // Return error response if post ID is not provided
    http_response_code(400);
    echo "Post ID is required";
}
?>
