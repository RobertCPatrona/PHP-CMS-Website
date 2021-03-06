<div class="col-md-4">

    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="search.php" method="post">

            <div class="input-group">
                <input name='search' type="text" class="form-control">
                <span class="input-group-btn">
                    <button name='submit' class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>

        </form>
    </div>

    <!-- Login -->
    <div class="well">
        <?php if (isset($_SESSION['user_role'])) : ?>
            <h4>Logged in as <?php echo $_SESSION['username']; ?> (<?php echo ucfirst($_SESSION['user_role']); ?>)</h4>

            <a href="includes/logout.php" class="btn btn-primary">Logout</a>

        <?php else : ?>
            <h4>Login</h4>
            <form action="" method="post">
                <div class="form-group">
                    <input name='username' type="text" class="form-control" placeholder="Enter Username">
                </div>

                <div class="input-group">
                    <input name='password' type="password" class="form-control" placeholder="Enter Password">
                    <span class='input-group-btn'>
                        <button class='btn btn-primary' type='submit' , name='login'>Submit</button>
                    </span>
                </div>
            </form>

        <?php endif; ?>
    </div>

    <?php include 'login.php'; ?>


    <!-- Query for categories -->
    <?php
    $query = "SELECT * FROM categories";
    $result = mysqli_query($connection, ($query));
    ?>

    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">

                    <!-- Get categories column -->
                    <?php
                    echo "<li><a href='index.php'>All Categories</a></li>";

                    while ($row = mysqli_fetch_assoc($result)) {
                        $cat_id = $row['cat_id'];
                        $cat_title = $row['cat_title'];

                        echo "<li><a href='category.php?cat={$cat_id}'>{$cat_title}</a></li>";
                    }
                    ?>

                </ul>
            </div>
        </div>
    </div>

</div>