<?php include 'delete_modal.php'; ?>

<?php
if (!isAdmin()) {
    header('Location: index.php');
}
?>

<table class='table table-bordered table-hover'>
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Admin</th>
            <th>Subscriber</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>

        <?php
        $query = "SELECT * FROM users";
        $get_users = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($get_users)) {
            $user_id  = $row['user_id'];
            $username = $row['username'];
            $user_password = $row['user_password'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_image = $row['user_image'];
            $user_role = $row['user_role'];

            echo "<tr>
                <td>{$user_id}</td>
                <td>{$username}</td>
                <td>{$user_firstname}</td>
                <td>{$user_lastname}</td>";

            echo "<td>{$user_email}</td>
                <td>{$user_role}</td>
                <td><a href='users.php?make_admin={$user_id}'>Admin</a></td>
                <td><a href='users.php?make_sub={$user_id}'>Subscriber</a></td>
                <td><a href='users.php?source=edit_user&edit_user={$user_id}'>Edit</a></td>
                <td><a href='javascript:void(0)' rel='{$user_id}' class='delete_users'>Delete</a></td>";
        }
        ?>

    </tbody>
</table>

<?php
if (isset($_GET['make_admin'])) {
    $id = $_GET['make_admin'];

    $query = "UPDATE users SET user_role = 'admin' WHERE user_id = $id";
    $result = mysqli_query($connection, $query);

    confirmQuery($result);
    header('Location: users.php');
}


if (isset($_GET['make_sub'])) {
    $id = $_GET['make_sub'];

    $query = "UPDATE users SET user_role = 'subscriber' WHERE user_id = $id";
    $result = mysqli_query($connection, $query);

    confirmQuery($result);
    header('Location: users.php');
}


if (isset($_GET['delete_user'])) {

    echo 'Is set user role ' . $_SESSION['user_role'];

    if (isset($_SESSION['user_role'])) {
        if ($_SESSION['user_role'] == 'admin') {
            $id = $_GET['delete_user'];

            $query = "DELETE FROM users WHERE user_id = {$id}";
            $result = mysqli_query($connection, $query);
        
            confirmQuery($result);
            header('Location: users.php');
        }
    }
}
?>

<script>
    $(document).ready(function() {
        $('.delete_users').on('click', function() {
            var id = $(this).attr('rel');

            var url = "users.php?delete_user=" + id;

            $(".modal_delete").attr("href", url);

            $('#myModal').modal('show');
        })
    })
</script>