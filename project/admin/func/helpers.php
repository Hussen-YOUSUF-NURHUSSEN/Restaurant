<?php 


// @-- sessionSet_unset() 

// --- Flash message 

function sessionSet_unset($session_name) {                          

    if (isset($_SESSION[$session_name])) {

        echo $_SESSION[$session_name] . "<br><br>";     
        unset($_SESSION[$session_name]);
    }
}

// -- -------------------------------------------------------------------------------------------------------------------------------------


// @--  validateAdmin() 

// Fucntion to check text length, and if it only contains letters, or die

function validateAdmin($str1, $str2, $redirectTo) {

    // Check if full name & username contain at least 2 chars
    if (strlen($str1) < 2 || strlen($str2) < 2  ) {

        session_redirect(
            "error",                                                   // status
            "name-short",                                              // Session name
            $redirectTo,                                               // Redirect to
            "",                                                        // Success message
            "Full name and user name must at least have 2 characters"  // Failure message  
        );  
        die();
    }

    // Check if full name & username contain only chars
    if (preg_match('/[^a-zA-Z]/', $str1) || preg_match('/[^a-zA-Z]/', $str2) ) {

        // ^ means (not), so true if any single char of $full_name is not any of inside bracet

        session_redirect(
            "error",                                                   // status
            "name-invalid",                                            // Session name
            $redirectTo,                                               // Redirect to
            "",                                                        // Success message
            "Full name and user name must only contains characters"    // Failure message  
        );  
        die();
    }
}


// -- -------------------------------------------------------------------------------------------------------------------------------------

// @--  validatePassword() 

// Check if password contain at least 8 chars, or redirect with message

function validatePassword($pass, $redirectTo) {

    if (strlen($pass) < 8 ) {

        session_redirect(
            "error",                                    // status
            "pass-invalid",                             // Session name
            $redirectTo,                                // Redirect to
            "",                                         // Success message
            "Password must at least have 8 characters"  // Failure message  
        );  
        die();
    }
}

// -- -------------------------------------------------------------------------------------------------------------------------------------


// @--  validatefood() 

// Check for length of title & if price is set

function validatefood($title, $price, $redirectTo, $problemWithHeader="false") {

    // Validate title
    if (strlen($title) < 2) {

        session_redirect(
            "error",                                  // status
            "title-short",                            // Session name
            $redirectTo,                              // Redirect to
            "",                                       // Success message
            "Title must have at least 2 characters",  // Failure message
            $problemWithHeader
        );  
        die();
    }

    // Validate price
    if (!$price) {
        
        session_redirect(
            "error",                // status
            "price-missing",        // Session name
            $redirectTo,            // Redirect to
            "",                     // Success message
            "Price is required !",  // Failure message  
            $problemWithHeader
        );  
        die();
    }
}


// -- -------------------------------------------------------------------------------------------------------------------------------------


// @--  validateOrder() 

// Check for length of customer_name & if quantity is set
function validateOrder($customer_name, $qty, $id)  {

    // Validate title
    if (strlen($customer_name) < 2) {

        session_redirect(
            "error",                                         // status
            "customer-name-short",                           // Session name
            "update/update-order.php?id=$id",                // Redirect to
            "",                                              // Success message
            "Customer name must have at least 2 characters"  // Failure message
        );  
        die();
    }

    // Validate price
    if (!$qty) {
        
        session_redirect(
            "error",                            // status
            "qty-missing",                      // Session name
            "update/update-order.php?id=$id",   // Redirect to
            "",                                 // Success message
            "Quantity is required !"            // Failure message  
        );  
        die();
    }
}



// -- -------------------------------------------------------------------------------------------------------------------------------------


// @--  upload_img_ORredirecT() 

// ++ Upload and rename the img, then move it to project/images/category === or redirect and die()

function upload_img_ORredirect($FILE, $redirect, $saveInFolder="category") {
            

    // --- Rename image 

    $image_name = $FILE["image"]["name"];

    // Get extention =====> Ex :- special.food.jpg  ===> jpg

    $tmp = explode(".", $image_name);
    $ext = end($tmp);

    $image_name = "Food_Category_" . time() . "." . $ext;

    // -- ------------------------------------

    $source_path      = $_FILES["image"]["tmp_name"];
    $destination_path = "../../images/$saveInFolder/" . $image_name;

    // ++     move_uploaded_file()
    $upload = move_uploaded_file($source_path, $destination_path);

    // -- ------------------------------------

    // Check
    if ($upload == FALSE) { 

        // Error message & redirect
        session_redirect(
            "error",                   // status
            "upload-image",            // Session name
            "$redirect",               // Redirect to
            "",                        // Success message
            "Failed To Upload Image"   // Failure message
        );        

        // stop the proccess
        die();
    }
    return $image_name;
}

// -- -------------------------------------------------------------------------------------------------------------------------------------

// @-- query_session_redirect() 

/*
    - Execute (sql query)
        - Based on result, if it work or if there is problem :-

        ===> inform with a msg and (set session) then (redirect)

    - $redirect ---> It is either array with 2 key ["success"] & ["failure"] whose values are different directions
                        or just one string ( same direction for both )
*/

function query_session_redirect($conn, $sql, $session_name, $redirect, $successMsg, $failedMsg, $problemWithHeader="false") {

    //  Execute query
    $res = mysqli_query($conn, $sql);

    // -- ---------------------------------------------------------
    //  IF VALID 
    if ($res == TRUE) {

        $_SESSION[$session_name] = "<div class='flash flash-success'>$successMsg</div>";

        $redirect_to = isset($redirect["success"]) ? $redirect["success"] : $redirect ;
    }
    //  IF FAILED  
    else {
        $_SESSION[$session_name] = "<div class='flash flash-error'>$failedMsg</div>";

        $redirect_to = isset($redirect["failure"]) ? $redirect["failure"] : $redirect ;
    }
    // -- ---------------------------------------------------------

    // ++ Redirect the page in both cases

    // Some times the header() function don't work, so use javascript method()

    if ($problemWithHeader == "false") {

        header("location:" . SITEURL . "admin/$redirect_to");
    }
    else {
        echo '<script>window.location="' . SITEURL . 'admin/' . $redirect_to . '"</script>';
    }
    
}

// -- -------------------------------------------------------------------------------------------------------------------------------------


// @-- session_redirect() 

// Only session & redirect

function session_redirect($status, $session_name, $redirect, $successMsg, $failedMsg, $problemWithHeader="false" ) {

    
    if ($status == "success") {

        $_SESSION[$session_name] = "<div class='flash flash-success'>$successMsg</div>";
    }
    else {
        $_SESSION[$session_name] = "<div class='flash flash-error'>$failedMsg</div>";
    }
    // -- ---------------------------------------------------------

    if ($problemWithHeader == "false") {

        // ++ Redirect the page in both cases
        header("location:" . SITEURL . "admin/$redirect");
    }

    // Some times the header() function don't work, so use javascript method()
    else {
        echo '<script>window.location="' . SITEURL . 'admin/' . $redirect . '"</script>';
    }
    
}