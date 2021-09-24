<?php include 'delete_modal.php'; ?>

<?php $my_id = $_SESSION['id'] ?>

<?php
if (isset($_POST['checkBoxArray'])) {
    foreach ($_POST['checkBoxArray'] as $checkBoxID) {
        $bulk_options = $_POST['bulk_options'];

        switch ($bulk_options) {
            case 'publish':
                $query = "UPDATE posts SET post_status = 'published' WHERE post_id = {$checkBoxID}";
                $result = mysqli_query($connection, $query);
                confirmQuery($result);
                break;
            case 'draft':
                $query = "UPDATE posts SET post_status = 'draft' WHERE post_id = {$checkBoxID}";
                $result = mysqli_query($connection, $query);
                confirmQuery($result);
                break;
            case 'delete':
                // Delete post
                $query = "DELETE FROM posts WHERE post_id = {$checkBoxID}";
                $result = mysqli_query($connection, $query);
                confirmQuery($result);

                // Delete post comments
                $query = "DELETE FROM comments WHERE comment_post_id = {$checkBoxID}";
                $result = mysqli_query($connection, $query);
                confirmQuery($result);

                // Delete post likes
                $query = "DELETE FROM likes WHERE post_id = {$checkBoxID}";
                $result = mysqli_query($connection, $query);
                confirmQuery($result);

                break;
            case 'clone':
                $query = "SELECT * FROM posts WHERE post_id = {$checkBoxID}";
                $result = mysqli_query($connection, $query);
                confirmQuery($result);

                $row = mysqli_fetch_assoc($result);
                $post_id = $row['post_id'];
                $post_user_id = $row['post_user_id'];
                $post_user = $row['post_user'];
                $post_title = $row['post_title'];
                $post_category_id = $row['post_category_id'];
                $post_status = $row['post_status'];
                $post_image = $row['post_image'];
                $post_tags = $row['post_tags'];
                $post_date = $row['post_date'];
                $post_content = $row['post_content'];

                $query = "INSERT INTO posts(post_category_id, post_title, post_user_id, post_user, post_date, post_image, post_content, post_tags, post_status) ";
                $query .= "VALUES('{$post_category_id}', '{$post_title}', '{$post_user_id}', '{$post_user}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}')";

                $result = mysqli_query($connection, $query);
                confirmQuery($result);
                break;
        }
    }
    echo "<script>toastr.success('Option has been applied')</script>";
}
?>

<?php
if (isset($_GET['reset_views'])) {
    $id = $_GET['reset_views'];

    $query = "UPDATE posts SET post_views = 0 WHERE post_id = {$id}";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);

    echo "<script>toastr.success('Views have been reset')</script>";
}
?>

<form action="" method='post'>

    <table class='table table-bordered table-hover'>
        <div id="bulkOptionsContainer">
            <div class='col-xs-4'>
                <select class='form-control' name="bulk_options" id="">
                    <option value="">Select Options</option>
                    <option value="publish">Publish</option>
                    <option value="draft">Draft</option>
                    <option value="delete">Delete</option>
                    <option value="clone">Clone</option>
                </select>
            </div>

            <div class='col-xs-4'>
                <input type="submit" , name='submit' , class='btn btn-success' value='Apply'>
                <a href="posts.php?source=add_post" class='btn btn-primary'>Add New</a>
            </div>
        </div>

        <thead>
            <tr>
                <th><input type="checkbox" id='selectAllBoxes'></th>
                <th>ID</th>
                <?php if (isAdmin()) : ?>
                    <th>User</th>
                <?php endif; ?>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Date</th>
                <th>Likes</th>
                <th>Views</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>

            <?php
            if (isAdmin()) {
                $query = "SELECT * FROM posts ORDER BY post_id DESC";
            } else {
                $query = "SELECT * FROM posts WHERE post_user_id = {$my_id} ORDER BY post_id DESC";
            }
            $get_posts = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($get_posts)) {
                $post_id = $row['post_id'];
                $post_user = $row['post_user'];
                $post_title = $row['post_title'];
                $post_category_id = $row['post_category_id'];
                $post_status = $row['post_status'];
                $post_image = $row['post_image'];
                $post_tags = $row['post_tags'];
                $post_comment_count = $row['post_comment_count'];
                $post_date = $row['post_date'];
                $post_views = $row['post_views'];
                $post_likes = $row['post_likes'];

                echo "<tr>";
                echo "<td><input type='checkbox' class='checkBoxes' name='checkBoxArray[]' value='{$post_id}'></td>";
                echo "<td>{$post_id}</td>";
                if (isAdmin()) {
                    echo "<td>{$post_user}</td>";
                }
                echo "<td><a href='../post.php?p_id={$post_id}'>{$post_title}</a></td>";

                $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id}";
                $get_cat = mysqli_query($connection, $query);


                if (mysqli_num_rows($get_cat) < 1) {
                    $cat_title = 'No Category';
                } else {
                    $cat_title = mysqli_fetch_assoc($get_cat)['cat_title'];
                }

                echo "<td>{$cat_title}</td>";
                echo "<td>{$post_status}</td>";
                echo "<td><img width='100' src='../images/{$post_image}' alt='post_image'></td>";
                echo "<td>{$post_tags}</td>";

                $comment_query = "SELECT * FROM comments where comment_post_id = {$post_id}";
                $result = mysqli_query($connection, $comment_query);
                $num_comments = mysqli_num_rows($result);

                echo "<td>{$num_comments}</td>";
                echo "<td>{$post_date}</td>";
                echo "<td>{$post_likes}</td>";
                echo "<td>{$post_views} | <a href='posts.php?reset_views={$post_id}'>Reset</a></td>";
                echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
                echo "<td><a href='javascript:void(0)' rel='{$post_id}' class='delete_link'>Delete</a></td>";
                echo "</tr>";
            }
            ?>

        </tbody>
    </table>
</form>

<?php
if (isset($_GET['delete_post'])) {
    $post_id = $_GET['delete_post'];

    // To get the user id of the deleting post. If I am a subscriber, I can only delete the posts with my user id.
    $query = "SELECT * FROM posts WHERE post_id = {$post_id}";
    $get_post = mysqli_query($connection, $query);
    $user_id = mysqli_fetch_assoc($get_post)['post_user_id'];

    if (isAdmin() || (isSub() && $user_id == $my_id)) {

        // Delete post
        $query = "DELETE FROM posts WHERE post_id = {$post_id}";
        $delete_post = mysqli_query($connection, $query);
        confirmQuery($delete_post);

        // Delete post comments
        $query = "DELETE FROM comments WHERE comment_post_id = {$post_id}";
        $result = mysqli_query($connection, $query);
        confirmQuery($result);

        // Delete post likes
        $query = "DELETE FROM likes WHERE post_id = {$post_id}";
        $result = mysqli_query($connection, $query);
        confirmQuery($result);

        header('Location: posts.php');
    }
}
?>

<script>
    $(document).ready(function() {
        $('.delete_link').on('click', function() {
            var id = $(this).attr('rel');

            var url = "posts.php?delete_post=" + id;

            $(".modal_delete").attr("href", url);

            $('#myModal').modal('show');
        })
    })
</script>