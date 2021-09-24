<?php include 'db.php'; ?>
<?php include '../admin/functions.php'; ?>
<?php session_start(); ?>

<?php

if (isset($_SESSION['username'])) {
    $my_id =  $_SESSION['id'];
    $post_id = $_GET['p_id'];

    $query = "SELECT * FROM likes WHERE post_id = {$post_id} AND user_id = {$my_id}";

    $liked = countQueryRows($query) > 0;

    if ($liked) {
        // echo 'liked is 1';

        $query = "DELETE FROM likes WHERE post_id = {$post_id} AND user_id = {$my_id}";
        $result = mysqli_query($connection, ($query));
        
        $query = "UPDATE posts SET post_likes = post_likes - 1 WHERE post_id = {$post_id}";
        $result = mysqli_query($connection, ($query));
    } else {
        // echo 'liked is 0';

        $query = "INSERT INTO likes(post_id, user_id) VALUES({$post_id}, {$my_id})";
        $result = mysqli_query($connection, ($query));
        
        $query = "UPDATE posts SET post_likes = post_likes + 1 WHERE post_id = {$post_id}";
        $result = mysqli_query($connection, ($query));
    }
} else {
    echo "<script>alert('You must be logged in to like')</script>";
}

header("Location: javascript:history.back()");
?>