<!-- V0LT - Marathon -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Marathon - Create Account</title>

        <link rel="stylesheet" href="./assets/css/main.css">
    </head>

    <body>
        <div class="centered">
            <?php include('./import_databases.php'); ?>
        </div>
        <main>
            <a class="button" role="button" href="index.php">Back</a>
            <div class="centered">
                <?php
                $username = $_POST["username"];
                $password1 = $_POST["password1"];
                $password2 = $_POST["password2"];
                
                session_start(); // Start a PHP session.
                if ($configuration_database["disableadminsignups"] == true) { // Check to see if admin signup's are disabled.
                    if ($_SESSION["loggedin"] !== 1 or $_SESSION['authid'] !== "marathon") { // Check to see if an admin is signed in to override the error.
                        echo "<p style='color:red;'>Error: Admin Sign Ups are currently disabled. Please contact the manager of your Marathon instance for more information.</p>";
                        exit();
                    }
                }

                if (strlen($username) > 30) {
                    echo "<p style='color:red;'>Error: The username you've entered is longer that the maximum permitted length. Please keep your username 30 characters or less.</p>";
                    exit();
                }

                if (preg_match("([^a-zA-Z0-9])", $username)) {
                    echo "<p style='color:red;'>Error: The username you've entered contains non-alphanumeric characters. Please ensure your username only contains letters and numbers</p>";
                    exit();
                }


                if (strlen($password1) > 1000) {
                    echo "<p style='color:red;'>Error: The password you've entered is longer that the maximum permitted length. Please keep your password 1000 characters or less.</p>";
                    exit();
                }

                if ($password1 !== $password2) {
                    echo "<p style='color:red;'>Error: The password and password confirmation do not match! This probably means you made a typo in one of the inputs.</p>";
                    exit();
                }
                
                if (isset($authentication_database[$username])) {
                    echo "<p style='color:red;'>Error: There is already an account with the same username as the one you've entered. If you're trying to log in to an existing account, please use the login page.</p>";
                    exit();
                }

                $authentication_database[$username]["password"] = password_hash($password1, PASSWORD_DEFAULT); // Add the new user and their hashed password to the authentication database.
                save_database('authenticationdatabase.json', $authentication_database); // Write array changes to disk.

                echo "<p>Successfully created account!</p>";
                ?>
            </div>
        </main>
    </body>
</html>
