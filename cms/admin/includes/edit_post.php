<?php escapeAllData(); ?>

<?php

// Get the post
if (isset($_GET['p_id'])) {
    $p_id = $_GET['p_id'];
}

$query = "SELECT * FROM posts WHERE post_id = $p_id";
$get_post = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($get_post)) {
    $post_id = $row['post_id'];
    $post_user_id = $row['post_user_id'];
    $post_user = $row['post_user'];
    $post_title = $row['post_title'];
    $post_category_id = $row['post_category_id'];
    $post_status = $row['post_status'];
    $post_image = $row['post_image'];
    $my_post_image = $row['post_image'];
    $post_tags = $row['post_tags'];
    $post_content = $row['post_content'];
}


// Edit post

if (isset($_POST['edit_post'])) {
    $post_title = escape($_POST['post_title']);
    $post_category_id = escape($_POST['post_category_id']);
    $post_status = escape($_POST['post_status']);

    $post_image = $_FILES['post_image']['name'];
    $post_image_temp = $_FILES['post_image']['tmp_name'];

    $post_tags = escape($_POST['post_tags']);
    $post_content = escape($_POST['post_content']);

    move_uploaded_file($post_image_temp, "../images/{$post_image}");

    if (empty($post_image)) {
        $post_image = $my_post_image;
    }

    if (empty($post_title) || empty($post_content)) {
        echo "<script>toastr.info('Please add a title and content')</script>";
    } else {

        $query = "UPDATE posts SET ";
        $query .= "post_title = '{$post_title}', ";
        $query .= "post_category_id = '{$post_category_id}', ";
    
        if (isAdmin()) {
            $post_user_id = escape(explode('/', $_POST['post_user'])[0]);
            $post_user = escape(explode('/', $_POST['post_user'])[1]);
    
            $query .= "post_user_id = '{$post_user_id}', ";
            $query .= "post_user = '{$post_user}', ";
        } else {
            $post_user_id = $_SESSION['id'];
            $post_user = $_SESSION['username'];
    
            $query .= "post_user_id = '{$post_user_id}', ";
            $query .= "post_user = '{$post_user}', ";
        }
    
        $query .= "post_status = '{$post_status}', ";
        $query .= "post_image = '{$post_image}', ";
        $query .= "post_tags = '{$post_tags}', ";
        $query .= "post_content = '{$post_content}' ";
        $query .= "WHERE post_id = {$p_id}";
    
        $edit_post = mysqli_query($connection, $query);
        confirmQuery($edit_post);
    
        echo "<script>toastr.success('Post Edited')</script>";
        echo "<p class='bg-success'>Post was Updated <a href='../post.php?p_id={$post_id}'>Go to Post</a> or <a href='posts.php'>Back to Posts List</a></p>";
    }
}
?>


<form action="" method='post' , enctype="multipart/form-data">

    <div class="form-group">
        <label for="post_title">Title</label>
        <input value='<?php echo $post_title; ?>' type="text" class='form-control' name='post_title'>
    </div>

    <div class="form-group">
        <label for="post_category_id">Category ID</label>
        <br>
        <select name="post_category_id" id="post_category_id">

            <?php
            $query = "SELECT * FROM categories";
            $get_cats = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($get_cats)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];

                // Get selected cat id
                if ($cat_id == $post_category_id) {
                    echo "<option value='{$cat_id}' selected>{$cat_title}</option>";
                } else {
                    echo "<option value='{$cat_id}'>{$cat_title}</option>";
                }
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

                echo "<option value='{$post_user_id}/{$post_user}'>{$post_user}</option>";

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
            <option value=<?php echo $post_status; ?>><?php echo ucfirst($post_status); ?></option>

            <?php
            if ($post_status == 'published') {
                echo "<option value='draft'>Draft</option>";
            } else {
                echo "<option value='published'>Published</option>";
            }
            ?>

        </select>
    </div>

    <label for="post_image">Image</label>
    <div class="form-group">
        <img src="../images/<?php echo $post_image ?>" alt="post_image" width='200'>
    </div>
    <div class="form-group">
        <input type="file" name='post_image'>
    </div>

    <div class="form-group">
        <label for="post_tags">Tags</label>
        <input value='<?php echo $post_tags; ?>' type="text" class='form-control' name='post_tags'>
    </div>

    <div class="form-group">
        <label for="post_content">Content</label>
        <textarea class='form-control' cols='30' rows='10' name='post_content' id='summernote'><?php echo str_replace('\r\n', '</br>', $post_content); ?></textarea>
    </div>

    <div class="form-group">
        <input type="submit" class='btn btn-primary' name='edit_post' value='Update Post'>
    </div>

</form>