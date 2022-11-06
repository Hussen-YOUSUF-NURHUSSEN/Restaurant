<?php 
    include("../partials/menu.php"); 
    include("../func/helpers.php");
?>

<div class="main-content">
    <div class="wrapper">
        <h1 class="header">Add Category</h1>

        <?php 
            sessionSet_unset("add-category");
            sessionSet_unset("upload-image");
            sessionSet_unset("name-short");
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <div>
                <label class="main-label" for="title" require>Title: </label>
                <input type="text" name="title" id="title" placeholder="Category Title">
            </div>
            <div>
                <label class="main-label" >Select Image: </label>
                <input type="file" name="image">
            </div>
            <div>
                <label class="main-label">Featured: </label>

                <input type="radio" name="featured" id="yes-feat" value="Yes">
                <label for="yes-feat">Yes</label>

                <input type="radio" name="featured" id="no-feat" value="No">
                <label for="no-feat">No</label>
            </div>
            <div>
                <label class="main-label">Active: </label>

                <input type="radio" name="active" id="yes-act" value="Yes">
                <label for="yes-act">Yes</label>

                <input type="radio" name="active" id="no-act" value="No">
                <label for="no-act">No</label>
            </div>

            <div>
                <input type="submit" name="submit" value="Add Category" class="button submit" >
            </div>
        </form>

        <?php 
            if (isset($_POST["submit"])) {
                
                // --- Add the category to database

                // 1. Get data from the form   ------------------------------------

                $title = mysqli_real_escape_string($conn, $_POST["title"]);

                // Check whether (featured) & (active) button is checked or set default value
                $featured = isset($_POST["featured"]) ? mysqli_real_escape_string($conn, $_POST["featured"]) : "No";
                $active   = isset($_POST["active"])   ? mysqli_real_escape_string($conn, $_POST["active"])   : "No";

                // Validate title
                if (strlen($title) < 2) {

                    session_redirect(
                        "error",                                 // status
                        "name-short",                            // Session name
                        "add/add-category.php",                  // Redirect to
                        "",                                      // Success message
                        "Title must have at least 2 characters"  // Failure message  
                    );  
                    die();
                }

                // 2. Upload image if selected  ------------------------------------

                /*
                    --- print_r(  $_FILES["image"]   );

                    [name]      => DSC_0173.JPG 
                    [full_path] => DSC_0173.JPG 
                    [type]      => image/jpeg 
                    [tmp_name]  => C:\xampp\tmp\php27E9.tmp 
                    [error]     => 0 
                    [size]      => 5771014 
                */
                
                // ++ if the button is selected
                if (isset($_FILES["image"]["name"])) {

                    // it can be set and empty (when user hover without upload)
                    $image_name = $_FILES["image"]["name"];

                    // ++ if the button is selected && not empty
                    if ($image_name != "") {
    
                       // Upload and return the rename of new image, then move it to images/category === or redirect and die()
                        $image_name = upload_img_ORredirect($_FILES, "add/add-category.php");
                    }
                    else {
                        // ++ if the button is selected && empty
                        $image_name = "";
                    }
                }

                // 3. Insert into dataabse   ------------------------------------

                $sql = "INSERT INTO 
                            tbl_category (title, image_name, featured, active)
                        VALUES 
                            ('$title', '$image_name', '$featured', '$active')
                ";

                // 4. Redirect with message  ------------------------------------

                $redirect = array(
                    "success" => "manage/manage-category.php",
                    "failure" => "add/add-category.php"
                );

                query_session_redirect(
                    $conn,
                    $sql,                            // sql
                    "add-category",                  // Session name
                    $redirect,                       // Redirect to
                    "Category Added Successfully",   // Success message
                    "Failed To Add Category"         // Failure message
                );      
            }
        ?>
    </div>
</div>
<?php include("../partials/footer.php"); ?>