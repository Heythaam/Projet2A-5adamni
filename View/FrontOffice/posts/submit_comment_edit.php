<?php
// Include CommentsC.php
include '../Controller/CommentsC.php';

$commentsController = new CommentsC();

if(isset($_POST['comment_content']) && isset($_POST['comment_id'])) {
    $editedContent = $_POST['comment_content'];
    $commentId = $_POST['comment_id'];

    // Update the comment in the database
    $result = $commentsController->updateComment($commentId, $editedContent);

    if($result) {
        echo "Comment edited successfully";
    } else {
        echo "Failed to edit comment";
    }
} else {
    echo "No edited content provided";
}
?>
