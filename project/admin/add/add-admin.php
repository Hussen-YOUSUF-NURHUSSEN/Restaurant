<?php 
    include("../partials/menu.php"); 
    include("../func/helpers.php");
?>


<div class="main-content">
    <div class="wrapper">
        <h1 class="header">Add Admin</h1>

        <?php 
            sessionSet_unset("name-invalid");
            sessionSet_unset("name-short");
            sessionSet_unset("pass-invalid");
            sessionSet_unset("name-exist");
        ?>

        <form action="" method="POST">
            <div>
                <label class="main-label" for="full_name">Full Name: </label>
                <input type="text" name="full_name" id="full_name" placeholder="Enter Your Name">
            </div>
            <div>
                <label class="main-label" for="username">Username: </label>
                <input type="text" name="username" id="username">
            </div>
            <div>
                <label class="main-label" for="password">Password: </label>
                <input type="password" name="password" id="password">
            </div>
            <div>
                <input type="submit" name="submit" value="Add Admin" class="button submit" >
            </div>
        </form>
    </div>
</div>

<?php include("../partials/footer.php"); ?>

<?php 

    // --- Proccess the values from form then save it in database

    // Check whether the submit button is clicked or not 
    if (isset($_POST["submit"])) {

        // 1. Get data from FROM
        $full_name = mysqli_real_escape_string($conn, $_POST["full_name"]);
        $username  = mysqli_real_escape_string($conn, $_POST["username"]);

        $password  = md5($_POST["password"]);


        // 2. Validate input's ----------------------------------

        // Fucntion to check text length, and if it only contains letters, or die
        validateAdmin(
                $_POST["full_name"], 
                $_POST["username"], 
                "add/add-admin.php"
        );


        // Check whether name already exist or not in databse
        $sql   = "SELECT * FROM tbl_admin WHERE full_name = '$full_name' or username = '$username'";
        $exc   = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($exc);

        // Error if (name exist)
        if ($count != 0) {

            session_redirect(
                "error",                         // status
                "name-exist",                    // Session name
                "add/add-admin.php",             // Redirect to
                "",                              // Success message
                "Invalid name, already exist !"  // Failure message  
            );  
            die();
        }

        // Check if password contain at least 8 chars
        validatePassword($_POST["password"], "add/add-admin.php");

        // -- -----------------------------------------------------------------------
        
        // 3. SQL query to save data into database
        $sql2 = "INSERT INTO 
                    tbl_admin (full_name, username, password)
                VALUES 
                    ('$full_name', '$username', '$password')
        ";
                
        query_session_redirect(
            $conn,
            $sql2,                           // sql
            "add-admin",                     // Session name
            "manage/manage-admin.php",       // Redirect to
            "Admin Added Successfully",      // Success message
            "Failed To Add Admin"            // Failure message
        );         
    }
?>