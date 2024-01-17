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
        <title>Marathon - Configure</title>

        <link rel="stylesheet" href="./assets/css/main.css">
    </head>

    <body>
        <div class="centered">
            <?php include('./import_databases.php'); ?>
        </div>
        <a class="button" role="button" href="index.php">Back</a>
        <div class="centered header">
            <h1>Marathon</h1>
            <h2>Configure</h2>
        </div>
        <main class="centered">
            <form action="configurationchange.php" method="POST" style="color:white;">
                <?php
                echo '<label for="disableadminsignups">Disable Admin Sign Ups: </label><input name="disableadminsignups" id="disabledadminsignups" type="checkbox" '; if ($configuration_database["disableadminsignups"] == true) { echo "checked"; } echo '><br>';
                echo '<label for="clockinverificationkey">Clock In Verification Key: </label><input name="clockinverificationkey" id="clockinverificationkey" type="text" value="' . $configuration_database["clockinverificationkey"] . '"><br>';
                echo '<label for="currency">Business Currency Code: </label><input name="currency" id="currency" type="text" maxlength="4" value="' . $configuration_database["currency"] .'"><br>';
                ?>
                <input class='button' type="submit" value="Submit">
            </form>
        </main>
    </body>
</html>
