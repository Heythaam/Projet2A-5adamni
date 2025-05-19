<?php
    require_once "../../../config/connexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postid = $_POST["post_id"];
    $rating = $_POST["rating"];
    session_start();
    if(isset($_SESSION['id'])){
        $user_id=$_SESSION['id'];
    }
    $pdo = openDB();
    try {
        // Prepare SQL statement to insert into ratings table
        $stmt = $pdo->prepare("INSERT INTO ratings (post_id, user_id, rating) VALUES (:postid, :user_id, :rating)");

        // Bind parameters
        $stmt->bindParam(':postid', $postid);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':rating', $rating);

        // Execute the statement
        $stmt->execute();

        // Redirect back to index.php
        header("Location: index.php");
        exit; // Ensure script execution stops after the redirect
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
