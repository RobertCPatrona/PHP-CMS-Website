<?php include 'includes/admin_header.php'; ?>

<?php $my_id = $_SESSION['id']; ?>

<div id="wrapper">

    <!-- Navigation -->
    <?php include 'includes/admin_navigation.php'; ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Dashboard - <?php echo $_SESSION['username']; ?>
                        <small> <?php echo ucfirst($_SESSION['user_role']); ?></small>
                    </h1>
                </div>
            </div>

            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-file-text fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">

                                    <?php
                                    if (isAdmin()) {
                                        $post_count = countQueryRows("SELECT * FROM posts");
                                    } else {
                                        $post_count = countQueryRows("SELECT * FROM posts WHERE post_user_id = {$my_id}");
                                    }
                                    ?>

                                    <div class='huge'><?php echo $post_count; ?></div>
                                    <div>Posts</div>
                                </div>
                            </div>
                        </div>
                        <a href="posts.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">

                                    <?php
                                    if (isAdmin()) {
                                        $comment_count = countQueryRows("SELECT * FROM comments");
                                    } else {
                                        $comment_count = countQueryRows("SELECT * FROM comments WHERE comment_author_id = {$my_id}");
                                    }
                                    ?>

                                    <div class='huge'><?php echo $comment_count; ?></div>
                                    <div>Comments</div>
                                </div>
                            </div>
                        </div>
                        <a href="comments.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <?php if (isAdmin()) : ?>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">

                                        <?php
                                        $user_count = countQueryRows("SELECT * FROM users");
                                        ?>

                                        <div class='huge'><?php echo $user_count; ?></div>
                                        <div> Users</div>
                                    </div>
                                </div>
                            </div>
                            <a href="users.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-list fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">

                                    <?php
                                    $cat_count = countQueryRows("SELECT * FROM categories");
                                    ?>

                                    <div class='huge'><?php echo $cat_count; ?></div>
                                    <div>Categories</div>
                                </div>
                            </div>
                        </div>
                        <a href="categories.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->

            <!-- Charts -->

            <?php
            if (isAdmin()) {
                $published_posts = countQueryRows("SELECT * FROM posts WHERE post_status = 'published'");
                $draft_posts = countQueryRows("SELECT * FROM posts WHERE post_status = 'draft'");
                $approved_comments = countQueryRows("SELECT * FROM comments WHERE comment_status = 'approved'");
                $unapproved_comments = countQueryRows("SELECT * FROM comments WHERE comment_status = 'unapproved'");
                $user_admins = countQueryRows("SELECT * FROM users WHERE user_role = 'admin'");
                $user_subs = countQueryRows("SELECT * FROM users WHERE user_role = 'subscriber'");
            } else {
                $published_posts = countQueryRows("SELECT * FROM posts WHERE post_status = 'published' AND post_user_id = {$my_id}");
                $draft_posts = countQueryRows("SELECT * FROM posts WHERE post_status = 'draft' AND post_user_id = {$my_id}");
                $approved_comments = countQueryRows("SELECT * FROM comments WHERE comment_status = 'approved' AND comment_author_id = {$my_id}");
                $unapproved_comments = countQueryRows("SELECT * FROM comments WHERE comment_status = 'unapproved' AND comment_author_id = {$my_id}");
            }
            ?>

            <div class="row">
                <script type="text/javascript">
                    google.charts.load('current', {
                        'packages': ['bar']
                    });
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                            ['Data', 'Count'],

                            <?php
                            if (isAdmin()) {
                                $elements = [
                                    'Total Posts', 'Published Posts', 'Draft Posts', 'Total Comments', 'Approved Comments',
                                    'Unapproved Comments', 'Total Users', 'Admins', 'Subscribers', 'Categories'
                                ];
                            } else {
                                $elements = [
                                    'Total Posts', 'Published Posts', 'Draft Posts', 'Total Comments', 'Approved Comments',
                                    'Unapproved Comments', 'Categories'
                                ];
                            }

                            if (isAdmin()) {
                                $counts = [
                                    $post_count, $published_posts, $draft_posts, $comment_count, $approved_comments,
                                    $unapproved_comments, $user_count, $user_admins, $user_subs, $cat_count
                                ];
                            } else {
                                $counts = [
                                    $post_count, $published_posts, $draft_posts, $comment_count, $approved_comments,
                                    $unapproved_comments, $cat_count
                                ];
                            }


                            for ($i = 0; $i < count($elements); $i++) {
                                echo "['{$elements[$i]}', {$counts[$i]}],";
                            }
                            ?>
                        ]);

                        var options = {
                            chart: {
                                title: '',
                                subtitle: '',
                            }
                        };

                        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                        chart.draw(data, google.charts.Bar.convertOptions(options));
                    }
                </script>

                <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<?php include 'includes/admin_footer.php'; ?>