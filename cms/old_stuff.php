<?php
$query = "SELECT * FROM categories";
$result = mysqli_query($connection, ($query));

while ($row = mysqli_fetch_assoc($result)) {
    $cat_id = $row['cat_id'];
    $cat_title = $row['cat_title'];

    $cat_active = 'active';

    echo "<li><a href='category.php?cat={$cat_id}'>{$cat_title}</a></li>";
}
