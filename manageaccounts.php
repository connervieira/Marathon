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
        <title>Marathon - Manage Accounts</title>

        <link rel="stylesheet" href="./assets/css/main.css">
    </head>

    <body>
        <div class="centered">
            <?php include('./import_databases.php'); ?>
        </div>
        <main>
            <a class="button" role="button" href="index.php">Back</a>
            <div class="centered header">
                <h1>Marathon</h1>
                <h2>Manage Accounts</h2>
                <a class="button" role="button" href="signup.php">Create Account</a>
            </div>
            <hr class="separator-thin">
            <div class="centered">
                <?php
                foreach ($authentication_database as $key => $element) {
                    echo "<div class='horizontal-tile'>";
                    echo "<h3><b>Username</b>: " . $key . "</h3>";
                    echo "<a class='button' role='button' href='deleteaccount.php?user=" . $key . "'>Delete</a>";
                    echo "</div>";
                    echo "<br><br>";
                }
                ?>
            </div>
        </main>
    </body>
</html>
