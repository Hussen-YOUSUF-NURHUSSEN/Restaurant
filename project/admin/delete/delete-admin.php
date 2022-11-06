<?php 

    include("../../config/constants.php");
    include("../func/helpers.php");

    // Get the id to be deleted
    $id = mysqli_real_escape_string($conn, $_GET["id"]);

    // -- -----------------------------------------------------------------------

    // Hack prevention --> check wheter admin exist or not
    $check_id = "SELECT * FROM tbl_admin WHERE id=$id";

    $res = mysqli_query($conn, $check_id);

    if (mysqli_num_rows($res) != 1) {
        
        $_SESSION["delete-admin"] = "<div class='flash flash-error'>Admin Not Found</div>";
        header("location:" . SITEURL . "admin/manage/manage-admin.php");

        die();
    }

    // -- -----------------------------------------------------------------------


    // SQL query
    $sql = "DELETE FROM tbl_admin WHERE id=$id";    // ++ quotes around (var) if the (var) is string
                    
    query_session_redirect(
        $conn,
        $sql,                                         // sql
        "delete-admin",                               // Session name
        "manage/manage-admin.php",                    // Redirect to
        "Admin Deleted Successfully",                 // Success message
        "Failled To Delete Admin. Try Again Later"    // Failure message   
    );                         
?>