<html lang="en">
<head>
    <title>5adamni</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="Free-Template.co" />
    <link rel="shortcut icon" href="../logo-mini.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="style3.css">
    <?php
        require_once "../../../Controller/UserController.php";
        session_start();
        if(!isset($_SESSION['prenom'])) {
            header("location: ../login.php");
            exit;
        }
        else{
            echo '<script>';
            echo 'document.addEventListener("DOMContentLoaded", function() {';
            echo '    var prenom = "' . htmlspecialchars($_SESSION['prenom']) . '";';
            echo '    var users = document.getElementsByClassName("user");';
            echo '    for (var i = 0; i < users.length; i++) {';
            echo '        users[i].textContent = prenom;';
            echo '    }';
            echo '});';
            echo '</script>';
        }
        $usrc = new UserC();
        $user = $usrc->GetUserById($_SESSION['id']);
    ?>
    <script src="https://kit.fontawesome.com/3892138727.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    

    <title>Document</title>
</head>
<body>
    

<nav>
    <div class="nav-left">
        <img src="logo.svg" alt="5adamni_logo" class="logo">
        <div class="search-box">
            <img src="images/search.png">
            <input type="text" placeholder="Search">
        </div>
    </div>
    <div class="nav-right">
        <div class="nav-user-icon online">
            <img src="data:image/png;base64,<?php if (isset($user['image'])){echo base64_encode($user['image']);} ?>" alt="Image de l'utilisateur">
            <div class="options-container">
            <ul>
            <li><a href="#" class="Profile">Porfile</a></li>
            <li><a class="Logout" href="../logout.php">Log Out</a></li>
            </ul>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
    $('.nav-user-icon').click(function() {
        $(this).find('.options-container').toggle();
    });
});
    </script>
    <!-- <div class="settings-menu">
        <div class="user-profile">
            <img src="images/profile-pic.png">
            <div>
                <p>John Doe</p>
                <a href="#">See your profile</a>
            </div>
        </div>
        <div class="user-profile">
            <img src="images/feedback.png">
            <div>
                <p>Give feedback</p>
                <a href="#">Help us to improve the new design</a>
            </div>
        </div>
    </div> -->
</nav>

    

    <div class="container">
        <!-------------------- left-sidebar------------ -->
        <div class="left-sidebar">
            <div class="imp-links">
                
                <?php
                    echo '<a href="../postulant/entretiens_c.php"><img src="images/Entretiens.svg"> Entretiens </a>';
                    echo '<a href="../postulant/"><img src="images/Offres.svg"> Offres </a>';
                    echo '<a href="../postulant/reclamationIndex.php"><img src="images/Reclamations.svg"> Reclamations </a>';
                    echo '<a href="../postulant/cv/experience-page.php"><img src="images/edu_svg.svg"> Competences </a>';
                    echo '<a href=""><img src="images/Forum.svg"> Forum </a>';

                ?>
            </div>
        </div>
        <!-------------------- main-content------------ -->
        <div class="main-content">
        <form action="add_post.php" method="post" enctype="multipart/form-data">
            <div class="write-post-container">
                <div class="user-profile">
                    <img src="data:image/png;base64,<?php if (isset($user['image'])){echo base64_encode($user['image']);} ?>" alt="Image de l'utilisateur">
                    <div>
                        <p class="user">user</p>
                        <small>Public</small>
                    </div>
                </div>
                <div class="post-input-container">
                    <textarea rows="1" placeholder="What's on your mind?" name="post-textarea"></textarea>
                    <div class="add-post-links">
                        <label for="photo-upload"><img src="images/photo.png" width="20" height="20" style="margin-left:20px"> Photo/Video</label>
                        <input type="file" name="photo-upload" id="photo-upload" style="display: none;" accept="image/*">
                        <button type="submit" id="button_post">Post</button>
                    </div>
                </div>
            </div>
        </form>




<?php

include '../../../Controller/PostsC.php';
include '../../../Controller/CommentsC.php';
include '../../../Model/Posts.php';
include '../../../Model/Comments.php';
include 'conversion.php';

$postC= new postsC();
$Comments = new commentsC();

$posts = $postC->afficherPost();
$comments= $Comments->afficherComments();

foreach ($posts as $post) {
    $PostID = $post['PostID']; 
    $author = $post['Author']; 
    $time = $post['Time']; 
    $content = $post['Content']; 
    $MediaData= $post['MediaData'];
    $user_id= $post['user_id'];
    $usrcont = new UserC();
    $userpost = $usrcont->GetUserById($user_id);
?>
    <div class="post-container">
    <input type="hidden" name="post_id" value="<?php echo $post['PostID']; ?>">
        <div class="post-row">
            <div class="user-profile">
                
                <img src="data:image/png;base64,<?php if (isset($userpost['image'])){echo base64_encode($userpost['image']);} ?>" alt="Image de l'utilisateur">
                <div>
                   
                    <p><?php echo $userpost['prenom']; ?></p>
                    <span><?php $post['Time'] ?></span>
                </div>
            </div>
            <div class="post-actions-container">
                <?php
                    if($post['user_id']==$user['id']){
                        echo '<div class="post-actions-edit"><i class="fa fa-pencil"></i></div>';
                        echo '<div class="post-actions-delete"><i class="fa fa-trash"></i></div>';
                    }
                ?> 
            </div>
            <div class="options-container" style="display: none;">
                <ul>
                    <li><a href="#" class="edit-comment">Edit</a></li>
                    <li><button class="delete-post">Delete</button></li>
                </ul>
            </div>
<script>
    $(document).ready(function(){
    // Unbind click event to prevent multiple bindings
    $(document).off('click', '.post-actions-delete').on('click', '.post-actions-delete', function(e) {
        e.preventDefault();
        var postId = $(this).closest('.post-container').find('input[name="post_id"]').val(); // Get post ID
        
        // Display a confirmation dialog
        var confirmation = confirm("Are you sure you want to delete this post?");
        
        if (confirmation) {
            // User confirmed deletion, proceed with AJAX request
            var $deleteButton = $(this);
            console.log(postId)
            $.ajax({
                url: 'delete_post.php',
                method: 'GET',
                data: { post_id: postId },
                success: function(response) {
                    console.log('post deleted successfully');
                    $deleteButton.closest('.post-container').remove();
                },
                error: function(xhr, status, error) {
                    console.error('Error deleting post:', error);
                    alert('Failed to delete post. Please try again later.');
                }
            });
        } else {
            // User canceled deletion, do nothing
            console.log('Deletion canceled');
        }
    });

    $('.post-actions-edit').click(function(e) {
        e.preventDefault(); 
        var postContent = $(this).closest('.post-container').find('.post-text');
        var postFile = $(this).closest('.post-container').find('.post-img');
        postContent.attr('contenteditable', 'true');
        postContent.focus();
        $(this).closest('.post-container').find('.save-post').show();
    });

    $('.save-post').click(function(e) {
        e.preventDefault();
        var $saveButton = $(this); // Store reference to the save button
        var postContent = $(this).closest('.post-container').find('.post-text');
        var editedContent = postContent.text();
        var postId = $(this).closest('.post-container').find('input[name="post_id"]').val(); 
        $.ajax({
            url: 'submit_post_edit.php',
            method: 'POST',
            data: { post_id: postId, post_content: editedContent },
            success: function(response) {
                console.log(response);
                postContent.attr('contenteditable', 'false');
                $saveButton.hide(); // Hide the save button
            },
            error: function(xhr, status, error) {
                console.error("Error updating comment:", error);
            }
        });
    });
});
</script>
        </div>
       
        <p class="post-text" name="post_content" contenteditable="false"><?php echo $content; ?></p>
        <button class="save-post">Save</button>
        <img src="<?php echo $MediaData ?>" alt="Post Image" class="post-img" contenteditable="false">

        <div class="post-row">
            <div class="activity-icons">
                <div>
                    <button class="like-button" data-postid="<?php echo $post['PostID']; ?>">Like</button>
                </div>
<script>
      $(document).on('click', '.like-button', function() {
        handleLikeDislike($(this), 'like');
    });

    function handleLikeDislike($button, action) {
        var postId = $button.data('postid');
        $button.prop('disabled', true);

        // Make AJAX request to like/unlike the post
        $.ajax({
            url: 'like_post.php', // Replace with the URL to handle like/unlike action
            method: 'POST',
            data: { post_id: postId, action: action },
            success: function(response) {
                // Update UI based on the response
                if (response === 'liked') {
                    $button.addClass('liked');
                    $button.text('Dislike');
                    console.log("class added: liked");
                } else if (response === 'unliked') {
                    $button.removeClass('liked');
                    $button.text('Like');
                    console.log("class removed: liked");
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            },
            complete: function() {
                // Re-enable the like/dislike button after the AJAX request is complete
                $button.prop('disabled', false);
            }
        });
    }

</script>




            </div>
            <div class="post-profile-icon">
                <img src="data:image/png;base64,<?php if (isset($user['image'])){echo base64_encode($user['image']);} ?>" alt="Image de l'utilisateur">
            </div>
        </div>
        <div class="comment-section">
        
        <?php
$postComments = array_filter($comments, function($comment) use ($PostID) {
    return $comment['PostID'] == $PostID;
});

if (!empty($postComments)) {
    foreach ($postComments as $comment) {
        $user_id= $comment['user_id'];
        $usrcont = new UserC();
        $usercomment = $usrcont->GetUserById($user_id);
        echo '<div class="comment">';
        echo '<div class="user-profile">';
        echo '<img src="';
        if (isset($usercomment['image'])) {
            echo 'data:image/png;base64,' . base64_encode($usercomment['image']);
        }
        echo '" alt="Image de l\'utilisateur">';
        echo '<div>';
        echo '<p class="comment-author">' . $usercomment['prenom'] . '</p>';
        echo '<span class="comment-timestamp">' . $comment['Timestamp'] . '</span>';
        echo '</div>';
        echo '</div>';
        echo '<input type="hidden" name="comment_id" value="' . $comment['CommentID'] . '">';
        echo '<p name="comment-content" class="comment-content" contenteditable="false">' . $comment['content'] . '</p>';
        if($comment['user_id']==$user['id']){
            echo '<button class="save-comment">Save</button>';
            echo '<div class="comment-actions"><i class="fas fa-ellipsis-v"></i></div>';
            echo '<div class="options-container">';
            echo '<ul>';
            echo '<li><a href="#" class="edit-comment">Edit</a></li>';
            echo '<li><button class="delete-comment">Delete</button></li>';
            echo '<li><button class="speak_comment" data-comment="' . $comment['content'] . '">Hear</button></li>';
            echo '</ul>';
            echo '</div>';
        }
        echo '</div>';
    }
}
?>
<script>
     $(document).ready(function(){
    $('.options-container').click(function() {
        $(this).find('.options-container').toggle();
    });
});
$(document).ready(function(){
    $('post-comment').click(function(){
        
        var commentContent = $('comment').val();
        
        
        if(commentContent.trim() === '') {
            alert('Please enter a comment.');
            return;
        }
        
       
        $.ajax({
            url: 'add_comment.php',
            method: 'POST',
            data: { comment_content: commentContent }, 
            success: function(response) {
                console.log('Comment added successfully');
               
                $('comment').val(''); 
            },
            error: function(xhr, status, error) {
                console.error('Error adding comment:', error);
                alert('Failed to add comment. Please try again later.');
            }
        });
    });
    $('.delete-comment').click(function(e) {
    e.preventDefault(); 
    var commentId = $(this).closest('.comment').find('input[name="comment_id"]').val(); // Get comment ID
    var $deleteButton = $(this); 

    $.ajax({
        url: 'delete_comment.php',
        method: 'GET', 
        data: { comment_id: commentId }, 
        success: function(response) {
            console.log('Comment deleted successfully');
            $deleteButton.closest('.comment').remove();
        },
        error: function(xhr, status, error) {
            console.error('Error deleting comment:', error);
            alert('Failed to delete comment. Please try again later.');
        }
    });
});



    $('.comment-actions').click(function(){
        var optionsContainer = $(this).next('.options-container');
        optionsContainer.toggle();
    });

    $('.options-container').mouseleave(function() {
        $(this).show();
    });
     $('.comment').click(function(){
         var optionsContainer = $(this).next('.option-container');
         commentContent.removeAttr('contenteditable');
         optionsContainer.hide();
     });
     $('.edit-comment').click(function(e) {
         e.preventDefault(); 
         var commentContent = $(this).closest('.comment').find('.comment-content');
         
         commentContent.attr('contenteditable', 'true');
         commentContent.focus();
         $(this).closest('.comment').find('.save-comment').show();
     });
     $('.save-comment').click(function(e) {
    e.preventDefault();
    var $saveButton = $(this); // Store reference to the save button
    var commentContent = $(this).closest('.comment').find('.comment-content');
    var editedContent = commentContent.text();
    var commentId = $(this).closest('.comment').find('input[name="comment_id"]').val(); 
    $.ajax({
        url: 'submit_comment_edit.php',
        method: 'POST',
        data: { comment_id: commentId, comment_content: editedContent },
        success: function(response) {
            console.log(response);
            commentContent.attr('contenteditable', 'false');
            $saveButton.hide(); // Hide the save button
        },
        error: function(xhr, status, error) {
            console.error("Error updating comment:", error);
        }
    });
});


});

var speechSynthesisInstance;

// Add event listener for "Lire le commentaire" buttons
document.querySelectorAll('.speak_comment').forEach(function(button) {
    button.addEventListener('click', function() {
        // Get the comment text from the data attribute
        var commentText = this.getAttribute('data-comment');
        
        // If speech synthesis is already in progress, cancel it
        if (speechSynthesisInstance && speechSynthesisInstance.speaking) {
            speechSynthesisInstance.cancel();
        }
        
        // Using Web Speech API for text-to-speech
        var speechSynthesis = window.speechSynthesis;
        var speechUtterance = new SpeechSynthesisUtterance(commentText);
        
        // Set voice language to Arabic
        speechUtterance.lang = 'ar'; // Arabic (Saudi Arabia)
        
        // Speak the comment text
        speechSynthesisInstance = speechSynthesis;
        speechSynthesisInstance.speak(speechUtterance);
    });
});
</script>




       
       <div class="form-container">
       <form action="add_comment.php" method="post" onsubmit="return validateForm(this)">
        <input type="hidden" name="post_id" value="<?php echo $post['PostID']; ?>">
        <input type="text" name="username" value="<?php echo $user['prenom']?>" readonly hidden>
        <textarea name="comment" placeholder="Add a comment" class="comment"></textarea>
        <input type="submit" class="post-comment" value="Add Comment" name="post_comment">
        </form>
        <script>
        function validateForm(form) {
        // Get the value of the comment textarea within the form
        var comment = form.querySelector('.comment').value.trim();
        
        // Check if the comment is empty
        if (comment === '') {
            // Show an alert or message indicating that the comment cannot be empty
            alert('Please enter a comment.');
            return false; // Prevent form submission
        }
        
        // Form is valid, allow submission
        return true;
    }
        </script>
        <form method="post"  action="add_rating.php">

                    <div class="rateyo" id= "rating"
                    data-rateyo-rating="4"
                    data-rateyo-num-stars="5"
                    data-rateyo-score="3">
                    </div>
                <input type="hidden" name="rating">
                <input type="hidden" name="post_id" value="<?php echo $post['PostID']; ?>">
                <input type="submit" style="display: inline-block;">
        </form>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>



    </div>
    </div>
<?php
}
?>




        </div>
        <!-------------------- right-sidebar------------ -->
        <div class="right-sidebar">
            <div class="sidebar-title">
                <h4>Ajouter à votre flux</h4>
                <a href="#">Voir tout</a>
            </div>

            <div class="entreprise">
                <div class="left-entreprise">
                <img src="images/profile-pic.png" alt="user_icon">
                </div>
                <div class="right-entreprise">
                    <h4>Social Media</h4>
                    <p><i class="fa-solid fa-location-dot"></i> Willson Tech Park</p>
                    <button id="follow">+</button>
                </div>
            </div>
            <div class="sidebar-title">
                <h4>Publicité</h4>
            </div>
            <img src="images/ads.png" class="sidebar-ads">
        </div>
    </div>
</body>

<script>
    $(function () {
        $(".rateyo").rateYo().on("rateyo.change", function (e, data) {
            var rating = data.rating;
            $(this).parent().find('.score').text('score :'+ $(this).attr('data-rateyo-score'));
            $(this).parent().find('.result').text('rating :'+ rating);
            $(this).parent().find('input[name=rating]').val(rating); //add rating value to input field
        });
    });
</script>

</html>