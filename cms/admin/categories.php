<?php include 'includes/admin_header.php'; ?>

<?php include 'includes/delete_modal.php'; ?>

<div id="wrapper">

    <!-- Navigation -->
    <?php include 'includes/admin_navigation.php'; ?>

    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">

                    <h1 class="page-header">
                        Categories
                    </h1>

                    <?php if (isAdmin()) : ?>

                        <div class="col-xs-6">
                            <!-- Add Category -->
                            <?php
                            addCategory();
                            ?>

                            <!-- Add category form -->
                            <form action="" method='post'>
                                <div class="form-group">
                                    <label for="cat_title">Add Category</label>
                                    <input class='form-control' type="text" name='cat_title'>
                                </div>
                                <div class="form-group">
                                    <input class='btn btn-primary' type="submit" name='submit' value='Add Category'>
                                </div>
                            </form>

                            <!-- Edit category query and form -->
                            <?php
                            if (isset($_GET['edit'])) {
                                $cat_id = $_GET['edit'];
                                include "includes/update_categories.php";
                            }
                            ?>
                        </div>

                    <?php endif; ?>


                    <div class="col-xs-6">
                        <table class='table table-bordered table-hover'>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category Title</th>

                                    <?php if (isAdmin()) : ?>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    <?php endif; ?>

                                </tr>
                            </thead>
                            <tbody>

                                <!-- Get categories query plus show table -->
                                <?php
                                getAllCategories();
                                ?>

                                <!-- Delete category query -->
                                <?php
                                deleteCategory();
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.delete_cats').on('click', function() {
            var id = $(this).attr('rel');

            var url = "categories.php?delete=" + id;

            $(".modal_delete").attr("href", url);

            $('#myModal').modal('show');
        })
    })
</script>

<?php include 'includes/admin_footer.php'; ?>