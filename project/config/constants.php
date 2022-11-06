
<?php 
    
    // ++ THIS FILE WILL BE ADDED TO  ===> admin/partials/menu.php   ===> which is present everywhere
    
    // Start session
    session_start();
    
    // Site url of sql file
    define("SITEURL", "http://localhost/1_restaurant/project/");
    
    // Database
    define("LOCALHOST", "localhost");
    define("DB_NAME", "food-order");

    define("DB_USERNAME", "root");
    define("DB_PASSWORD", "");
    
    // mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    
    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn));

    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));
?>