<?php 
    include("../partials/menu.php"); 
    include("../func/helpers.php");
?>

<div class="main-content" style="width: fit-content;">
    <div class="wrapper" style="width: 100%;">
        <h1 class="header">Manage Order</h1>

        <?php 
            sessionSet_unset("update-order");
        ?>
            <table style="font-size: 13px;">
                <tr>
                    <th>S.N</th>
                    <th>Food</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Customer Name </th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>

                <?php 
                    // Get all orders from database

                    $sql = "SELECT * FROM tbl_order ORDER BY id DESC";  // last order first
                    
                    $res = mysqli_query($conn, $sql);

                    $count = mysqli_num_rows($res);

                    $serial_num = 1; 
                    
                    if ($count > 0) {
                        
                        while ($row = mysqli_fetch_assoc($res)) {

                            $id               = $row["id"];
                            $food             = $row["food"];
                            $price            = $row["price"];
                            $qty              = $row["qty"];
                            $total            = $row["total"];
                            $order_date       = $row["order_date"];
                            $status           = $row["status"];
                            $customer_name    = $row["customer_name"];
                            $customer_contact = $row["customer_contact"];
                            $customer_email   = $row["customer_email"];
                            $customer_address = $row["customer_address"];
                        ?>
                            <tr>
                                <td><?php echo $serial_num++; ?></td>
                                <td><?php echo $food; ?></td>
                                <td>$<?php echo $price; ?></td>
                                <td><?php echo $qty; ?></td>
                                <td>$<?php echo $total; ?></td>
                                <td><?php echo $order_date ;?></td>

                                <!-- Status field -->
                                <?php 
                                    if ($status == "Ordered") {
                                        echo "<td style='font-weight: bold;'>$status</td>";
                                    }
                                    elseif ($status == "On Delivery") {
                                        echo "<td style='color:orange; font-weight: bold;'>$status</td>";
                                    }
                                    elseif ($status == "Delivered") {
                                        echo "<td style='color:green; font-weight: bold;'>$status</td>";
                                    }
                                    elseif ($status == "Cancelled") {
                                        echo "<td style='color:red; font-weight: bold;'>$status</td>";
                                    }
                                ?>

                                <td><?php echo $customer_name ?></td>
                                <td><?php echo $customer_contact ?></td>
                                <td><?php echo $customer_email ?></td>
                                <td><?php echo $customer_address ?></td>
                                <td>
                                    <a href="<?php echo SITEURL; ?>admin/update/update-order.php?id=<?php echo $id ?>" 
                                            class="button update-button" style="width: 55px;">Update
                                    </a>
                                </td>
                            </tr>
                        <?php
                        }
                    }   
                    else{
                        // No order available
                        echo "<tr>
                                <td colspan='6'><div class='error'>No Order!</div></td>
                            </tr>";
                    }
                ?>
            </table>
    </div> 
</div>
<?php include("../partials/footer.php"); ?>