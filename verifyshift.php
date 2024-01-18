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
        <title>Marathon - Verify Shift</title>

        <link rel="stylesheet" href="./assets/css/main.css">
    </head>

    <body>
        <div class="centered">
            <?php
            include('./import_databases.php');
            ?>
        </div>
        <a class="button" role="button" href="shifts.php">Back</a>
        <div class="centered header">
            <h1>Marathon</h1>
            <h2>Verify Shift</h2>
            <p>This page allows you to verify a shift, given a verification hash and key pair.</p>
        </div>
        <main>
            <div class="centered">
                <form method="GET">
                    <label for="hash">Hash:</label><input placeholder="Hash" name="hash" autocomplete="off" required><br>
                    <label for="key">Key:</label><input placeholder="Key" name="key" autocomplete="off" type="text"><br>
                    <input type="submit" value="Submit" class="button">
                </form>
            </div>
            <?php
            if ($_GET["hash"] !== null and $_GET["hash"] !== "") {
                if ($_GET["key"] == "") {
                    $decrypted_verification_data = openssl_decrypt($_GET["hash"], "AES-128-CTR", $configuration_database["clockinverificationkey"], 0, "1");
                } else {
                    $decrypted_verification_data = openssl_decrypt($_GET["hash"], "AES-128-CTR", $_GET["key"], 0, "1");
                }
                echo "<p>" . $decrypted_verification_data . "</p>";
            }
            ?>
        </main>
    </body>
</html>
