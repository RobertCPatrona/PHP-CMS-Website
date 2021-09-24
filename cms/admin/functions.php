<?php

function escapeAllData()
{
    global $connection;

    foreach ($_POST as $field => $value) {
        $_POST[$field] = mysqli_real_escape_string($connection, trim($value));
    }
}

function escape($string)
{
    global $connection;

    return mysqli_real_escape_string($connection, trim($string));
}

function isAdmin()
{
    if (isset($_SESSION['user_role'])) {
        if ($_SESSION['user_role'] == 'admin') {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function isSub()
{
    if (isset($_SESSION['user_role'])) {
        if ($_SESSION['user_role'] == 'subscriber') {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function countQueryRows($query)
{
    global $connection;

    $result = mysqli_query($connection, $query);
    return mysqli_num_rows($result);
}

function confirmQuery($query_result)
{
    global $connection;

    if (!$query_result) {
        die('QUERY FAILED ' . mysqli_error($connection));
    }
}



function getAllCategories()
{
    global $connection;

    $query = "SELECT * FROM categories";
    $get_cats = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($get_cats)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";

        if (isAdmin()) {
            echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
            echo "<td><a href='javascript:void(0)' rel='{$cat_id}' class='delete_cats'>Delete</a></td>";
        }
        echo "</tr>";
    }
}

function addCategory()
{
    global $connection;

    if (isset($_POST['submit'])) {
        $cat_title = $_POST['cat_title'];
        $cat_title = mysqli_real_escape_string($connection, $cat_title);
        $cat_title = mysqli_real_escape_string($connection, $cat_title);

        if ($cat_title == '' || empty($cat_title)) {
            echo 'This field should not be empty';
        } else {
            $query = "INSERT INTO categories(cat_title) VALUES('$cat_title')";
            $add_cat = mysqli_query($connection, $query);

            if (!$add_cat) {
                die('QUERY FAILED ' . mysqli_error($connection));
            }

            echo "<script>toastr.success('Category Added')</script>";
        }
    }
}

function getCategoryToEdit()
{
    global $connection;

    if (isset($_GET['edit'])) {
        $cat_id = $_GET['edit'];

        $query = "SELECT * FROM categories WHERE cat_id = {$cat_id}";
        $get_cat = mysqli_query($connection, $query);
        $to_edit = mysqli_fetch_assoc($get_cat);
?>
        <input value="<?php
                        if (isset($to_edit['cat_title'])) {
                            echo $to_edit['cat_title'];
                        }
                        ?>" class='form-control' type="text" name='cat_title'>
<?php
    }
}

function editCategory()
{
    global $connection;

    if (isset($_POST['update_category'])) {
        $cat_title = $_POST['cat_title'];
        $cat_title = mysqli_real_escape_string($connection, $cat_title);
        $cat_title = mysqli_real_escape_string($connection, $cat_title);

        $query = "UPDATE categories SET cat_title = '{$cat_title}' WHERE cat_id = {$_GET['edit']}";
        $update_query = mysqli_query($connection, $query);
        if (!$update_query) {
            die('QUERY FAILED ' . mysqli_error($connection));
        }
        header('Location: categories.php');
    }
}

function deleteCategory()
{
    global $connection;

    if (isset($_GET['delete']) && isAdmin()) {
        $to_delete = $_GET['delete'];

        $query = "DELETE FROM categories WHERE cat_id = {$to_delete}";
        $delete_query = mysqli_query($connection, $query);
        if (!$delete_query) {
            die('QUERY FAILED ' . mysqli_error($connection));
        }
        header('Location: categories.php');
    }
}

function usersOnline()
{
    global $connection;


    $session = session_id();
    $time = time();
    $time_out_seconds = 30;             // User is logged out if he doesnt do anything for more than X sec
    $time_out = $time - $time_out_seconds;

    $query = "SELECT * FROM users_online WHERE session = '{$session}'";     // Look for my session
    $result = mysqli_query($connection, $query);
    $count = mysqli_num_rows($result);

    if ($count == NULL) {                                       // I am not online
        $query = "INSERT INTO users_online(session, time) VALUES('{$session}', '{$time}')";
        mysqli_query($connection, $query);
    } else {                                                    // I am online, so update the time
        $query = "UPDATE users_online SET time = '{$time}' WHERE session = '{$session}'";
        mysqli_query($connection, $query);
    }

    // Get all currently online users; need to have been to admin in less than 60 seconds. If the DB time is before 60 seconds ago, he is "Offline"
    $select_online = "SELECT * FROM users_online WHERE time > '{$time_out}'";
    $result = mysqli_query($connection, $select_online);

    return mysqli_num_rows($result);
}

?>