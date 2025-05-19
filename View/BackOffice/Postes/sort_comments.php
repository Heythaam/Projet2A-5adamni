<?php
// Include the commentsC class
include_once '../../../Controller/CommentsC.php';

// Create an instance of the commentsC class
$commentsObj = new commentsC();

// Call the sortComments method to retrieve sorted comments
$sortedComments = $commentsObj->sortComments();

// Return the sorted comments data as JSON
echo json_encode($sortedComments);
?>
