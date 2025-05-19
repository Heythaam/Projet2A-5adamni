<?php

include_once __DIR__.'/../config/connexion.php';


class commentsC{


public function afficherComments()
{
    $pdo = openDB();

    try{
        $query = $pdo->prepare ( 
            'SELECT * FROM comments '
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

public function InsererComments($username, $commentContent, $postId ,$id_user) {
    $pdo = openDB();

    try {
        
        $statement = $pdo->prepare("INSERT INTO comments (PostID, Author, content,user_id) VALUES (:PostID, :Author, :content, :id_user)");

        
        $statement->bindParam(':PostID', $postId);
        $statement->bindParam(':Author', $username);
        $statement->bindParam(':content', $commentContent);
        $statement->bindParam(':id_user', $id_user);

        
        $statement->execute();

        
        return true; 
    } catch (PDOException $e) {
        
        echo "Error: " . $e->getMessage();
        return false;
    }
}

public function updateComment($commentId, $editedContent) {
    $pdo = openDB();
    // Prepare the update statement
    $stmt = $pdo->prepare("UPDATE comments SET content = :content WHERE CommentID = :commentId");

    $stmt->bindParam(':content', $editedContent);
    $stmt->bindParam(':commentId', $commentId);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

public function deleteComment($commentId) {
    try {
        $pdo = openDB();
        $statement = $pdo->prepare("DELETE FROM comments WHERE CommentID = :CommentID");
        $statement->bindParam(':CommentID', $commentId);
        $statement->execute();
        return true;
    } catch (PDOException $e) {
        return false;
    }
}
}

?>
