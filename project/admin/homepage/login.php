<?php 
    include("../../config/constants.php"); 
    include("../func/helpers.php"); 
?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Restaurant Website</title>
        <!-- Link CSS file -->
        <link rel="stylesheet" href="login.css">
    </head>

    <body>
        <div class="center">
            <h1>Login</h1>

            <form action="" method="POST">
                <?php
                    sessionSet_unset("login");
                    sessionSet_unset("no-login-message");
                ?>
                <div class="txt_field">
                    <input type="text" name="username" id="text" required>
                    <span></span>
                    <label for="text">Username</label>
                </div>
                <div class="txt_field">
                    <input type="password" name="password" id="password" required>
                    <span></span>
                    <label for="password">Password</label>
                </div>

                <div class="forgot_pass">Forgot Password</div>
                <input type="submit" value="Login" name="submit">

                <div class="signup_link">
                    Not a memeber? <a href="#">Singup</a>
                </div>
            </form>
        </div>
    </body>
</html>

<?php 

    if (isset($_POST["submit"])) {

        // 1. Get data from the form

        $username = mysqli_real_escape_string($conn, $_POST["username"]);

        $row_pass = md5($_POST["password"]);
        $password = mysqli_real_escape_string($conn, $row_pass);
    
        // 2. Check if user exist

        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

        $res = mysqli_query($conn, $sql);

        $count = mysqli_num_rows($res);

        if ($count == 1) {

            // ++ Save session for user to keep login
            $_SESSION["user"] = $username;

            session_redirect(
                "success",                 // status
                "login",                   // Session name
                "homepage/index.php",      // Redirect to
                "Login Successfully",      // Success message
                ""                         // Failure message  
            );  
                                
        }
        // User NOT available --> redirect to same page
        else {
            session_redirect(
                "error",                                                          // status
                "login",                                                          // Session name
                "homepage/login.php",                                             // Redirect to
                "",                                                               // Success message
                "<span class='error'>Username Or Password Did Not Match!</span>"  // Failure message 
            );                                                           
        }
    }
?>