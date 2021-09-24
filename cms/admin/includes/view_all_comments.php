<?php include 'delete_modal.php'; ?>

<?php $my_id = $_SESSION['id'] ?>

<table class='table table-bordered table-hover'>
    <thead>
        <tr>
            <th>ID</th>
            <?php if (isAdmin()) : ?>
                <th>Author</th>
                <th>Email</th>
            <?php endif; ?>
            <th>Comment</th>
            <th>Status</th>
            <th>In response to</th>
            <th>Date</th>
            <?php if (isAdmin()) : ?>
                <th>Approve</th>
                <th>Unapprove</th>
            <?php endif; ?>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>

        <?php
        if (isAdmin()) {
            $query = "SELECT * FROM comments";
        } else {
            $query = "SELECT * FROM comments WHERE comment_author_id = {$my_id}";
        }
        $get_comments = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($get_comments)) {
            $comment_id  = $row['comment_id'];
            $comment_post_id = $row['comment_post_id'];
            $comment_author = $row['comment_author'];
            $comment_email = $row['comment_email'];
            $comment_content = $row['comment_content'];
            $comment_status = $row['comment_status'];
            $comment_date = $row['comment_date'];

            echo "<tr>";
            echo "<td>{$comment_id}</td>";
            if (isAdmin()) {
                echo "<td>{$comment_author}</td>";
                echo "<td>{$comment_email}</td>";
            }
            echo "<td>{$comment_content}</td>";

            $query = "SELECT * FROM posts WHERE post_id = {$comment_post_id}";
            $result = mysqli_query($connection, $query);
            confirmQuery($result);
            $row = mysqli_fetch_assoc($result);

            echo "<td>{$comment_status}</td>";
            echo "<td><a href='../post.php?p_id={$comment_post_id}'>{$row['post_title']}</a></td>";
            echo "<td>{$comment_date}</td>";
            if (isAdmin()) {
                echo "<td><a href='comments.php?approved={$comment_id}'>Approve</a></td>";
                echo "<td><a href='comments.php?unapproved={$comment_id}'>Unapprove</a></td>";
            }
            echo "<td><a href='javascript:void(0)' rel='{$comment_id}' class='delete_comments'>Delete</a></td>";
        }
        ?>

    </tbody>
</table>

<?php
if (isset($_GET['approved'])) {
    $id = $_GET['approved'];

    $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = $id";
    $result = mysqli_query($connection, $query);

    confirmQuery($result);
    header('Location: comments.php');
}

if (isset($_GET['unapproved'])) {
    $id = $_GET['unapproved'];

    $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = $id";
    $result = mysqli_query($connection, $query);

    confirmQuery($result);
    header('Location: comments.php');
}

if (isset($_GET['delete_comment'])) {
    $comment_id = $_GET['delete_comment'];

    // To get the user id of the deleting comment. If I am a subscriber, I can only delete the comments with my user id.
    $query = "SELECT * FROM comments WHERE comment_id = {$comment_id}";
    $get_comment = mysqli_query($connection, $query);
    $user_id = mysqli_fetch_assoc($get_comment)['comment_author_id'];

    if (isAdmin() || (isSub() && $user_id == $my_id)) {

        $query = "DELETE FROM comments WHERE comment_id = {$comment_id}";
        $delete_comment = mysqli_query($connection, $query);

        confirmQuery($delete_comment);
        header('Location: comments.php');
    }
}
?>

<script>
    $(document).ready(function() {
        $('.delete_comments').on('click', function() {
            var id = $(this).attr('rel');

            var url = "comments.php?delete_comment=" + id;

            $(".modal_delete").attr("href", url);

            $('#myModal').modal('show');
        })
    })
</script>