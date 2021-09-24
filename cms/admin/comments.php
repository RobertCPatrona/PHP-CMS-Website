<?php include 'includes/admin_header.php'; ?>

<div id="wrapper">

    <!-- Navigation -->
    <?php include 'includes/admin_navigation.php'; ?>

    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">

                    <h1 class="page-header">
                    <?php
                        if (isAdmin()) {
                            echo 'All Comments';
                        } else {
                            echo 'My Comments';
                        }
                        ?>
                    </h1>

                    <?php
                    if (isset($_GET['source'])) {
                        $source = $_GET['source'];
                    } else {
                        $source = '';
                    }

                    switch ($source) {
                        default:
                            include 'includes/view_all_comments.php';
                            break;
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>

</div>

<?php include 'includes/admin_footer.php'; ?>