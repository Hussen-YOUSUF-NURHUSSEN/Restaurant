<?php 
    include("../partials/menu.php"); 
    include("../func/helpers.php");
?>
<div class="main-content">
    <div class="wrapper">
        <h1 class="header">Manage Category</h1>

        <?php 
            // Will came from add or delete or update operations

            sessionSet_unset("add-category");
            sessionSet_unset("remove-image"); 
            sessionSet_unset("delete-category");
            sessionSet_unset("no-category-found");
            sessionSet_unset("update-category");
            sessionSet_unset("upload-category");
        ?>

        <a href="<?php echo SITEURL."admin/add/add-category.php"; ?>" class="button">Add Category</a>
        <table>
            <tr>
                <th>S.N</th>
                <th>Title</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Action</th>
            </tr>

            <?php 
                // Display all the categores

                $sql = "SELECT * FROM tbl_category";
                $res = mysqli_query($conn, $sql);

                $count      = mysqli_num_rows($res);
                $serial_num = 1;

                if ($count > 0) {

                    while ($row = mysqli_fetch_assoc($res)) {

                        $id         = $row["id"];
                        $title      = $row["title"];
                        $image_name = $row["image_name"];
                        $featured   = $row["featured"];
                        $active     = $row["active"];

            ?>
                        <tr>
                            <td><?php echo $serial_num++ ;?></td>
                            <td><?php echo $title ;?></td>

                            <td>
                                <?php 
                                    if ($image_name != "") {
                                ?>
                                        <img src="<?php echo SITEURL;?>images/category/<?php echo $image_name;?>" alt="food" class="manage_img">
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
                                <a href="<?php echo SITEURL; ?>/admin/update/update-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" 
                                            class="button update-button">Update Category
                                </a>

                                <a href="<?php echo SITEURL; ?>/admin/delete/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" 
                                            class="button delete-button">Delete Category
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                }
                else {
                    ?>
                    <tr>
                        <td colspan="6"><div class="error">No Category Added!</div></td>
                    </tr>
                    <?php
                }
            ?>  
        </table>
    </div>
</div>
<?php include("../partials/footer.php"); ?>