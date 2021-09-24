<?php include 'includes/header.php'; ?>

<!-- Navigation -->
<?php include 'includes/navigation.php'; ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <h1 class="page-header">
                Posts
            </h1>

            <?php

            // Get posts count
            if (isAdmin()) {
                $count_query = "SELECT * FROM posts";
            } else {
                $count_query = "SELECT * FROM posts WHERE post_status = 'published'";
            }

            $count_result = mysqli_query($connection, ($count_query));
            $count_rows = mysqli_num_rows($count_result);

            // No posts
            if ($count_rows == 0) {
                echo "<h2 class='text-center'>No Posts Found</h2>";
            }

            // Nr of posts per page
            $count = 5;

            // Compute the nr of pages
            $pages = ceil($count_rows / $count);


            // GET request for pagination
            if (isset($_GET['page'])) {     // Other page
                $page = $_GET['page'];
                $start = ($page - 1) * $count;
            } else {                        // Front page
                $page = 0;
                $start = 0;
            }

            // Get posts
            if (isAdmin()) {
                $query = "SELECT * FROM posts ORDER BY post_id DESC LIMIT {$start}, {$count}";
            } else {
                $query = "SELECT * FROM posts WHERE post_status = 'published' ORDER BY post_id DESC LIMIT {$start}, {$count}";
            }

            $result = mysqli_query($connection, ($query));

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
                    by <a href="author_posts.php?author=<?php echo $post_user; ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_user; ?></a>
                </p>
                <p>
                    <span class="glyphicon glyphicon-time"></span>
                    <?php echo date('j F Y', strtotime($post_date)); ?>
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

                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </a>

                <hr>
            <?php
            }
            ?>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include 'includes/sidebar.php'; ?>

    </div>
    <!-- /.row -->

    <hr>

    <ul class='pager'>
        <?php
        if ($count_rows >= 5) {
            for ($i = 1; $i <= $pages; $i++) {
                if ($i == $page || ($i == 1 && $page == 0)) {
                    echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>";
                } else {
                    echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
                }
            }
        }
        ?>
    </ul>

    <?php include 'includes/footer.php'; ?>