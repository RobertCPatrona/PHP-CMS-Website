<?php include 'includes/header.php'; ?>

<!-- Navigation -->
<?php include 'includes/navigation.php'; ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <?php
            if (isset($_POST['submit'])) {
                $search = mysqli_real_escape_string($connection, $_POST['search']);

                if (!$search) {
                    header('Location: index.php');
                }

            ?>
                <h1 class="page-header">
                    Searched Posts for "<?php echo $search; ?>"
                </h1>

                <?php

                if (isAdmin()) {
                    $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%' ORDER BY post_id DESC";
                } else {
                    $query = "SELECT * FROM posts WHERE post_status = 'published' AND post_tags LIKE '%$search%' ORDER BY post_id DESC";
                }

                $result = mysqli_query($connection, $query);
                if (!$result) {
                    die('QUERY FAILED ' . mysqli_error($connection));
                }

                $nrRows = mysqli_num_rows($result);
                if ($nrRows < 1) {
                    echo '<h1>No Results</h1>';
                } else {

                    while ($row = mysqli_fetch_assoc($result)) {
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_user = $row['post_user'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = str_replace('\\', '', substr($row['post_content'], 0, 220));
                ?>

                        <h2>
                            <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                        </h2>

                        <p class="lead">
                            by <a href="index.php"><?php echo $post_user; ?></a>
                        </p>

                        <p>
                            <span class="glyphicon glyphicon-time"></span> <?php echo date('j F Y', strtotime($post_date)); ?>
                        </p>
                        <hr>

                        <a href="post.php?p_id=<?php echo $post_id; ?>">
                            <img class="img-responsive center-block smallerImg" src="images/<?php echo $post_image; ?>" alt="">
                        </a>
                        <hr>
                        <h4>
                            <?php echo $post_content . '...'; ?>
                        </h4>
                        <br>

                        <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                        <hr>

            <?php
                    }
                }
            }
            ?>
        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include 'includes/sidebar.php'; ?>

    </div>
    <!-- /.row -->

    <hr>

    <?php include 'includes/footer.php'; ?>