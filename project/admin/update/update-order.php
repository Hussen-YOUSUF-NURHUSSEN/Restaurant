<?php 
    include("../partials/menu.php"); 
    include("../func/helpers.php");
?>
<div class="main-content">
    <div class="wrapper">
        <h1 class="header">Update Order</h1>

        <?php

            sessionSet_unset("customer-name-short");
            sessionSet_unset("qty-missing");

            // Check wheher id is set or not
            if (isset($_GET["id"])) {

                $id = mysqli_real_escape_string($conn, $_GET["id"]);

                $sql = "SELECT * FROM tbl_order WHERE id=$id";

                $res = mysqli_query($conn, $sql);

                $count = mysqli_num_rows($res);

                if ($count == 1) {
                    
                    $row = mysqli_fetch_assoc($res);

                    $food             = $row["food"];
                    $price            = $row["price"];
                    $qty              = $row["qty"];
                    $status           = $row["status"];
                    $customer_name    = $row["customer_name"];
                    $customer_contact = $row["customer_contact"];
                    $customer_email   = $row["customer_email"];
                    $customer_address = $row["customer_address"];
                }
                // Order not available ===> Redirect to manage order
                else {
                    header("location:" . SITEURL . "admin/manage/manage-order.php");
                }
            }
            // id is not set ===> redirect to manage order
            else {
                header("location:" . SITEURL . "admin/manage/manage-order.php");
            }
        ?>
        <form method="POST" action="" enctype="multipart/form-data">

            <div>
                <label class="main-label">Food Name: </label>
                <input type="text" value="<?php echo $food ?>" readonly class="readonly_input">
            </div>

            <div>
                <label class="main-label" >Price: </label>
                <input type="text" value="$<?php echo $price ?>" readonly class="readonly_input">
            </div>

            <div>
                <label class="main-label" for="qty">Qty: </label>
                <input type="text" name="qty" id="qty" value="<?php echo $qty ?>">
            </div>
            
            <div>
                <label class="main-label" for="status">Status: </label>
                <select name="status" id="status">
                    <option <?php if ($status == "Ordered") {echo "selected";} ?> value="Ordered">Ordered</option>
                    <option <?php if ($status == "On Delivery") {echo "selected";} ?> value="On Delivery">On Delivery</option>
                    <option <?php if ($status == "Delivered") {echo "selected";} ?> value="Delivered">Delivered</option>
                    <option <?php if ($status == "Cancelled") {echo "selected";} ?> value="Cancelled">Cancelled</option>
                </select>
            </div>

            <div>
                <label class="main-label" for="customer_name">Customer Name: </label>
                <input type="text" name="customer_name" id="customer_name" value="<?php echo $customer_name; ?>">
            </div>

            <div>
                <label class="main-label" for="customer_contact">Customer Contact: </label>
                <input type="text" name="customer_contact" id="customer_contact" value="<?php echo $customer_contact;?>">
            </div>

            <div>
                <label class="main-label" for="customer_email">Customer Email: </label>
                <input type="text" name="customer_email" id="customer_email" value="<?php echo $customer_email;?>">
            </div>

            <div>
                <label class="main-label center-label" for="customer_address">Customer Address: </label>
                <textarea name="customer_address" id="customer_address"><?php echo $customer_address; ?></textarea>
            </div>

            <div>
                <input type="hidden" name="id"     value="<?php echo $id ?>">
                <input type="hidden" name="price"  value="<?php echo $price ?>">
                <input type="submit" name="submit" value="Update Order" class="button submit" >
            </div>

        </form>

        <?php 
            // Check wheter submit is clicked or not
            if (isset($_POST["submit"])) {

                // Get all values from form
                $id               = mysqli_real_escape_string($conn, $_POST["id"]);
                
                $price            = mysqli_real_escape_string($conn, $_POST["price"]);
                $qty              = mysqli_real_escape_string($conn, $_POST["qty"]);

                $status           = mysqli_real_escape_string($conn, $_POST["status"]); 

                $customer_name    = mysqli_real_escape_string($conn, $_POST["customer_name"]); 
                $customer_contact = mysqli_real_escape_string($conn, $_POST["customer_contact"]); 
                $customer_email   = mysqli_real_escape_string($conn, $_POST["customer_email"]); 
                $customer_address = mysqli_real_escape_string($conn, $_POST["customer_address"]); 

                // Validate customer name and qty
                validateOrder($customer_name, $qty, $id);

                $total = $price * $qty;


                // Update database
                $sql2 = "UPDATE tbl_order SET
                            qty              = $qty,
                            total            = $total,
                            status           = '$status',
                            customer_name    = '$customer_name',
                            customer_contact = '$customer_contact',
                            customer_email   = '$customer_email',
                            customer_address = '$customer_address'
                            WHERE id=$id
                ";

                // Execute sql then redirect
                query_session_redirect(
                    $conn,
                    $sql2,                         // sql
                    "update-order",                // Session name
                    "manage/manage-order.php",     // Redirect to
                    "Order Updated Successfuly",   // Success message
                    "Failed To Update Order"       // Failure message
                ); 
            }
        ?>
    </div>
</div>
<?php include("../partials/footer.php"); ?>