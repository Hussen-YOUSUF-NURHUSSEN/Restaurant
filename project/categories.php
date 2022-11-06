<?php include("partials-front/menu.php") ?>

<!-- ++ Categories -->
<section class="categories categories-page">
    <div class="container">
        <h2 class="main-head">Explore Categories</h2>
        <?php 
            // Disolay all categories that are active
            $sql = "SELECT * FROM tbl_category WHERE  active='yes'";
            $res = mysqli_query($conn, $sql);

            $count      = mysqli_num_rows($res);
            $serial_num = 1;

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

<?php include("partials-front/footer.php") ?>


