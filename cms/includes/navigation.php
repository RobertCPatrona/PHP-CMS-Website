<?php include "db.php"; ?>
<?php session_start(); ?>

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">

                <?php
                $home_class = '';
                $reg_class = '';
                $contact_class = '';

                $uri = $_SERVER['REQUEST_URI'];

                if (str_contains($uri, 'registration.php')) {
                    $reg_class = 'active';
                } else if (str_contains($uri, 'contact.php')) {
                    $contact_class = 'active';
                } else {
                    $home_class = 'active';
                }
                ?>

                <li class="<?php echo $home_class; ?>">
                    <a href='index.php'>
                        Home
                    </a>
                </li>

                <li class="<?php echo $reg_class; ?>">
                    <a href='registration.php'>
                        Registration
                    </a>
                </li>

                <!-- <li class="<?php echo $contact_class; ?>">
                    <a href='contact.php'>
                        Contact
                    </a>
                </li> -->

                <li>
                    <a href='admin'>
                        Control Panel
                    </a>
                </li>

                <?php
                if (isset($_SESSION['user_role'])) {
                    if (isset($_GET['p_id'])) {
                        $post_id = $_GET['p_id'];
                        echo "<li><a href='admin/posts.php?source=edit_post&p_id={$post_id}'>Edit Post</a></li>";
                    }
                }
                ?>

            </ul>
        </div>
    </div>
</nav>