<!-- V0LT - Marathon -->
<?php
session_start(); // Start a PHP session.
if ($_SESSION['loggedin'] == 2) { // Check to see if the user is logged in.
    $username = $_SESSION['username']; // Set the '$username' variable to the currently signed in user's username.
} else {
    header("Location: login.php"); // Redirect the user to the login page.
    exit();
}

$background_gradient_bottom = "#000000";
$background_gradient_top = "#444444";
?>
<!DOCTYPE html>
<html lang="en" style="background:<?php echo $background_gradient_bottom; ?>;">
    <head>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Marathon - Employee Timecard</title>

        <link rel="stylesheet" href="./assets/css/Projects-Clean.css">
        <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css">
    </head>

    <body style="color:#111111;">
        <div class="projects-clean" style="background:linear-gradient(0deg, <?php echo $background_gradient_bottom; ?>, <?php echo $background_gradient_top; ?>);color:#111111;">
            <div class="container" style="padding-top:100px;">
                <a class="btn btn-primary" role="button" href="employeedashboard.php" style="background-color:#444444;border-color:#eeeeee">Back</a>
                <div style="text-align:center;">
                    <?php
                    include('./import_databases.php');
                    ?>
                </div>
                <main>
                    <div class="intro">
                        <h2 class="text-center" style="color:#dddddd">Marathon</h2>
                        <p class="text-center" style="padding-bottom:54px;color:#dddddd;font-size:25px;">Employee Timecard</p>
                    </div>
                    <div class="row projects" style="padding-left:5%;padding-right:5%;color:white;">
                        <div class="col-sm-6 col-lg-4 item" style="margin:0;border-radius:15px;">
                            <h3>Clock In</h3>
                            <a class="btn btn-primary" role="button" href="#" style="background-color:#444444;border-color:#eeeeee">Open</a>
                        </div>
                        <div class="col-sm-6 col-lg-4 item" style="margin:0;border-radius:15px;">
                            <h3>Clock Out</h3>
                            <a class="btn btn-primary" role="button" href="#" style="background-color:#444444;border-color:#eeeeee">Open</a>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
