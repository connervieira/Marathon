<!-- V0LT - Marathon -->
<?php
session_start(); // Start a PHP session.
if ($_SESSION['authid'] == "marathon" and $_SESSION['loggedin'] == 2) { // Check to see if the user is logged in.
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
        <title>Marathon - Employee Dashboard</title>

        <link rel="stylesheet" href="./assets/css/Projects-Clean.css">
        <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="./assets/css/main.css">
    </head>
    <body>
        <a class="button" role="button" href="logout.php">Logout</a>
        <div style="text-align:center;">
            <?php
            include('./import_databases.php');
            ?>
        </div>
        <div class="centered header">
            <h1>Marathon</h1>
            <h2>Employee Dashboard</h2>
        </div>
        <main>
            <div class="centered">
            <a class="button" role="button" href="timecard.php">Timecard</a>
            <a class="button" role="button" href="employeeinformation.php">Information</a>
            <a class="button" role="button" href="timecardreceipts.php">Receipts</a>
            </div>
        </main>
    </body>
</html>
