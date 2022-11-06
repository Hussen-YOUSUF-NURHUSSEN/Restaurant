<?php 
    include("../partials/menu.php"); 
    include("../func/helpers.php");
?>

<div class="main-content">
    <div class="wrapper">
        <h1 class="header">Update Admin</h1>

        <?php 
            sessionSet_unset("name-invalid");
            sessionSet_unset("name-short");
            sessionSet_unset("name-exist");
        ?>

        <?php 
            // --- Check by ID whether there is admin OR redirect back to manage-admin

            // Get the ID of selected admin
            $id = mysqli_real_escape_string($conn, $_GET["id"]); 

            // Query
            $sql = "SELECT * FROM tbl_admin WHERE id=$id";

            $res = mysqli_query($conn, $sql);

            if ($res == TRUE) {
                
                // Check whether data is available
                $count = mysqli_num_rows($res);

                if ($count == 1) {

                    // Get the details
                    $row = mysqli_fetch_assoc($res);

                    $full_name = $row["full_name"];
                    $username  = $row["username"];
                }
                else {
                    // Redirect to manage-admin
                    header("location:" . SITEURL . "admin/manage/manage-admin.php");
                }
            }
        ?>

        <form action="" method="POST">
            <div>
                <label class="main-label" for="full_name">Full Name: </label>
                <input type="text" name="full_name" id="full_name" value="<?php echo $full_name; ?>">
            </div>
            <div>
                <label class="main-label" for="username">Username: </label>
                <input type="text" name="username" id="username" value="<?php echo $username; ?>">
            </div>
            <div>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="submit" name="submit" value="Update Admin" class="button submit" >
            </div>
        </form>
    </div>
</div>

<?php 

    // --- Update new informations 

    if (isset($_POST["submit"])) {

        $id        = mysqli_real_escape_string($conn, $_POST["id"]);
        $full_name = mysqli_real_escape_string($conn, $_POST["full_name"]);
        $username  = mysqli_real_escape_string($conn, $_POST["username"]);


        // #### Validate input's ----------------------------------

        // Fucntion to check text length, and if it only contains letters, or die
        validateAdmin(
            $_POST["full_name"], 
            $_POST["username"], 
            "update/update-admin.php?id=$id"
        );

        
        // Check whether names already exist or not in database, but not for current id person
        $sql_fullname   = "SELECT * FROM tbl_admin WHERE id != $id and full_name = '$full_name' ";
        $sql_username   = "SELECT * FROM tbl_admin WHERE id != $id and username = '$username'";

        $exc_1            = mysqli_query($conn, $sql_fullname);
        $exc_2            = mysqli_query($conn, $sql_username);

        $count1         = mysqli_num_rows($exc_1);
        $count2         = mysqli_num_rows($exc_2);
    
        // Error if (name exist)
        if ($count1 != 0 || $count2 != 0) {

            session_redirect(
                "error",                           // status
                "name-exist",                      // Session name
                "update/update-admin.php?id=$id",  // Redirect to
                "",                                // Success message
                "Invalid, name already exist"      // Failure message  
            );  
            die();
        }

        // -- ----------------------------------------------------


        // Sql 
        $sql3 = "UPDATE 
                    tbl_admin 
                SET 
                    full_name = '$full_name',
                    username  = '$username'
                WHERE 
                    id = $id
        ";

        query_session_redirect(
            $conn,
            $sql3,                           // sql
            "update-admin",                 // Session name
            "manage/manage-admin.php",      // Redirect to
            "Admin Updated Successfully",   // Success message
            "Failed To Update Admin"        // Failure message 
        );     
    }
?>
<?php include("../partials/footer.php"); ?>