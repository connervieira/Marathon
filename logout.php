<!-- V0LT - Marathon -->
<?php

session_start();
session_unset();
// Remove all session variables

session_destroy();
// Destroy the session


$background_gradient_bottom = "#000000";
$background_gradient_top = "#444444";


include('./import_databases.php');
?>
<!DOCTYPE html>
<html lang="en" style="background:<?php echo $background_gradient_bottom; ?>;">
    <head>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Marathon - Admin Login</title>

        <link rel="stylesheet" href="./assets/css/Projects-Clean.css">
        <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css">
    </head>

    <body style="color:#111111;">
        <div class="projects-clean" style="background:linear-gradient(0deg, <?php echo $background_gradient_bottom; ?>, <?php echo $background_gradient_top; ?>);color:#111111;">
            <p style="color:white;">You have been logged out!</p>
            <a style="color:white;text-decoration:underline;" href="employeelogin.php">Login in</a>
        </div>
    </body>
</html>
