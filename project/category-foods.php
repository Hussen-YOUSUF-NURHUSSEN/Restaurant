<?php include("partials-front/menu.php") ?>

<?php 
    // Check wheter id is passed or not
    if (isset($_GET["category_id"])) {

        $category_id = $_GET["category_id"];

        // Get category title
        $sql = "SELECT title FROM tbl_category WHERE id=$category_id";

        $res = mysqli_query($conn, $sql);

        // Get the value from database
        $row = mysqli_fetch_assoc($res);

        $category_title = $row["title"];
    }
    else {
        // Category id not passed ---> redirect to home page
        header("location:" . SITEURL);
    }

?>
<!-- --- Food Search -->
<section class="food-search back-img-shadow"">
    <div>      
        <h2>Foods on <a href="#"><?php echo $category_title; ?></a></h2>
    </div>
</section>
<!-- --- Food Search->



<!-- --- Food menu -->
<section class="food-menu">
    <div class="container">
        <h2 class="main-head">Food Menu</h2>
        <div class="parent">

            <?php 
                // Get food based on selected category

                $sql2 = "SELECT * FROM tbl_food WHERE category_id=$category_id";

                $res2 = mysqli_query($conn, $sql2);

                $count      = mysqli_num_rows($res2);

                if ($count > 0) {
                    
                    while ($row2 = mysqli_fetch_assoc($res2)) {
                            
                        $id          = $row2["id"];
                        $title       = $row2["title"];
                        $image_name  = $row2["image_name"];
                        $description = $row2["description"];
                        $price       = $row2["price"];
                        ?>

                        <div class="food-menu-box">
                                <div class="food-menu-img">
                                <?php 
                                        // Check wheter image is available or not
                                        if ($image_name == "") {
                                            ?>
                                            
                                            <img src="<?php echo SITEURL; ?>images/no_image.jpg" alt="Pizza" class="category_img_space">
                                            <?php                                        }
                                        else {
                                            ?>
                                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Pizza" class="category_img_space">
                                            <?php
                                        }
                                    ?>
                                </div>

                                <div class="food-menu-desc">
                                    <h4><?php echo $title; ?></h4>
                                    <p><?php echo $price; ?></p>
                                    <p><?php echo $description; ?></p>
                                    <br>
                                    <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="main-button">Order Now</a>
                                </div>
                            </div>
                        <?php
                    }

                }
                else {
                    // Food not available
                    echo "<h2 class='red_notice'> Food Not Available </h2>";
                }
            ?>
        </div>
    </div>
</section>
    <!-- --- END Food menu -->

<?php include("partials-front/footer.php") ?>