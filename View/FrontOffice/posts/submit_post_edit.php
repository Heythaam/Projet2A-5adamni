<?php
// Include CommentsC.php
include '../Controller/PostsC.php';

$postsController = new PostsC();

if(isset($_POST['post_content']) && isset($_POST['post_id'])) {
    $editedContent = $_POST['post_content'];
    $postId = $_POST['post_id'];

    // Update the comment in the database
    $result = $postsController->updateCommentContent($postId, $editedContent);

    if($result) {
        echo "Comment edited successfully";
    } else {
        echo "Failed to edit comment";
    }
} else {
    echo "No edited content provided";
}
?>
