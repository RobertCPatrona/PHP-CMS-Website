<?php escapeAllData(); ?>

<?php
if (isset($_POST['add_post'])) {
    $post_category_id = escape($_POST['post_category_id']);
    $post_title = escape($_POST['post_title']);

    $post_image = $_FILES['post_image']['name'];
    $post_image_temp = $_FILES['post_image']['tmp_name'];

    $post_content = escape($_POST['post_content']);
    $post_tags = escape($_POST['post_tags']);
    $post_status = escape($_POST['post_status']);

    move_uploaded_file($post_image_temp, "../images/{$post_image}");

    if (empty($post_title) || empty($post_content)) {
        echo "<script>toastr.info('Please add a title and content')</script>";
    } else if (empty($post_image)) {
        echo "<script>toastr.info('Please select an image')</script>";
    } else {

        if (isAdmin()) {
            $post_user_id = escape(explode('/', $_POST['post_user'])[0]);
            $post_user = escape(explode('/', $_POST['post_user'])[1]);
    
            $query = "INSERT INTO posts(post_category_id, post_title, post_user_id, post_user, post_date, post_image, post_content, post_tags, post_status) ";
            $query .= "VALUES('{$post_category_id}', '{$post_title}', '{$post_user_id}', '{$post_user}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}')";
        } else {
            $post_user_id = $_SESSION['id'];
            $post_user = $_SESSION['username'];
    
            $query = "INSERT INTO posts(post_category_id, post_title, post_user_id, post_user, post_date, post_image, post_content, post_tags, post_status) ";
            $query .= "VALUES('{$post_category_id}', '{$post_title}', '{$post_user_id}', '{$post_user}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}')";
        }
    
        $add_post_query = mysqli_query($connection, $query);
        confirmQuery($add_post_query);
    
        $new_id = mysqli_insert_id($connection);

        echo "<script>toastr.success('Post Added')</script>";
        echo "<p class='bg-success'>Post Created <a href='../post.php?p_id={$new_id}'>Go to Post</a> or <a href='posts.php'>Back to Posts List</a></p>";
    }
}

?>

<form action="" method='post' , enctype="multipart/form-data">

    <div class="form-group">
        <label for="post_title">Title</label>
        <input type="text" class='form-control' name='post_title'>
    </div>

    <div class="form-group">
        <label for="post_category_id">Category</label>
        <br>
        <select name="post_category_id" id="post_category_id">

            <?php
            $query = "SELECT * FROM categories";
            $get_cats = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($get_cats)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];

                echo "<option value='{$cat_id}'>{$cat_title}</option>";
            }
            ?>

        </select>
    </div>

    <?php if (isAdmin()) : ?>
        <div class="form-group">
            <label for="post_user">User</label>
            <br>
            <select name="post_user" id="post_user">

                <?php
                $query = "SELECT * FROM users";
                $get_users = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($get_users)) {
                    $user_id = $row['user_id'];
                    $username = $row['username'];

                    echo "<option value='{$user_id}/{$username}'>{$username}</option>";
                }
                ?>

            </select>
        </div>
    <?php endif; ?>

    <div class="form-group">
        <label for="post_status">Status</label>
        <br>
        <select name="post_status" id="post_status">
            <option value="draft">Draft</option>
            <option value="published">Published</option>
        </select>
    </div>

    <div class="form-group">
        <label for="post_image">Image</label>
        <input type="file" name='post_image'>
    </div>

    <div class="form-group">
        <label for="post_tags">Tags</label>
        <input type="text" class='form-control' name='post_tags'>
    </div>

    <div class="form-group">
        <label for="summernote">Content</label>
        <textarea class='form-control' cols='30' rows='10' name='post_content' id="summernote"></textarea>
    </div>

    <div class="form-group">
        <input type="submit" class='btn btn-primary' name='add_post' value='Publish Post'>
    </div>

</form>