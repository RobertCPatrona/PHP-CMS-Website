<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">CMS Control Panel (<?php echo ucfirst($_SESSION['user_role']); ?>)</a>
    </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">

        <!-- Users online -->
        <?php if (isAdmin()) : ?>
            <li><a href="">Users Online: <?php echo usersOnline(); ?></a></li>
        <?php endif; ?>

        <!-- Add Home button -->
        <li><a href="../index.php">RETURN TO HOME</a></li>

        <li class="dropdown">
            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-user"></i>

                <?php
                if (isset($_SESSION['username'])) {
                    echo $_SESSION['username'];
                }
                ?>

                <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                </li>
            </ul>
        </li>
    </ul>

    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->

    <?php
    $dashboard_class = '';
    $posts_class = '';
    $categories_class = '';
    $comments_class = '';
    $users_class = '';
    $profile_class = '';

    $uri = $_SERVER['REQUEST_URI'];

    if (str_contains($uri, 'index.php')) {
        $dashboard_class = 'active';
    } else if (str_contains($uri, 'posts.php')) {
        $posts_class = 'active';
    } else if (str_contains($uri, 'categories.php')) {
        $categories_class = 'active';
    } else if (str_contains($uri, 'comments.php')) {
        $comments_class = 'active';
    } else if (str_contains($uri, 'users.php')) {
        $users_class = 'active';
    } else if (str_contains($uri, 'profile.php')) {
        $profile_class = 'active';
    }
    ?>

    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">

            <li class="<?php echo $dashboard_class; ?>">
                <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
            </li>

            <li class="<?php echo $posts_class; ?>">
                <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown"><i class="fa fa-fw fa-arrows-v"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="posts_dropdown" class="collapse">
                    <li>
                        <a href="posts.php">View Posts</a>
                    </li>
                    <li>
                        <a href="posts.php?source=add_post">Add Post</a>
                    </li>
                </ul>
            </li>

            <li class="<?php echo $categories_class; ?>">
                <a href="categories.php"><i class="fa fa-fw fa-wrench"></i> Categories</a>
            </li>

            <li class="<?php echo $comments_class; ?>">
                <a href="comments.php"><i class="fa fa-fw fa-file"></i> Comments</a>
            </li>

            <?php if (isAdmin()) : ?>
            <li class="<?php echo $users_class; ?>">
                <a href="javascript:;" data-toggle="collapse" data-target="#users_dropdown"><i class="fa fa-fw fa-arrows-v"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="users_dropdown" class="collapse">
                    <li>
                        <a href="users.php">View Users</a>
                    </li>
                    <li>
                        <a href="users.php?source=add_user">Add User</a>
                    </li>
                </ul>
            </li>
            <?php endif; ?>

            <li class="<?php echo $profile_class; ?>">
                <a href="profile.php"><i class="fa fa-fw fa-wrench"></i> Profile</a>
            </li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>