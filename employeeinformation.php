<!-- V0LT - Marathon -->
<?php
session_start(); // Start a PHP session.
if ($_SESSION['authid'] == "marathon" and $_SESSION['loggedin'] == 2) { // Check to see if the user is logged in.
    $username = (string)$_SESSION['username']; // Set the '$username' variable to the currently signed in user's username.
} else {
    header("Location: employeelogin.php"); // Redirect the user to the login page.
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
        <title>Marathon - Employee Information</title>

        <link rel="stylesheet" href="./assets/css/Projects-Clean.css">
        <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css">
    </head>

    <body style="color:#111111;">
        <div class="projects-clean" style="background:linear-gradient(0deg, <?php echo $background_gradient_bottom; ?>, <?php echo $background_gradient_top; ?>);color:#111111;">
            <div class="container" style="padding-top:100px;">
                <a class="btn btn-primary" role="button" href="employeedashboard.php" style="background-color:#444444;border-color:#eeeeee">Back</a>
                <main>
                    <div class="intro">
                        <h2 class="text-center" style="color:#dddddd">Marathon</h2>
                        <p class="text-center" style="padding-bottom:54px;color:#dddddd;font-size:25px;">Employee Information</p>
                    </div>
                    <?php
                    include('./import_databases.php');

                    if (isset($_GET["confirm"]) == true) {
                        echo "<pre style='color:white;'>";
                        print_r($employee_database[$username]);
                        echo "</pre>";

                    } else {
                        echo "<p style='color:white;'>The following screen will show all of the personal information your employer has saved regarding your profile. This information may include sensitive information like password hashes and social security numbers. Please make sure you are in a private location before continuing.</p>";
                        echo "<a href='employeeinformation.php?confirm=true' style='color:white;text-decoration:underline;'>Confirm</a>";

                    }
                    ?>

                </main>
            </div>
        </div>
    </body>
</html>
