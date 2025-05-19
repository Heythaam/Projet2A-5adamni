<?php
include_once __DIR__.'/../../../config/connexion.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the post ID is set and not empty
    if (isset($_POST['post_id']) && !empty($_POST['post_id'])) {
        // Get the post ID and user ID
        $postId = $_POST['post_id'];
        
        // Create a PDO instance
        $pdo = openDB();
        session_start();
        if(isset($_SESSION['id'])){
            $user_id=$_SESSION['id'];
        }
        
        try {
            // Check if the post is already liked by the user
            $likeQuery = "SELECT * FROM likes WHERE post_id = :post_id AND user_id = :user_id";
            $statement = $pdo->prepare($likeQuery);
            $statement->bindParam(':post_id', $postId);
            $statement->bindParam(':user_id', $user_id);
            $statement->execute();
    
            if ($statement->rowCount() > 0) {
                // If the post is already liked, unlike it
                $unlikeQuery = "DELETE FROM likes WHERE post_id = :post_id AND user_id = :user_id";
                $statement = $pdo->prepare($unlikeQuery);
                $statement->bindParam(':post_id', $postId);
                $statement->bindParam(':user_id', $user_id);
                $result = $statement->execute();
    
                if ($result) {
                    echo 'unliked';
                } else {
                    echo 'Error: Unable to unlike post.';
                }
            } else {
                // If the post is not liked, like it
                $likeInsertQuery = "INSERT INTO likes (post_id, user_id) VALUES (:post_id, :user_id)";
                $statement = $pdo->prepare($likeInsertQuery);
                $statement->bindParam(':post_id', $postId);
                $statement->bindParam(':user_id', $user_id);
                $result = $statement->execute();
    
                if ($result) {
                    echo 'liked';
                } else {
                    echo 'Error: Unable to like post.';
                }
            }
        } catch (PDOException $e) {
            // Handle any exceptions
            echo "Error: " . $e->getMessage();
        }
    } else {
        // If post ID is not set or empty, return an error response
        http_response_code(400); // Bad Request
        echo 'Error: Post ID is missing.';
    }
} else {
    // If request method is not POST, return an error response
    http_response_code(405); // Method Not Allowed
    echo 'Error: Method not allowed.';
}
?>
