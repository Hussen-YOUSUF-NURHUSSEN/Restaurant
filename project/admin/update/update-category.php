<?php 
    include("../partials/menu.php"); 
    include("../func/helpers.php");
?>

<div class="main-content">
    <div class="wrapper">
        <h1 class="header">Update Category</h1>

        <?php 
            sessionSet_unset("title-short");

            if (isset($_GET["id"])) {

                // Get id to check if category exist
                $id = mysqli_real_escape_string($conn, $_GET["id"]); 

                $sql = "SELECT * FROM tbl_category WHERE id=$id";

                $res = mysqli_query($conn, $sql);

                $count = mysqli_num_rows($res);

                // IF category exist in database
                if ($count == 1) {

                    $row = mysqli_fetch_assoc($res);

                    $title         = $row["title"];
                    $current_image = $row["image_name"];
                    $featured      = $row["featured"];
                    $active        = $row["active"];
                }   
                else {
                    // Redirect with message
                    session_redirect(
                        "error",                           // status
                        "no-category-found",               // Session name
                        "manage/manage-category.php",      // Redirect to
                        "",                                // Success message
                        "Category Not Found!"              // Failure message
                    );           
                }
            }
            // No id with get request
            else {
                header("location:" . SITEURL . "admin/manage/manage-category.php");
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <div>
                <label class="main-label" for="title">Title: </label>
                <input type="text" name="title" id="title" value="<?php echo $title; ?>">
            </div>
            <div>
                <?php 
                    if ($current_image != "") {
                ?>
                        <label class="main-label center-label" for="title">Current Image: </label>

                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" 
                                class="update_img" alt="category_image">
                <?php
                    }
                    // For style reason
                    else {
                        echo '<label class="main-label" for="title">Current Image: </label>';
                        echo "<span class='error' style='margin-left: 3%;'>Image Not Added </span> ";
                    }
                ?>
            </div>
            <div>
                <label class="main-label" >New Image: </label>
                <input type="file" name="image">
            </div>
            <div>
                <label class="main-label">Featured: </label>

                <input <?php if ($featured == "Yes") {echo "checked";} ?> type="radio" name="featured" id="yes-feat" value="Yes">
                <label for="yes-feat">Yes</label>

                <input <?php if ($featured == "No") {echo "checked";} ?> type="radio" name="featured" id="no-feat" value="No">
                <label for="no-feat">No</label>
            </div>
            <div>
                <label class="main-label">Active: </label>

                <input <?php if ($active == "Yes") {echo "checked";} ?> type="radio" name="active" id="yes-act" value="Yes">
                <label for="yes-act">Yes</label>

                <input <?php if ($active == "No") {echo "checked";} ?> type="radio" name="active" id="no-act" value="No">
                <label for="no-act">No</label>
            </div>

            <div>
                <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                <input type="hidden" name="id"            value="<?php echo $id; ?>">
                <input type="submit" name="submit"        value="Update Category" class="button submit" >
            </div>
        </form>

        <?php 

            if (isset($_POST["submit"])) {

                // Get data from form
                $id            = mysqli_real_escape_string($conn, $_POST["id"]);
                $title         = mysqli_real_escape_string($conn, $_POST["title"]);
                $current_image = mysqli_real_escape_string($conn, $_POST["current_image"]);
                $featured      = mysqli_real_escape_string($conn, $_POST["featured"]);
                $active        = mysqli_real_escape_string($conn, $_POST["active"]);

                // Validate title
                if (strlen($title) < 2) {

                    session_redirect(
                        "error",                                                     // status
                        "title-short",                                               // Session name
                        "update/update-category.php?id=$id&image_name=$image_name",  // Redirect to
                        "",                                                          // Success message
                        "Title must have at least 2 characters"                      // Failure message  
                    );  
                    die();
                }

                // --- ----------------------------------------------
                // Update new image if selected

                // ++ if the button is selected
                if (isset($_FILES["image"]["name"])) {

                    // it can be set and empty (when user hover without upload)
                    $image_name = $_FILES["image"]["name"];

                    // ++ if the button is selected && not empty
                    if ($image_name != "") {
                        
                        // Upload and rename image, then move it to images/category === or redirect and die()
                        $image_name = upload_img_ORredirect($_FILES, "manage/manage-category.php");

                        // -- ------------------------------------
                        // Remove the current image if available  // *# ONLY WITH UPDATE
                        if ($current_image != "") {

                            $remove_path = "../../images/category/" . $current_image;
                            $remove      = unlink($remove_path);

                            if ($remove == FALSE) {

                                session_redirect(
                                    "error",                             // status
                                    "faild-remove",                      // Session name
                                    "manage/manage-category.php",        // Redirect to
                                    "",                                  // Success message
                                    "Failed To Remove Current Image"     // Failure message
                                );  
                                die();
                            }
                        }
                        // -- ------------------------------------
                    }
                    else {
                        // ++ if the button is selected && empty
                        $image_name = $current_image;
                    }
                }
                else {
                    // ++ if the button is NOT selected 
                    $image_name = $current_image;
                }
                // --- ----------------------------------------------

                // Sql
                $sql2 = "UPDATE 
                            tbl_category
                        SET
                            title      = '$title',
                            image_name = '$image_name',
                            featured   = '$featured',
                            active     = '$active'
                        WHERE
                            id = $id
                ";

                query_session_redirect(
                    $conn,
                    $sql2,                             // sql
                    "update-category",                 // Session name
                    "manage/manage-category.php",      // Redirect to
                    "Category Updated Successfuly",    // Success message
                    "Failed To Update Category"        // Failure message
                );     
            }
        ?>
    </div>
</div>
<?php include("../partials/footer.php"); ?>