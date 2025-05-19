<?php
include '../../../Controller/PostsC.php';

$postsController = new PostsC();
session_start();
if(isset($_SESSION['id'])){
    $user_id=$_SESSION['id'];
    $author=$_SESSION['prenom'];
}
if(isset($_POST['post-textarea'])) {
    $content = $_POST['post-textarea'];
    
    // Check if file is uploaded
    if(isset($_FILES['photo-upload'])) {
        $file_name = $_FILES['photo-upload']['name'];
        $file_size = $_FILES['photo-upload']['size'];
        $file_tmp = $_FILES['photo-upload']['tmp_name'];
        $file_type = $_FILES['photo-upload']['type'];
        
        // Specify the directory where uploaded images will be stored
        $target_dir = "uploads/";
        
        // Move the uploaded file to the specified directory
        $target_file = $target_dir . basename($file_name);
        
        // Check if file is a valid image
        $check = getimagesize($file_tmp);
        if($check !== false) {
            // Check file size (max 5MB)
            if ($file_size > 5000000) {
                echo "Sorry, your file is too large.";
            } else {
                // Allow certain file formats
                $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
                $file_ext = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                if(in_array($file_ext, $allowed_types)) {
                    // Move uploaded file to destination directory
                    if(move_uploaded_file($file_tmp, $target_file)) {
                        // Insert post into the database
                        $result = $postsController->InsererPosts($author, $content, $target_file,$user_id);
                        if($result) {
                            header("Location: index.php");
                            exit();
                        } else {
                            echo "<h2>Failed to add post to the database</h2>";
                        }
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                } else {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                }
            }
        } else {
            echo "File is not an image.";
        }
    } else {
        echo "Please select a file.";
    }
} else {
    header("Location: index.php");
    exit();
}
?>
