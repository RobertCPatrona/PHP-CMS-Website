

<form action="" method='post'>
    <div class="form-group">
        <label for="cat_title">Edit Category</label>

        <!-- Get the category to edit -->
        <?php
        getCategoryToEdit();
        ?>

        <!-- Edit category query -->
        <?php
        editCategory();
        ?>

    </div>
    <div class="form-group">
        <input class='btn btn-primary' type="submit" name='update_category' value='Update Category'>
    </div>
</form>