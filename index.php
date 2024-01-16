<!-- V0LT - Marathon -->
<?php
session_start(); // Start a PHP session.
if ($_SESSION['authid'] == "marathon" and $_SESSION['loggedin'] == 1) { // Check to see if the user is logged in.
    $username = $_SESSION['username']; // Set the '$username' variable to the currently signed in user's username.
} else {
    header("Location: login.php"); // Redirect the user to the login page.
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Marathon - Adminstration</title>

        <link rel="stylesheet" href="./assets/css/Projects-Clean.css">
        <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="./assets/css/main.css">
    </head>

    <body>
        <a class="button" role="button" href="logout.php">Logout</a>
                <div class="centered">
                    <?php include('./import_databases.php'); ?>
                </div>
                <div class="centered header">
                    <h1>Marathon</h1>
                    <h2>Administration</h2>
                </div>
                <main>
                    <div class="row projects">
                        <div class="tile col-sm-6 col-lg-4 item">
                            <h3>Employees</h3>
                            <p>Add, remove, and edit employees in the database.</p>
                            <a class="button" role="button" href="employees.php" style="background-color:#444444;border-color:#eeeeee">Open</a>
                        </div>
                        <div class="tile col-sm-6 col-lg-4 item">
                            <h3>Positions</h3>
                            <p>Add, remove, and edit positions in the database.</p>
                            <a class="button" role="button" href="positions.php" style="background-color:#444444;border-color:#eeeeee">Open</a>
                        </div>
                        <div class="tile col-sm-6 col-lg-4 item">
                            <h3>Statistics</h3>
                            <p>View statistics related to this Marathon instance.</p>
                            <a class="button" role="button" href="statistics.php" style="background-color:#444444;border-color:#eeeeee">Open</a>
                        </div>
                        <div class="tile col-sm-6 col-lg-4 item">
                            <h3>Configuration</h3>
                            <p>View and update this instance's configuration.</p>
                            <a class="button" role="button" href="configure.php" style="background-color:#444444;border-color:#eeeeee">Open</a>
                        </div>
                        <div class="tile col-sm-6 col-lg-4 item">
                            <h3>Tools</h3>
                            <p>Access useful administrative tools for managing information.</p>
                            <a class="button" role="button" href="tools.php" style="background-color:#444444;border-color:#eeeeee">Open</a>
                        </div>
                        <div class="tile col-sm-6 col-lg-4 item">
                            <h3>Accounts</h3>
                            <p>View and manage administrator accounts on this instance.</p>
                            <a class="button" role="button" href="manageaccounts.php" style="background-color:#444444;border-color:#eeeeee">Open</a>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
