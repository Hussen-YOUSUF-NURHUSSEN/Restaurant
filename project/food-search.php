<?php include("partials-front/menu.php") ?>

<!-- --- Food Search -->
<section class="food-search back-img-shadow"">
    <div>    
        <?php   
            // Get the search keyword
            $search = mysqli_real_escape_string($conn, $_POST["search"]);
        ?>  
        <h2>Foods on Your Search <a href="#"><?php echo $search; ?></a></h2>
    </div>
</section>
<!-- --- Food Search->


<!-- --- Food menu -->
<section class="food-menu">
    <div class="container">
        <h2 class="main-head">Food Menu</h2>
        <div class="parent">

        <?php
            // Get the search keyword
            $search = mysqli_real_escape_string($conn, $_POST["search"]);

            // Get food based on search from database
            $sql = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%'";
            
            $res = mysqli_query($conn, $sql);

            $count = mysqli_num_rows($res);

            if ($count > 0) {

                while ($row = mysqli_fetch_assoc($res)) {

                    $id          = $row["id"];
                    $title       = $row["title"];
                    $image_name  = $row["image_name"];
                    $price       = $row["price"];
                    $description = $row["description"];
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
                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>"  class="category_img_space">
                                    <?php
                                }
                            ?>
                        </div>

                        <div class="food-menu-desc">
                            <h4><?php echo $title; ?></h4>
                            <p><?php echo $price; ?></p>
                            <p><?php echo $description; ?></p>
                            <br>
                            <a href="order.html">Order Now</a>
                        </div>
                    </div>
                    <?php
                }
            }
            else {
                // Food is not available
                echo "<div class='notice red_notice'> Food Not Available </div>";
            }

        ?>
        </div>
    </div>
</section>
    <!-- --- END Food menu -->

<?php include("partials-front/footer.php") ?>
