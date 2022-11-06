<?php 
    
    include("../../config/constants.php");
    include("../func/helpers.php");

    if (isset($_GET["id"]) && isset($_GET["image_name"])) {
                
        $id         = mysqli_real_escape_string($conn, $_GET["id"]);
        $image_name = mysqli_real_escape_string($conn, $_GET["image_name"]);

        // -- ---------------------------------------------------
        // Remove the physical image from folder
        if ($image_name != "") {

            $path = "../../images/food/" . $image_name;
            $remove = unlink($path);

            // Didn't remove the image
            if ($remove == FALSE) {

                session_redirect(
                    "error",                             // Status
                    "remove-image",                      // Session name
                    "manage/manage-food.php",            // Redirect to
                    "",                                  // Success message
                    "Failed To Remove Food Image"        // Failure message 
                );               

                // ++ Stop the process
                die();
            }
        }
        // -- ---------------------------------------------------

        // Delete data from Database
        $sql = "DELETE FROM tbl_food WHERE id=$id";
                                                
        query_session_redirect(
            $conn,
            $sql,                                   // sql
            "delete-food",                          // Session name
            "manage/manage-food.php",               // Redirect to
            "Food Deleted Successfully",            // Success message
            "Failled To Delete Food"                // Failure message  
        );  

    }
    // Not allowed without data ---> Redirect to manage category page
    else {    
        session_redirect(
            "error",                             // Status
            "unauthorised-access",               // Session name
            "manage/manage-food.php",            // Redirect to
            "",                                  // Success message
            "Unauthorised Access !"              // Failure message 
        );     
    }
?>