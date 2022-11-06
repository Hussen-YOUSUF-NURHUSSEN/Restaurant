<?php 
    include("../partials/menu.php"); 
    include("../func/helpers.php");
?>
    <!-- ++ Main Content -->
    <div class="main-content">                 
        <div class="wrapper">
            <h1 class="header">Dashborad</h1>

            <?php
                sessionSet_unset("login");
            ?>      

            <!-- Summary -->

            <div class="dashborad">
                <div> 
                    <?php 
                        // Get the number of total categories

                        $sql = "SELECT * FROM tbl_category";

                        $res = mysqli_query($conn, $sql);

                        $count = mysqli_num_rows($res);
                    ?>
                    <h1><?php echo $count; ?></h1> Categories 
                </div>
                <div> 
                    <?php 
                        // Get the number of total food
                        
                        $sql2 = "SELECT * FROM tbl_food";

                        $res2 = mysqli_query($conn, $sql2);

                        $count2 = mysqli_num_rows($res2);
                    ?>
                    <h1><?php echo $count2; ?></h1> Foods 
                </div>
                <div> 
                    <?php 
                        // Get the number of total order

                        $sql3 = "SELECT * FROM tbl_order";

                        $res3 = mysqli_query($conn, $sql3);

                        $count3 = mysqli_num_rows($res3);
                    ?>
                    <h1><?php echo $count3; ?></h1> Total Orders 
                </div>
                <div> 
                    <?php 
                        // Get the number of total revenue

                        $sql4 = "SELECT SUM(total) AS total FROM tbl_order WHERE status='Delivered'";

                        $res4 = mysqli_query($conn, $sql4);

                        $row = mysqli_fetch_assoc($res4);

                        $total_revenue = $row["total"];
                    ?>
                    <h1>$<?php echo $total_revenue; ?></h1>  Revenue Generated 
                </div>
            </div>
        </div>     
    </div>
<?php include("../partials/footer.php"); ?>