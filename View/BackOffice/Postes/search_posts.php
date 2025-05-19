<?php
require_once "../../../config/connexion.php";
include '../../../Controller/PostsC.php'; // Include the Posts controller

// Check if the search form is submitted
if(isset($_POST['keyword'])) {
    $keyword = $_POST['keyword']; // Get the keyword from the form submission

    // Create an instance of the PostsC class
    $PostsController = new PostsC();

    // Call the searchPosts method of the PostsC class with the keyword
    $results = $PostsController->searchPosts($keyword);

    // Check if there are search results
    if ($results) {
        // Output the search results as table rows
        while($rows = $results->fetch()) {
            $PostID = $rows['PostID'];
            $author = $rows['Author'];
            $time = $rows['Time'];
            $content = $rows['Content'];
            $likes = $rows['Likes'];
            $Posts = $rows['Posts'];
            $MediaData = $rows['MediaData'];

            // Output each row of the table
            echo "<tr>";
            echo "<td>$author</td>";
            echo "<td>$time</td>";
            echo "<td>$content</td>";
            echo "<td>$likes</td>";
            echo "<td>$Posts</td>";
            echo "<td>$MediaData</td>";
            echo '<td><button class="btn btn-sm btn-primary">';
            echo '<a href="delete.php?cin='. $PostID .'" style="text-decoration: none;color: white;">Delete</a>';
            echo '</button></td>';
            echo "</tr>";
        }
    } else {
        // If no results found, output a message in a single table row
        echo "<tr><td colspan='7'>No results found.</td></tr>";
    }
}
?>
