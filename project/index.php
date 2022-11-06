<?php include("partials-front/menu.php") ?>

<!-- --- Food Search -->
<section class="food-search back-img-shadow">
    <div>      
        <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
            <input type="search" name="search" placeholder="Search for Food.." required autocomplete="off">
            <input type="submit" name="submit" value="Search" class="main-button">
        </form>
    </div>
</section>
<!-- Food Search -->

<?php
    if (isset($_SESSION["order"])) {

        echo $_SESSION["order"];
        unset($_SESSION["order"]) ;
    }
?> 

<!-- ++ Categories -->
<section class="categories">
    <div class="container">
        <h2 class="main-head">Explore Categories</h2>

        <?php 
            // Disolay categories from database
            $sql = "SELECT * FROM tbl_category WHERE featured='yes' and active='yes'";
            $res = mysqli_query($conn, $sql);

            $count = mysqli_num_rows($res);

            if ($count > 0) {

                while ($row = mysqli_fetch_assoc($res)) {

                    $id         = $row["id"];
                    $title      = $row["title"];
                    $image_name = $row["image_name"];
                    ?>

                    <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                        <div>
                            <?php 
                                // Check wheter image is available or not
                                if ($image_name == "") {
                                    ?>
                                    
                                    <img src="<?php echo SITEURL; ?>images/no_image.jpg" alt="Pizza" class="category_img_space">
                                    <?php
                                }
                                else {
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Pizza" class="category_img_space">
                                    <?php
                                }
                            ?>
                            <h3><?php echo $title; ?></h3>
                        </div>
                    </a>

                    <?php
                }
            }
            else {
                // Category not available
                echo "<div class='error'> Category not added </div>";
            }
        
        ?>
    </div>
</section>
<!-- ++ END Categories -->


<!-- --- Food menu -->
<section class="food-menu">
    <div class="container">
        <h2 class="main-head">Food Menu</h2>
        <div class="parent">
            
        <?php 
            // Disolay foods from database that are active & featured
            $sql2 = "SELECT * FROM tbl_food WHERE featured='yes' and active='yes' LIMIT 6";
            $res2 = mysqli_query($conn, $sql2);

            $count  = mysqli_num_rows($res2);

            if ($count > 0) {

                while ($row = mysqli_fetch_assoc($res2)) {

                    $id          = $row["id"];
                    $title       = $row["title"];
                    $image_name  = $row["image_name"];
                    $description = $row["description"];
                    $price       = $row["price"];
                    ?>

                    <div class="food-menu-box">
                        <div class="food-menu-img">
                        <?php 
                                // Check wheter image is available or not
                                if ($image_name == "") {
                                    ?>
                                    
                                    <img src="<?php echo SITEURL; ?>images/no_image.jpg" alt="Pizza" class="category_img_space">
                                    <?php
                                }   
                                else {
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Pizza" class="category_img_space">
                                    <?php
                                }
                            ?>
                        </div>

                        <div class="food-menu-desc">
                            <h4><?php echo $title; ?></h4>
                            <p>$<?php echo $price; ?></p>
                            <p><?php echo $description; ?></p>
                            <br>
                            <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="main-button">Order Now</a>
                        </div>
                    </div>
                    <?php
                }
            }
            else {
                // Category not available
                echo "<div class='error'> Foods Not Available </div>";
            }
        ?>
        </div>
    </div>

    <p>
        <a href="<?php echo SITEURL; ?>foods.php">See All Foods</a>
    </p>
</section>
    <!-- --- END Food menu -->
    
<?php include("partials-front/footer.php") ?>
