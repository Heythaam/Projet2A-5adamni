<?php

include_once __DIR__.'/../config/connexion.php';


class postsC{


    public function afficherPost()
    {
        $pdo = openDB();

        try{
            $query = $pdo->prepare ( 
                'SELECT * FROM posts order by Time desc'
            );
            $query->execute();
            $result = $query->fetchAll();
            return $result;
        }

        catch(PDOException $e)
        {
            $e->getMessage();
        }
    }

    function updateLikesInDatabase($postId) {
        $pdo = openDB();
        try {
            
            
            $statement = $pdo->prepare("UPDATE posts SET likes = likes + 1 WHERE PostID = :postId");
            
            $statement->bindParam(':postId', $postId);
            
            $statement->execute();
            
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function InsererPosts($author, $content, $file_path,$id_user) {
        $pdo = openDB();
    
        try {
            // Prepare the SQL statement
            $statement = $pdo->prepare("INSERT INTO posts (Author, Content, MediaData, user_id) VALUES (:author, :content, :media_data, :id_user)");
    
            // Bind parameters
            $statement->bindParam(':author', $author);
            $statement->bindParam(':content', $content);
            $statement->bindParam(':media_data', $file_path);
            $statement->bindParam(':id_user', $id_user);
    
            // Execute the statement
            $result = $statement->execute();
    
            // Return the result
            return $result;
        } catch (PDOException $e) {
            // Handle any exceptions
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
    

    public function updateCommentContent($postId, $editedContent) {
        try {
            $pdo = openDB();
            
            $statement = $pdo->prepare("UPDATE comments SET content = :editedContent WHERE PostID = :postId");
            
            $statement->bindParam(':postId', $postId);
            $statement->bindParam(':editedContent', $editedContent);
            
            $statement->execute();
            
            
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function DeletePost($postId) {
        $pdo = openDB();
        try {
            $statement = $pdo->prepare("DELETE FROM posts WHERE PostID = :postId");
            $statement->bindParam(':postId', $postId);
            $statement->execute();
            return true; 
        } catch (PDOException $e) {
            
            return false;
        }
    }
    public function toggleLike($postId, $userId) {
        $pdo = openDB();
        try {
            // Check if the user has already liked the post
            $statement = $pdo->prepare("SELECT COUNT(*) FROM post_likes WHERE PostID = :postId AND UserID = :userId");
            $statement->bindParam(':postId', $postId);
            $statement->execute();
            $likeCount = $statement->fetchColumn();

            if ($likeCount > 0) {
                // If the user has already liked the post, decrement the like count (unlike)
                $statement = $pdo->prepare("UPDATE posts SET likes = likes - 1 WHERE PostID = :postId");
                $action = "unliked";
            } else {
                // If the user has not liked the post, increment the like count (like)
                $statement = $pdo->prepare("UPDATE posts SET likes = likes + 1 WHERE PostID = :postId");
                $action = "liked";
            }

            // Update the post_likes table to reflect the user's like status
            $statement2 = $pdo->prepare("REPLACE INTO post_likes (PostID, UserID) VALUES (:postId, :userId)");
            $statement2->bindParam(':postId', $postId);
            $statement2->bindParam(':userId', $userId);

            // Execute the statements
            $statement->execute();
            $statement2->execute();

            return $action; // Return the action performed (liked or unliked)
        } catch (PDOException $e) {
            // Handle any errors
            echo "Error: " . $e->getMessage();
            return false; // Failed to update the database
        }
    }
    
}




?>