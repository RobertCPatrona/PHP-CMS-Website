
<?php
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    if (!$username || !$password) {
        echo "<script>toastr.info('The username and password fields cannot be empty');</script>";
    } else {
        $username = mysqli_real_escape_string($connection, $username);
        $password = mysqli_real_escape_string($connection, $password);

        $query = "SELECT * FROM users WHERE username = '{$username}'";
        $selected_user = mysqli_query($connection, $query);
        if (!$selected_user) {
            die('Query Failed' . mysqli_error($connection));
        }

        while ($row = mysqli_fetch_assoc($selected_user)) {
            $db_user_id = $row['user_id'];
            $db_username = $row['username'];
            $db_user_password = $row['user_password'];
            $db_user_firstname = $row['user_firstname'];
            $db_user_lastname = $row['user_lastname'];
            $db_user_email = $row['user_email'];
            $db_user_role = $row['user_role'];
        }

        if (!empty($db_user_password) && password_verify($password, $db_user_password)) {
            $_SESSION['id'] = $db_user_id;
            $_SESSION['username'] = $db_username;
            $_SESSION['firstname'] = $db_user_firstname;
            $_SESSION['lastname'] = $db_user_lastname;
            $_SESSION['email'] = $db_user_email;
            $_SESSION['user_role'] = $db_user_role;

            echo "<script>location.replace('admin/index.php');</script>";
        } else {
            echo "<script>toastr.info('Wrong username and/or password. Please try again.');</script>";
        }
    }
}
?>