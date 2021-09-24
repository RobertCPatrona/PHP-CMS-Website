<?php
if (!isAdmin()) {
    header('Location: index.php');
}
?>
<?php escapeAllData(); ?>

<?php
// Get the user
if (isset($_GET['edit_user'])) {
    $user_id = $_GET['edit_user'];

    $query = "SELECT * FROM users WHERE user_id = $user_id";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);

    $row = mysqli_fetch_assoc($result);

    $user_firstname = $row['user_firstname'];
    $user_lastname = $row['user_lastname'];
    $user_role = $row['user_role'];
    $username = $row['username'];
    $user_email = $row['user_email'];
    $user_password = $row['user_password'];
}


// Update user
if (isset($_POST['edit_user'])) {
    $user_firstname = escape($_POST['user_firstname']);
    $user_lastname = escape($_POST['user_lastname']);
    $user_role = escape($_POST['user_role']);

    // $post_image = $_FILES['post_image']['name'];
    // $post_image_temp = $_FILES['post_image']['tmp_name'];
    // move_uploaded_file($post_image_temp, "../images/{$post_image}");

    $username = escape($_POST['username']);
    $user_email = escape($_POST['user_email']);
    $user_password = escape($_POST['user_password']);
    $encrypted_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));


    if (!$user_firstname || !$user_lastname || !$username || !$user_email) {
        echo "<script>toastr.info('All the fields except the Password field are mandatory')</script>";

    } else {
        $query = "UPDATE users SET ";
        $query .= "user_firstname = '{$user_firstname}', ";
        $query .= "user_lastname = '{$user_lastname}', ";
        $query .= "user_role = '{$user_role}', ";
        $query .= "username = '{$username}', ";
        $query .= "user_email = '{$user_email}' ";
        if ($user_password) {
            $query .= ", user_password = '{$encrypted_password}' ";
        }
        $query .= "WHERE user_id = {$user_id}";
    
        $result = mysqli_query($connection, $query);
        confirmQuery($result);
        header('Location: users.php');
    }
}
?>

<form action="" method='post' , enctype="multipart/form-data">

    <div class="form-group">
        <label for="user_firstname">First Name</label>
        <input type="text" class='form-control' name='user_firstname' value=<?php echo $user_firstname; ?>>
    </div>

    <div class="form-group">
        <label for="user_lastname">Last Name</label>
        <input type="text" class='form-control' name='user_lastname' value=<?php echo $user_lastname; ?>>
    </div>

    <div class="form-group">
        <select name="user_role" id="user_role">

            <option value=<?php echo $user_role; ?>><?php echo ucfirst($user_role); ?></option>
            <?php
            if ($user_role == 'admin') {
                echo "<option value='subscriber'>Subscriber</option>";
            } else {
                echo "<option value='admin'>Admin</option>";
            }
            ?>

        </select>
    </div>

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class='form-control' name='username' value=<?php echo $username; ?>>
    </div>

    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class='form-control' name='user_email' value=<?php echo $user_email; ?>>
    </div>

    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" class='form-control' name='user_password' autocomplete="off">
    </div>

    <div class="form-group">
        <input type="submit" class='btn btn-primary' name='edit_user' value='Update User'>
    </div>

    <!-- <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name='post_image'>
    </div> -->

</form>
