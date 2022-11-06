<?php   
    include("../partials/menu.php"); 
    include("../func/helpers.php");
?>

<div class="main-content">
    <div class="wrapper">
        <h1 class="header">Change Password</h1>
        <?php  
            if (isset($_GET["id"])) {
                $id = mysqli_real_escape_string($conn, $_GET["id"]);
            }
            // Depend on sql query, success or faillure
            sessionSet_unset("change-pwd");

            // Fuction to check for password length
            sessionSet_unset("pass-invalid");
            
            sessionSet_unset("wrong-pass");
            sessionSet_unset("pwd-not-match");
            
        ?>

        <form action="" method="POST">
            <div>
                <label class="main-label" for="curr">Current Password: </label>
                <input type="password" name="current_password" id="curr" placeholder="Old Password">
            </div>
            <div>
                <label class="main-label" for="new">New Password: </label>
                <input type="password" name="new_password" id="new" placeholder="New Password">
            </div>
            <div>
                <label class="main-label" for="confi">Confirm Password: </label>
                <input type="password" name="confirm_password" id="confi" placeholder="Confirm Password">
            </div>
            <div>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="submit" name="submit" value="Change Password" class="button submit" >
            </div>
        </form>
    </div>
</div>

<?php 

    // --- Update passwords

    if (isset($_POST["submit"])) {

        // Get data from form
        $id               = mysqli_real_escape_string($conn, $_POST["id"]);
        $current_password = md5($_POST["current_password"]);
        $new_password     = md5($_POST["new_password"]);
        $confirm_password = md5($_POST["confirm_password"]);

        // Get admin info 
        $sql = "SELECT * FROM tbl_admin 
                WHERE
                    id = $id
                AND 
                    password = '$current_password'
        ";
        
        // Execute
        $res = mysqli_query($conn, $sql);

        // IF VALID
        if ($res == TRUE) {

            $count = mysqli_num_rows($res);

            // -- -------------------------------------------------------
            // Current password is correct
            if ($count == 1) {
                
                // Check if password contain at least 8 chars, or redirect to
                validatePassword($_POST["new_password"], "update/update-password.php?id=$id");

                // New password match
                if ($new_password === $confirm_password) {

                    // Update password
                    $sql2 = "UPDATE 
                                tbl_admin 
                            SET
                                password = '$new_password'
                            WHERE
                                id = $id
                    ";
                    // Execute
                    query_session_redirect(
                        $conn,
                        $sql2,                               // sql 
                        "change-pwd",                        // Session name
                        "manage/manage-admin.php",           // Redirect to
                        "Password Changed Successfully",     // Success message
                        "Failed To Change Password!"         // Failure message
                    );      
                }   
                // New pass didn't match
                else {        
                    session_redirect(
                        "error",                              // status
                        "pwd-not-match",                      // Session name
                        "update/update-password.php?id=$id",  // Redirect to
                        "",                                   // Success message
                        "Password Did Not Match!"             // Failure message
                    );       
                }  
            }
            // -- -------------------------------------------------------
            // Current password is wrong
            else {
                session_redirect(
                    "error",                             // status
                    "wrong-pass",                        // Session name
                    "update/update-password.php?id=$id", // Redirect to
                    "",                                  // Success message
                    "Wrong password !"                   // Failure message
                );              
            }
        }
    }
?>
<?php include("../partials/footer.php"); ?>
