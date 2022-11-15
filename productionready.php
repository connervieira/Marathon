<!-- V0LT - Marathon -->
<?php
session_start(); // Start a PHP session.
if ($_SESSION['loggedin'] == 1) { // Check to see if the user is logged in.
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
        <title>Marathon - Production Check</title>

        <link rel="stylesheet" href="./assets/css/Projects-Clean.css">
        <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css">
    </head>

    <body style="color:#111111;">
        <div class="projects-clean" style="background:linear-gradient(0deg, <?php echo $background_gradient_bottom; ?>, <?php echo $background_gradient_top; ?>);color:#111111;">
            <div class="container" style="padding-top:100px;">
                <div style="text-align:center;">
                    <?php include('./import_databases.php'); ?>
                </div>
                <main>
                    <a class="btn btn-primary" role="button" href="index.php" style="background-color:#444444;border-color:#eeeeee">Back</a>
                    <div class="intro">
                        <p class="text-center" style="padding-bottom:54px;color:#dddddd;font-size:40px;color:white;">Production Check</p>
                    </div>
                    <div style="text-align:center;margin-bottom:300px;">
                        <p class='text-center' style='color:#dddddd;font-size:20px;color:white;'>This tool tries to detect common configuration problems that should be changed before Marathon is officially published.</p>
                        <p class='text-center' style='color:#dddddd;font-size:20px;color:white;'>Severe issues will be marked in red. Minor issues will be marked in yellow. Things that are working as expected will be green.</p>

                        <br><hr style="border-color:white;"><br>


                        <?php
                        if ($configuration_database["disableadminsignups"] == true) { // Check to see if admin signups are disabled.
                            echo "<p class='text-center' style='color:#dddddd;font-size:20px;color:green;'>Admin account creation is disabled.</p>";
                            echo "<p class='text-center' style='color:#dddddd;font-size:15px;color:white;'>Employees and other users with access to this Marathon instance will not be able to create unauthorized administrative users.</p>";
                        } else {
                            echo "<p class='text-center' style='color:#dddddd;font-size:20px;color:red;'>Admin account creation is enabled.</p>";
                            echo "<p class='text-center' style='color:#dddddd;font-size:15px;color:white;'>Employees and other users with access to this Marathon instance will be able to create unauthorized administrative users.</p>";
                        }

                        echo "<br><br>";

                        if ($configuration_database["clockinverificationkey"] !== "" and $configuration_database["clockinverificationkey"] !== null) { // Check to see if a clock-in verification key is set.
                            echo "<p class='text-center' style='color:#dddddd;font-size:20px;color:green;'>A shift verification key is set.</p>";
                            echo "<p class='text-center' style='color:#dddddd;font-size:15px;color:white;'>Employees will be able to cryptographically verify their shifts.</p>";
                        } else {
                            echo "<p class='text-center' style='color:#dddddd;font-size:20px;color:red;'>No shift verification key is set.</p>";
                            echo "<p class='text-center' style='color:#dddddd;font-size:15px;color:white;'>Employees will not be able to cryptographically verify their shifts, and will be shown an error when they clock out.</p>";
                        }

                        echo "<br><br>";

                        if ($configuration_database["currency"] !== "" and $configuration_database["currency"] !== null) { // Check to see if a business currency is set.
                            echo "<p class='text-center' style='color:#dddddd;font-size:20px;color:green;'>A business currency is set.</p>";
                            echo "<p class='text-center' style='color:#dddddd;font-size:15px;color:white;'>Currency values will be rounded to the nearest fractional unit, when appropriate.</p>";
                        } else {
                            echo "<p class='text-center' style='color:#dddddd;font-size:20px;color:yellow;'>No business currency is set.</p>";
                            echo "<p class='text-center' style='color:#dddddd;font-size:15px;color:white;'>Currency inputs may accept fractional values of currency that are not possible.</p>";
                        }

                        echo "<br><br>";

                        if (file_exists($database_directory)) { // Check to see if the database directory exists.
                            echo "<p class='text-center' style='color:#dddddd;font-size:20px;color:green;'>The database directory exists.</p>";
                            echo "<p class='text-center' style='color:#dddddd;font-size:15px;color:white;'>Marathon will be able to load information from databases.</p>";
                        } else {
                            echo "<p class='text-center' style='color:#dddddd;font-size:20px;color:red;'>The database directory doesn't exist.</p>";
                            echo "<p class='text-center' style='color:#dddddd;font-size:15px;color:white;'>Marathon will not be able to load information from databases.</p>";
                        }

                        echo "<br><br>";

                        if (is_writable($database_directory)) { // Check to see if the database directory is writable.
                            echo "<p class='text-center' style='color:#dddddd;font-size:20px;color:green;'>The database directory is writable.</p>";
                            echo "<p class='text-center' style='color:#dddddd;font-size:15px;color:white;'>Marathon will be able to write information to databases.</p>";
                        } else {
                            echo "<p class='text-center' style='color:#dddddd;font-size:20px;color:red;'>The database directory isn't writable.</p>";
                            echo "<p class='text-center' style='color:#dddddd;font-size:15px;color:white;'>Marathon will not be able to write information to databases.</p>";
                        }

                        echo "<br><br>";

                        if (is_writable($database_directory . "/timecarddatabase.txt")) { // Check to see if the timecard database is writable.
                            echo "<p class='text-center' style='color:#dddddd;font-size:20px;color:green;'>The timecard database is writable.</p>";
                            echo "<p class='text-center' style='color:#dddddd;font-size:15px;color:white;'>Employees will be able to clock in and clock out.</p>";
                        } else {
                            echo "<p class='text-center' style='color:#dddddd;font-size:20px;color:red;'>The timecard database is not writable.</p>";
                            echo "<p class='text-center' style='color:#dddddd;font-size:15px;color:white;'>Employees will not be able to clock in or clock out.</p>";
                        }

                        echo "<br><br>";

                        if (is_writable($database_directory . "/paydatabase.txt")) { // Check to see if the pay database is writable.
                            echo "<p class='text-center' style='color:#dddddd;font-size:20px;color:green;'>The pay database is writable.</p>";
                            echo "<p class='text-center' style='color:#dddddd;font-size:15px;color:white;'>Admins will be able to manage employee paychecks.</p>";
                        } else {
                            echo "<p class='text-center' style='color:#dddddd;font-size:20px;color:red;'>The pay database is not writable.</p>";
                            echo "<p class='text-center' style='color:#dddddd;font-size:15px;color:white;'>Admins will not be able to manage employee paychecks.</p>";
                        }

                        echo "<br><br>";

                        if (is_writable($database_directory . "/employeedatabase.txt")) { // Check to see if the employee database is writable.
                            echo "<p class='text-center' style='color:#dddddd;font-size:20px;color:green;'>The employee database is writable.</p>";
                            echo "<p class='text-center' style='color:#dddddd;font-size:15px;color:white;'>Admins will be able to manage employees.</p>";
                        } else {
                            echo "<p class='text-center' style='color:#dddddd;font-size:20px;color:red;'>The employee database is not writable.</p>";
                            echo "<p class='text-center' style='color:#dddddd;font-size:15px;color:white;'>Admins will not be able to manage employees.</p>";
                        }

                        echo "<br><br>";

                        if (is_writable($database_directory . "/positiondatabase.txt")) { // Check to see if the position database is writable.
                            echo "<p class='text-center' style='color:#dddddd;font-size:20px;color:green;'>The position database is writable.</p>";
                            echo "<p class='text-center' style='color:#dddddd;font-size:15px;color:white;'>Admins will be able to manage positions.</p>";
                        } else {
                            echo "<p class='text-center' style='color:#dddddd;font-size:20px;color:red;'>The positions database is not writable.</p>";
                            echo "<p class='text-center' style='color:#dddddd;font-size:15px;color:white;'>Admins will not be able to manage positions.</p>";
                        }

                        echo "<br><br>";

                        if (is_writable($database_directory . "/authenticationdatabase.txt")) { // Check to see if the authentication database is writable.
                            echo "<p class='text-center' style='color:#dddddd;font-size:20px;color:green;'>The authentication database is writable.</p>";
                            echo "<p class='text-center' style='color:#dddddd;font-size:15px;color:white;'>Admin accounts can be created and modified.</p>";
                        } else {
                            echo "<p class='text-center' style='color:#dddddd;font-size:20px;color:red;'>The authentication database is not writable.</p>";
                            echo "<p class='text-center' style='color:#dddddd;font-size:15px;color:white;'>Admin accounts can't be created or modified.</p>";
                        }

                        echo "<br><br>";

                        if (is_writable($database_directory . "/configurationdatabase.txt")) { // Check to see if the configuration database is writable.
                            echo "<p class='text-center' style='color:#dddddd;font-size:20px;color:green;'>The configuration database is writable.</p>";
                            echo "<p class='text-center' style='color:#dddddd;font-size:15px;color:white;'>The Marathon configuration can be modified.</p>";
                        } else {
                            echo "<p class='text-center' style='color:#dddddd;font-size:15px;color:white;'>The Marathon configuration can be modified.</p>";
                            echo "<p class='text-center' style='color:#dddddd;font-size:15px;color:white;'>The Marathon configuration can't be changed.</p>";
                        }
                        ?>
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
