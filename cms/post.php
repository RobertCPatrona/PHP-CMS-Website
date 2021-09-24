<?php include 'includes/header.php'; ?>

<!-- Navigation -->
<?php include 'includes/navigation.php'; ?>


<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <!-- <h1 class="page-header">
                Post
            </h1> -->

            <!-- Get the post data -->
            <?php
            if (isset($_GET['p_id'])) {
                $post_id = $_GET['p_id'];

                // Update the views
                $query = "UPDATE posts SET post_views = post_views + 1 WHERE post_id = {$post_id}";
                $result = mysqli_query($connection, ($query));
                if (!$result) {
                    die('QUERY FAILED' . mysqli_error($connection));
                }

                // Get post data
                $query = "SELECT * FROM posts WHERE post_id = $post_id";
                $result = mysqli_query($connection, ($query));

                $row = mysqli_fetch_assoc($result);

                $post_title = $row['post_title'];
                $post_user = $row['post_user'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = str_replace('\\', '', $row['post_content']);
                $post_status = $row['post_status'];
                $post_likes = $row['post_likes'];

            ?>

                <h2>
                    <?php echo $post_title ?>
                    <?php
                    if ($post_status == 'draft') {
                        echo '(Draft)';
                    }
                    ?>
                </h2>

                <p class="lead">
                    by <?php echo $post_user; ?>
                </p>

                <p>
                    <span class="glyphicon glyphicon-time"></span> <?php echo date('j F Y', strtotime($post_date)); ?>
                </p>
                <hr>

                <img class="img-responsive center-block smallerImg" src="images/<?php echo $post_image; ?>" alt="">
                <hr>

                <h4><?php echo $post_content; ?></h4>

                <!-- <br> -->
            <?php
            } else {
                header('Location: index.php');
            }
            ?>


            <!-- Likes -->
            <div class="pull-right">
                <h4 style="display:inline;">Likes: </h4>
                <h4 style="display:inline;" id="likesCount"><?php echo $post_likes; ?></h4>
            </div>

            <br>

            <div class="pull-right">
                <?php if (isset($_SESSION['username'])) : ?>
                    <button id="like" onclick=<?php echo "liked({$post_id})" ?>>
                        <i class="fa fa-thumbs-up"></i>
                        <span class="icon">Like</span>
                    </button>
                <?php else : ?>
                    <h5>You need to be logged in to like</h5>
                <?php endif; ?>
            </div>

            <br>
            <br>
            <br>

            <!-- Handle comment form -->
            <?php
            if (isset($_POST['create_comment'])) {

                if (!isset($_SESSION['username'])) {
                    echo "<script>toastr.info('You must be logged in to comment')</script>";
                } else {
                    $post_id = $_GET['p_id'];

                    $comment_author = $_SESSION['username'];
                    $comment_email = $_SESSION['email'];
                    $comment_content = mysqli_real_escape_string($connection, $_POST['comment_content']);

                    if (!empty($comment_content)) {
                        $query = "INSERT INTO comments(comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
                        $query .= "VALUES({$post_id}, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'approved', now())";

                        $add_comment = mysqli_query($connection, $query);
                        if (!$add_comment) {
                            die('QUERY FAILED' . mysqli_error($connection));
                        }
                    } else {
                        echo "<script>alert('Fields cannot be empty')</script>";
                    }
                }
            }
            ?>

            <!-- Comments Form -->
            <div class="well">
                <h4>Leave a Comment:</h4>
                <form role="form" action='' method='post'>
                    <div class="form-group">
                        <textarea class="form-control" rows="3" name='comment_content'></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" name='create_comment'>Submit</button>
                </form>
            </div>

            <hr>

            <!-- Get the comments -->
            <?php
            $query = "SELECT * FROM comments WHERE comment_post_id = {$_GET['p_id']} AND comment_status = 'approved' ORDER BY comment_id DESC";

            $result = mysqli_query($connection, $query);
            if (!$result) {
                die('QUERY FAILED' . mysqli_error($connection));
            }

            while ($row = mysqli_fetch_assoc($result)) {
                $comment_author = $row['comment_author'];
                $comment_date = $row['comment_date'];
                $comment_content = $row['comment_content'];
            ?>
                <div class="media">
                    <a class="pull-left" href="javascript:void(0)">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author; ?>
                            <small> <?php echo date('j F Y', strtotime($comment_date)); ?></small>
                        </h4>
                        <h4>
                            <?php echo $comment_content; ?>
                        </h4>
                    </div>
                </div>
            <?php
            }
            ?>


        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include 'includes/sidebar.php'; ?>

    </div>

    <hr>

    <?php
    if (isset($_SESSION['username'])) {
        $my_id =  $_SESSION['id'];
        $query = "SELECT * FROM likes WHERE post_id = {$post_id} AND user_id = {$my_id}";

        $has_liked = countQueryRows($query) > 0;

        if ($has_liked) {
            echo '<script type="text/javascript">
                    var element = document.getElementById("like");
                    element.classList.toggle("liked");
                </script>';
        }
    }
    ?>

    <script>
        function liked(post_id) {
            window.location.href = "includes/likes.php?p_id=" + post_id;

            var likeBtn = document.getElementById("like");
            likeBtn.classList.toggle("liked");

            var likesCount = document.getElementById("likesCount");
            var number = likesCount.innerHTML;
            if (likeBtn.classList.contains("liked")) { // We liked
                number++;
            } else { // We disliked
                number--;
            }
            likesCount.innerHTML = number;
        }
    </script>

    <?php include 'includes/footer.php'; ?>