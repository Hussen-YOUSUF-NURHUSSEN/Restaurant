<?php 
    include("../partials/menu.php"); 
    include("../func/helpers.php");
?>
<div class="main-content">
    <div class="wrapper">
        <h1 class="header">Manage Food</h1>

        <a href="<?php echo SITEURL; ?>admin/add/add-food.php" class="button">Add Food</a>

        <?php 
            // Will came from add or delete or update operations

            sessionSet_unset("add-food");
            sessionSet_unset("unauthorised-access");
            sessionSet_unset("remove-image");
            sessionSet_unset("delete-food");
            sessionSet_unset("no-food-found");
            sessionSet_unset("failed-remove-image");
            sessionSet_unset("update-food");
        ?>
        <table>
            <tr>
                <th>S.N</th>
                <th>Title</th>
                <th>Price</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php 
                // --- Display foods from database

                $sql = "SELECT * FROM tbl_food";
                $res = mysqli_query($conn, $sql);

                $count      = mysqli_num_rows($res);
                $serial_num = 1;

                // There is foods  --------------------------------
                if ($count > 0) {

                    while ($row = mysqli_fetch_assoc($res)) {

                        $id         = $row["id"];
                        $title      = $row["title"]; 
                        $price      = $row["price"]; 
                        $image_name = $row["image_name"];
                        $featured   = $row["featured"];
                        $active     = $row["active"];

            ?>
                        <!-- Fill each table row  -->
                        <tr>
                            <td><?php echo $serial_num++ ;?></td>
                            <td><?php echo $title ;?></td>
                            <td>$<?php echo $price ?></td>

                            <td>
                                <?php 
                                    if ($image_name != "") {

                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="food" class="manage_img">
                                        <?php
                                    }
                                    else {
                                        echo "<div class='error'>Image not added</div>";
                                    }
                                ?>
                            </td>

                            <td><?php echo $featured; ?></td>
                            <td><?php echo $active; ?></td>

                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update/update-food.php?id=<?php echo $id; ?>" 
                                        class="button update-button">Update Food
                                </a>

                                <a href="<?php echo SITEURL; ?>admin/delete/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" 
                                        class="button delete-button">Delete Food
                                </a>
                            </td>
                        </tr>
            <?php
                    }
                }
                // There is No foods  --------------------------------
                else {
                    echo "<tr> 
                            <td colspan='7'>
                                <div class='error'>Food not added yet !</div>
                            </td>
                        </tr>";
                }
            ?>
        </table>
    </div> 
</div>
<?php include("../partials/footer.php"); ?>