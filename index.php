<!-- V0LT - Marathon -->
<?php
session_start(); // Start a PHP session.
if ($_SESSION['authid'] == "marathon" and $_SESSION['loggedin'] == 1) { // Check to see if the user is logged in.
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
        <title>Marathon - Main Admin Page</title>

        <link rel="stylesheet" href="./assets/css/Projects-Clean.css">
        <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css">
    </head>

    <body style="color:#111111;">
        <div class="projects-clean" style="background:linear-gradient(0deg, <?php echo $background_gradient_bottom; ?>, <?php echo $background_gradient_top; ?>);color:#111111;">
            <div class="container" style="padding-top:100px;">
                <a class="btn btn-primary" role="button" href="logout.php" style="background-color:#444444;border-color:#eeeeee">Logout</a>
                <div style="text-align:center;">
                    <?php include('./import_databases.php'); ?>
                </div>
                <main>
                    <div class="intro">
                        <h2 class="text-center" style="color:#dddddd">Marathon</h2>
                        <p class="text-center" style="padding-bottom:54px;color:#dddddd;font-size:25px;">Main Admin Page</p>
                    </div>
                    <div class="row projects" style="padding-left:5%;padding-right:5%;color:white;">
                        <div class="col-sm-6 col-lg-4 item" style="margin:0;border-radius:15px;">
                            <h3>Employees</h3>
                            <p>Add, remove, and edit employees in the database.</p>
                            <a class="btn btn-primary" role="button" href="employees.php" style="background-color:#444444;border-color:#eeeeee">Open</a>
                        </div>
                        <div class="col-sm-6 col-lg-4 item" style="margin:0;border-radius:15px;">
                            <h3>Positions</h3>
                            <p>Add, remove, and edit positions in the database.</p>
                            <a class="btn btn-primary" role="button" href="positions.php" style="background-color:#444444;border-color:#eeeeee">Open</a>
                        </div>
                        <div class="col-sm-6 col-lg-4 item" style="margin:0;border-radius:15px;">
                            <h3>Statistics</h3>
                            <p>View statistics related to this Marathon instance.</p>
                            <a class="btn btn-primary" role="button" href="statistics.php" style="background-color:#444444;border-color:#eeeeee">Open</a>
                        </div>
                        <div class="col-sm-6 col-lg-4 item" style="margin:0;border-radius:15px;">
                            <h3>Configuration</h3>
                            <p>View and update this instance's configuration.</p>
                            <a class="btn btn-primary" role="button" href="configure.php" style="background-color:#444444;border-color:#eeeeee">Open</a>
                        </div>
                        <div class="col-sm-6 col-lg-4 item" style="margin:0;border-radius:15px;">
                            <h3>Tools</h3>
                            <p>Access useful administrative tools for managing information.</p>
                            <a class="btn btn-primary" role="button" href="tools.php" style="background-color:#444444;border-color:#eeeeee">Open</a>
                        </div>
                        <div class="col-sm-6 col-lg-4 item" style="margin:0;border-radius:15px;">
                            <h3>Accounts</h3>
                            <p>View and manage administrator accounts on this instance.</p>
                            <a class="btn btn-primary" role="button" href="manageaccounts.php" style="background-color:#444444;border-color:#eeeeee">Open</a>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
