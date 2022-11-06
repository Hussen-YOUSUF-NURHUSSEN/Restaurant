
<!-- Relative to files who will call it ===> in their turn will go two step back -->
<?php 
    include("../../config/constants.php");

    // ++ Access Control
    if (! isset($_SESSION["user"])) {
        
        $_SESSION["no-login-message"] = "<div class='error'>Please Login To Access Panel</div>";      
        header("location:" . SITEURL . "admin/homepage/login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Restaurant Website</title>
        <!-- Link CSS file -->
        <link rel="stylesheet" href="../../css/admin.css">
    </head>

    <body>
        <!-- ++ Menu -->
        <div class="menu">
            <div class="wrapper">
                <ul>
                    <li><a href="<?php echo SITEURL; ?>admin/homepage/index.php">Home</a></li>
                    <li><a href="<?php echo SITEURL; ?>admin/manage/manage-admin.php">Admin</a></li>
                    <li><a href="<?php echo SITEURL; ?>admin/manage/manage-category.php">Category</a></li>
                    <li><a href="<?php echo SITEURL; ?>admin/manage/manage-food.php">Food</a></li>
                    <li><a href="<?php echo SITEURL; ?>admin/manage/manage-order.php">Order</a></li>
                    <li><a href="<?php echo SITEURL; ?>admin/homepage/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
        <!-- ++ Menu -->