<!-- V0LT - Marathon -->
<?php
session_start(); // Start a PHP session.
if ($_SESSION['authid'] == "marathon" and $_SESSION['loggedin'] == 2) { // Check to see if the user is logged in.
    $username = (string)$_SESSION['username']; // Set the '$username' variable to the currently signed in user's username.
} else {
    header("Location: employeelogin.php"); // Redirect the user to the login page.
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Marathon - Employee Information</title>

        <link rel="stylesheet" href="./assets/css/main.css">
    </head>

    <body>
        <a class="button" role="button" href="employeedashboard.php">Back</a>
            <div class="centered header">
                <h1>Marathon</h1>
                <h2>Employee Information</h2>
            </div>
            <main>
                <?php
                include('./import_databases.php');

                if (isset($_GET["confirm"]) == true) {
                    echo "<pre>";
                    print_r($employee_database[$username]);
                    echo "</pre>";

                } else {
                    echo "<div class='centered'>";
                    echo "<p>The following screen will show all of the personal information your employer has saved regarding your profile. This information may include sensitive information like password hashes and social security numbers. Please make sure you are in a private location before continuing.</p>";
                    echo "<a class='button' href='employeeinformation.php?confirm=true'>Confirm</a>";
                    echo "</div>";
                }
                ?>
            </main>
        </div>
    </body>
</html>
