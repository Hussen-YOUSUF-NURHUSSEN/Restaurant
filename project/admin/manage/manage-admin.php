<?php 
    include("../partials/menu.php"); 
    include("../func/helpers.php");
?>
    <!-- ++ Main Content -->
    <div class="main-content">
        <div class="wrapper">
            <h1 class="header">Manage Admin</h1>
            
            <?php 
                // Will came from add or delete or update operations

                sessionSet_unset("add-admin");
                sessionSet_unset("delete-admin");
                sessionSet_unset("update-admin");
            ?>

            <a href="<?php echo SITEURL; ?>admin/add/add-admin.php" class="button">Add Admin</a>
            <table>
                <tr>
                    <th>S.N</th>
                    <th>Fullname</th>
                    <th>Username</th>
                    <th>Action</th>
                </tr>
                
                <?php 
                    // Display all the admins

                    $sql = "SELECT * FROM tbl_admin";

                    $res = mysqli_query($conn, $sql);

                    if ($res == TRUE) {
                        
                        // ++    mysqli_num_rows()
                        $count = mysqli_num_rows($res);  
                        
                        $serial_num = 1;

                        if ($count > 0) {
                            // ++          mysqli_fetch_assoc()
                            while ($rows = mysqli_fetch_assoc($res)) {

                                $id        = $rows["id"];
                                $full_name = $rows["full_name"];
                                $username  = $rows["username"];
                ?>
                                <tr>
                                    <td><?php echo $serial_num++ ?></td>
                                    <td><?php echo $full_name ?></td>
                                    <td><?php echo $username ?></td>
                                    <td>
                                        <a href="<?php echo SITEURL; ?>/admin/update/update-password.php?id=<?php echo $id; ?>" 
                                                    class="button chang_pass-button">Change Password
                                        </a>

                                        <a href="<?php echo SITEURL; ?>/admin/update/update-admin.php?id=<?php echo $id; ?>" 
                                                    class="button update-button">Update
                                        </a>

                                        <a href="<?php echo SITEURL; ?>/admin/delete/delete-admin.php?id=<?php echo $id; ?>" 
                                                    class="button delete-button">Delete
                                        </a>
                                    </td>
                                </tr>
                    <?php
                            }
                        }
                    }
                    ?>
            </table>
        </div> 
    </div>
<?php include("../partials/footer.php"); ?>