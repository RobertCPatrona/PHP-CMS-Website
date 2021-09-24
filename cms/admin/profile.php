<?php include 'includes/admin_header.php'; ?>
<?php escapeAllData(); ?>

<!-- Get profile -->
<?php
if (isset($_SESSION['username'])) {
    echo $_SESSION['username'];

    $username = $_SESSION['username'];

    $query = "SELECT * FROM users WHERE username = '{$username}'";
    $get_profile = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($get_profile)) {
        $user_id  = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
    }
}
?>

<!-- Do the update -->
<?php
if (isset($_POST['edit_user'])) {
    $user_firstname = escape($_POST['user_firstname']);
    $user_lastname = escape($_POST['user_lastname']);

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
        $query .= "username = '{$username}', ";
        $query .= "user_email = '{$user_email}' ";
        if ($user_password) {
            $query .= ", user_password = '{$encrypted_password}' ";
        }
        $query .= "WHERE username = ',{$username}'";

        $result = mysqli_query($connection, $query);
        confirmQuery($result);
        header('Location: users.php');
    }
}
?>

<div id="wrapper">

    <!-- Navigation -->
    <?php include 'includes/admin_navigation.php'; ?>

    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">

                    <h1 class="page-header">
                        My Profile
                    </h1>

                    <!-- Form -->
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
                            <input type="submit" class='btn btn-primary' name='edit_user' value='Update Profile'>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include 'includes/admin_footer.php'; ?>