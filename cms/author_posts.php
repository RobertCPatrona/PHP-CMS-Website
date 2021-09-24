<?php include 'includes/header.php'; ?>

<!-- Navigation -->
<?php include 'includes/navigation.php'; ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">



            <!-- Get the post data -->
            <?php
            if (isset($_GET['author'])) {
                $author = $_GET['author'];
                $post_id = $_GET['p_id'];
                $post_user = $_GET['author'];
            }

            ?>
            <h1 class="page-header">
                Author Posts by <?php echo $author; ?>
            </h1>
            <?php

            if ($_SESSION['user_role'] == 'admin') {
                $query = "SELECT * FROM posts WHERE post_user = '{$post_user}' ORDER BY post_id DESC";
            } else {
                $query = "SELECT * FROM posts WHERE post_status = 'published' AND post_user = '{$post_user}' ORDER BY post_id DESC";
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
                    Post by <?php echo $post_user; ?>
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

    <?php include 'includes/footer.php'; ?>