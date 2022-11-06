<?php

    include("../../config/constants.php");
    
    // Delete all sessions
    session_destroy();

    // Redirect to login page
    header("location:" . SITEURL . "admin/homepage/login.php");
?>