<?php 

    include("../../config/constants.php");
    include("../func/helpers.php");

    if (isset($_GET["id"]) && isset($_GET["image_name"])) {
        
        $id         = mysqli_real_escape_string($conn, $_GET["id"]);
        $image_name = mysqli_real_escape_string($conn, $_GET["image_name"]);

        // -- ---------------------------------------------------

        // Remove the image from folder
        if ($image_name != "") {

            $path = "../../images/category/" . $image_name;
            $remove = unlink($path);

            // Didn't remove the image
            if ($remove == FALSE) {

                session_redirect(
                    "error",                             // Status
                    "remove-image",                      // Session name
                    "manage/manage-category.php",        // Redirect to
                    "",                                  // Success message
                    "Failed To Remove Category Image"    // Failure message 
                );               

                // ++ Stop the process
                die();
            }
        }
        // -- ---------------------------------------------------

        // Delete data from Database
        $sql = "DELETE FROM tbl_category WHERE id=$id";
                                                
        query_session_redirect(
            $conn,
            $sql,                              // sql
            "delete-category",                 // Session name
            "manage/manage-category.php",      // Redirect to
            "Category Deleted Successfully",   // Success message
            "Failled To Delete Category"       // Failure message  
        );           

    }
    // Not allowed without data ---> Redirect to manage category page
    else {        
        header("location:" . SITEURL . "admin/manage/manage-category.php");
    }
?>