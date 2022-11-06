<?php
    include("../partials/menu.php"); 
    include("../func/helpers.php");
?>

<div class="main-content">
    <div class="wrapper">
        <h1 class="header">Add Food</h1>

        <?php 
            // if the image failed to upload
            sessionSet_unset("upload-image");

            sessionSet_unset("title-short");
            sessionSet_unset("price-missing");
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <div>
                <label for="title" class="main-label">Title</label>
                <input type="text" name="title" id="title" placeholder="Title of the food">
            </div>

            <div>
                <label for="description" class="main-label center-label">Description</label>
                <textarea name="description" id="description" cols="30" rows="5"></textarea>
            </div>

            <div>
                <label for="price" class="main-label">Price</label>
                <input type="number" name="price" id="price">
            </div>

            <div>
                <label for="image" class="main-label">Select image</label>
                <input type="file" name="image" id="image">
            </div>

            <!-- ------------------------------------------------------------------------------------------- -->
            <div>
                <label for="category" class="main-label">Category</label>
                <select name="category" id="category">

                <?php 
                    // --- Display categories from database

                    // Active categories
                    $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                    $res   = mysqli_query($conn, $sql);
                    $count = mysqli_num_rows($res);

                    // --- ----------------------------------------------
                    
                    // There is categories
                    if ($count > 0) {

                        while ($row = mysqli_fetch_assoc($res) ) {
                            
                            // Get details
                            $id    = $row["id"];
                            $title = $row["title"];

                            ?>
                            <option value="<?php echo $id ?>"><?php echo $title ?></option>
                            <?php
                        }
                    }
                    // No categories
                    else {
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

                <input type="radio" name="featured" value="yes" id="yes-feat">
                <label for="yes-feat">Yes</label>

                <input type="radio" name="featured" value="no" id="no-feat">
                <label for="no-feat">No</label>
            </div>

            <div>
                <label class="main-label">Active</label>

                <input type="radio" name="active" value="yes" id="yes-active">
                <label for="yes-active">Yes</label>

                <input type="radio" name="active" value="no" id="no-active">
                <label for="no-active">No</label>
            </div>

            <div>
                <input type="submit" name="submit" value="Add Food" class="button submit" >
            </div>
        </form>
        
        <?php 
            if (isset($_POST["submit"])) {
                
                // --- Add the food to database

                // 1. Get data from the form   ------------------------------------
                $title       = mysqli_real_escape_string($conn, $_POST["title"]);  
                $description = mysqli_real_escape_string($conn, $_POST["description"]);  
                $price       = mysqli_real_escape_string($conn, $_POST["price"]);
                $category    = mysqli_real_escape_string($conn, $_POST["category"]);


                // Check whether (featured) & (active) button is checked or or set default value
                $featured = isset($_POST["featured"]) ? mysqli_real_escape_string($conn, $_POST["featured"]) : "no";
                $active   = isset($_POST["active"])   ? mysqli_real_escape_string($conn, $_POST["active"])   : "no";

                // Check for length of title & if price is set
                validatefood($title, $price, "add/add-food.php");


                // 2. Upload image if selected  ------------------------------------

                // ++ if the button is selected
                if (isset($_FILES["image"]["name"])) {

                    $image_name = $_FILES["image"]["name"];

                    // ++ if the button is selected && not empty
                    if ($image_name != "") {
    
                       // Upload and rename image, then move it to images/category === or redirect and die()
                        $image_name = upload_img_ORredirect($_FILES, "add/add-category.php", "food");
                    }
                    else {
                        // ++ if the button is selected && empty
                        $image_name = "";
                    }
                }

                // 3. Insert into dataabse   ------------------------------------

                $sql2 = "INSERT INTO 
                            tbl_food (title, description, price, image_name, category_id, featured, active)
                        VALUES 
                            ('$title', '$description', $price, '$image_name', $category, '$featured', '$active' )
                ";

                // 4. Redirect with message  ------------------------------------
                
                query_session_redirect(
                    $conn,
                    $sql2,                        // sql
                    "add-food",                   // Session name
                    "manage/manage-food.php",     // Redirect to
                    "Food Added Successfully",    // Success message
                    "Failed To Add Food",         // Failure message

                    "true"                        // Some times the header() function don't work, so use javascript method()
                ); 
            }
        ?>
    </div>
</div>
<?php include("../partials/footer.php"); ?>