<!-- V0LT - Marathon -->
<?php
// Destroy the session.
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Marathon - Admin Login</title>

        <link rel="stylesheet" href="./assets/css/main.css">
    </head>
    <body>
        <main class="centered">
            <p>You have been logged out!</p>
            <a class="button" href="employeelogin.php">Login in</a>
        </main>
    </body>
</html>
