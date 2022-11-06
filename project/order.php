<?php include("partials-front/menu.php") ?>

<?php 
    // Check whether food_id is set or nor
    if (isset($_GET["food_id"])) {

        $food_id = $_GET["food_id"];

        // Get the details of the selected food
        $sql = "SELECT * FROM tbl_food WHERE id=$food_id";

        $res = mysqli_query($conn, $sql);

        $count = mysqli_num_rows($res);

        if ($count == 1) {
            
            $row = mysqli_fetch_assoc($res);

            $title       = $row["title"];
            $image_name  = $row["image_name"];
            $price       = $row["price"];
        
        }
        else {
            // Food not available ====> Redirect to home page
            header("location:" . SITEURL);
        }
    }
    else {
        // Redirect to home page
        header("location:" . SITEURL);
    }

?>
<!-- !! Order -->
<section class="order-section back-img-shadow" id="order_back_photo">
    <div>
        <h2 class="flash flash-error">Fill this form to confirm your order.</h2>

        <form action="" method="POST">

            <fieldset>
                <legend>Selected Food</legend>

                <div class="food-menu-box common-back">

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
                        <h4><?php echo $title ?></h4>
                        <input type="hidden" name="food" value="<?php echo $title; ?>">

                        <p>$<?php echo $price ?></p>
                        <input type="hidden" name="price" value="<?php echo $price; ?>">

                        <p>Quantity</p>
                        <input type="number" name="qty" value="1" required>
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Delivery Details</legend>

                <div class="common-back">
                    <p>Full Name</p>
                    <input type="text" name="full_name" placeholder="E.g. Hussen Yousuf" required>

                    <p>Phone Number</p>
                    <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" required>

                    <p>Email</p>
                    <input type="email" name="email" placeholder="E.g. hussen@outlook.com" required>

                    <p>Address</p>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="main-button">
                </div>
            </fieldset>
        </form>

        <?php 
            // Check whether submit button is clicked
            if (isset($_POST["submit"])) {

                // Get all the details
                $food  = $_POST["food"];
                $price = $_POST["price"];
                $qty   = $_POST["qty"];

                $total      = $price * $qty;
                $order_date = date("Y-m-d h:i:s");

                $status = "Ordered"; // Ordered, Or Delivery, Delivered, Cancelled

                // Get customer details
                $customer_name    = $_POST["full_name"];
                $customer_contact = $_POST["contact"];
                $customer_email   = $_POST["email"];
                $customer_address = $_POST["address"];

                // Save the order in database
                $sql2 = "INSERT INTO tbl_order SET
                        food              = '$food',
                        price             =  $price,
                        qty               =  $qty,
                        total             =  $total,
                        order_date        = '$order_date',
                        status            = '$status',
                        customer_name     = '$customer_name',
                        customer_contact = '$customer_constact',
                        customer_email    = '$customer_email',
                        customer_address  = '$customer_address' 
                ";

                $res2 = mysqli_query($conn, $sql2);

                if ($res2 == true) {
                    
                    $_SESSION["order"] = "<div class='flash flash-success'>Food Ordered Sucessfully</div>";
                    header("location:" . SITEURL);
                }
                else {
                    // Failled to save order
                    $_SESSION["order"] = "<div class='flash flash-error'>Failled To Order </div>";
                    header("location:" . SITEURL);
                }
            }
        ?>
    </div>
</section>

<!-- !! END Order -->

<?php include("partials-front/footer.php") ?>