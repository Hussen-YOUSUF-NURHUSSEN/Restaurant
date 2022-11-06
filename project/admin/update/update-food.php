<?php 
    include("../partials/menu.php"); 
    include("../func/helpers.php");
?>
<?php
    // Check whether id is set or redirect
    if (isset($_GET["id"])) {

        $id = mysqli_real_escape_string($conn, $_GET["id"]); 

        $sql2 = "SELECT * FROM tbl_food WHERE id=$id";

        $res2 = mysqli_query($conn, $sql2);

        $count = mysqli_num_rows($res2);

        // if food exist in database

        if ($count == 1) {

            $row2 = mysqli_fetch_assoc($res2);

            $title             = $row2["title"];
            $description       = $row2["description"];
            $price             = $row2["price"];
            $current_image     = $row2["image_name"];
            $current_category  = $row2["category_id"];
            $featured          = $row2["featured"];
            $active            = $row2["active"];
        }   
        // Food not found
        else {
            session_redirect(
                "error",                    // status
                "no-food-found",            // Session name
                "manage/manage-food.php",   // Redirect to
                "",                         // Success message
                "Food Not Found!"           // Failure message
            );           
        }
    }
    // id is not set in the request
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


<div class="main-content">
    <div class="wrapper">
        <h1 class="header">Update Food</h1>

        <?php 
            sessionSet_unset("title-short");
            sessionSet_unset("price-missing");
        ?>

        <form method="POST" action="" enctype="multipart/form-data">

            <div>
                <label class="main-label" for="title">Title: </label>
                <input type="text" name="title" id="title" value="<?php echo $title; ?>">
            </div>

            <div>
                <label for="description" class="main-label center-label">Description</label>
                <textarea name="description" id="description" cols="30" rows="5"><?php echo $description; ?></textarea>
            </div>

            <div>
                <label for="price" class="main-label">Price</label>
                <input type="number" name="price" id="price" value="<?php echo $price; ?>">
            </div>

            <div>
                
                <?php 
                    if ($current_image != "") {

                        echo '<label class="main-label center-label" >Current Image: </label>';
                        echo "<img src='../../images/food/$current_image' class='update_img' alt='food_image' />";
                    }
                    // For style reason
                    else {
                        echo '<label class="main-label" >Current Image: </label>';
                        echo "<span class='error' style='margin-left: 3%;'>Image Not Available</span>";
                    }
                ?>
            </div>

            <div>
                <label for="image" class="main-label">Select New Image</label>
                <input type="file" name="image" id="image">
            </div>
            
            <!-- ------------------------------------------------------------------------------------------- -->
            <div>
                <label for="category" class="main-label">Category</label>
                <select name="category" id="category">
                    
                    <?php 
                        // --- Display categories title for the option

                        // Active categories
                        $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                        $res = mysqli_query($conn, $sql);

                        $count = mysqli_num_rows($res);

                        // --- ----------------------------------------------
                        if ($count > 0) {

                            // There is categories
                            while ($row = mysqli_fetch_assoc($res) ) {
                                
                                // Get details
                                $category_id    = $row["id"];
                                $category_title = $row["title"];

                                ?>
                                <option <?php if ($current_category == $category_id ) {echo "selected" ;} ?> value="<?php echo $category_id; ?>">
                                    <?php echo $category_title ?>
                                </option>
                                <?php
                            }
                        }
                        else {
                            // No categories
                            ?>
                            <option value="0">No Categories Found</option>
                            <?php 
                        }
                    ?>
                </select>
            </div>
            <!-- ------------------------------------------------------------------------------------------- -->

            <div>
                <label class="main-label">Featured</label>

                <input <?php if ($featured == "yes") {echo "checked" ;} ?> type="radio" name="featured" value="yes" id="yes-feat">
                <label for="yes-feat">Yes</label>

                <input <?php if ($featured == "no") {echo "checked" ;} ?> type="radio" name="featured" value="no" id="no-feat">
                <label for="no-feat">No</label>
            </div>

            <div>
                <label class="main-label">Active</label>

                <input <?php if ($active == "yes") {echo "checked" ;} ?> type="radio" name="active" value="yes" id="yes-active">
                <label for="yes-active">Yes</label>

                <input <?php if ($active == "no") {echo "checked" ;} ?> type="radio" name="active" value="no" id="no-active">
                <label for="no-active">No</label>
            </div>

            <div>
                <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                <input type="hidden" name="id"            value="<?php echo $id; ?>">
                <input type="submit" name="submit"        value="Update Food" class="button submit" >
            </div>

        </form>

        <?php 
            if (isset($_POST["submit"])) {
            
            // Get data
            $id                = mysqli_real_escape_string($conn, $_POST["id"]);
            $title             = mysqli_real_escape_string($conn, $_POST["title"]);
            
            $description       = mysqli_real_escape_string($conn, $_POST["description"]);
            $price             = mysqli_real_escape_string($conn, $_POST["price"]);

            $current_image     = mysqli_real_escape_string($conn, $_POST["current_image"]);
            $category          = mysqli_real_escape_string($conn, $_POST["category"]);
            
            // Check whether (featured) & (active) button is checked or or set default value
            $featured = isset($_POST["featured"]) ? mysqli_real_escape_string($conn, $_POST["featured"]) : "no";
            $active   = isset($_POST["active"])   ? mysqli_real_escape_string($conn, $_POST["active"])   : "no";


            // Check for length of title & if price is set
            validatefood(
                $title,
                $price, 
                "update/update-food.php?id=$id", 
                "problem_with_header()"                 // Redirect with javascript method instead
            );
        
                // --- ----------------------------------------------
                // Update new image if selected

                // ++ if the button is selected
                if (isset($_FILES["image"]["name"])) {

                    // it can be set and empty (when user hover without upload)
                    $image_name = $_FILES["image"]["name"];

                    // ++ if the button is selected && not empty
                    if ($image_name != "") {
                        
                        // Upload and rename image, then move it to images/category === or redirect and die()
                        $image_name = upload_img_ORredirect($_FILES, "manage/manage-food.php", "food");

                        // -- ------------------------------------
                        // Remove the current image if available  // *# ONLY WITH UPDATE
                        if ($current_image != "") {

                            $remove_path = "../../images/food/" . $current_image;
                            $remove      = unlink($remove_path);

                            if ($remove == FALSE) {

                                session_redirect(
                                    "error",                             // status
                                    "failed-remove-image",               // Session name
                                    "manage/manage-food.php",            // Redirect to
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
                $sql3 = "UPDATE 
                            tbl_food
                        SET
                            title           = '$title',
                            description     = '$description',
                            price           =  $price,
                            image_name      = '$image_name',
                            category_id     = $category,
                            featured        = '$featured',
                            active          = '$active'
                        WHERE
                            id = $id
                ";

                query_session_redirect(
                    $conn,
                    $sql3,                        // sql
                    "update-food",                // Session name
                    "manage/manage-food.php",     // Redirect to
                    "Food Updated Successfuly",   // Success message
                    "Failed To Update Food" ,     // Failure message

                    "true"                        // Some times the header() function don't work, so use javascript .method()
                );   
            }
        ?>
    </div>
</div>
<?php include("../partials/footer.php"); ?>