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
        <title>Marathon - Admin Tools</title>

        <link rel="stylesheet" href="./assets/css/Projects-Clean.css">
        <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="./assets/css/main.css">
    </head>

    <body style="background:linear-gradient(0deg, <?php echo $background_gradient_bottom; ?>, <?php echo $background_gradient_top; ?>);color:#111111;">
        <a class="button" role="button" href="index.php">Back</a>
        <div class="centered">
            <?php
            include('./import_databases.php');
            ?>
        </div>
        <main>
            <div class="centered header">
                <h1>Marathon</h1>
                <h2>Admin Tools</h2>
            </div>
            <div class="centered">
                <a class="button" role="button" href="unpaidshifts.php">Unpaid&nbsp;Shifts</a>
                <a class="button" role="button" href="paidshifts.php">Paid&nbsp;Shifts</a>
                <a class="button" role="button" href="allshifts.php">All&nbsp;Shifts</a>
                <a class="button" role="button" href="verifyshift.php">Verify&nbsp;Shifts</a>
            </div>
        </main>
    </body>
</html>
