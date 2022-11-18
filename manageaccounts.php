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
        <title>Marathon - Manage Accounts</title>

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
                        <p class="text-center" style="padding-bottom:54px;color:#dddddd;font-size:40px;color:white;">Manage Accounts</p>
                        <div style="width:100%;text-align:center;margin-bottom:100px;">
                            <a class="btn btn-primary" role="button" href="signup.php" style="text-align:center;background-color:#444444;border-color:#eeeeee">Create Account</a>
                        </div>
                    </div>
                    <hr style="border-color:white;">
                    <div style="text-align:center;color:white;margin-top:100px;">
                        <?php
                        foreach ($authentication_database as $key => $element) {
                            echo "<div style='background:#333333;padding:20px;border-radius:15px;'>";
                            echo "<p style='font-size:25px;color:inherit;'><b>Username</b>: " . $key . "</p>";
                            echo "<a class='btn btn-primary' role='button' href='deleteaccount.php?user=" . $key . "' style='background-color:#444444;border-color:#eeeeee'>Delete</a>";
                            echo "</div>";
                            echo "<br><br>";
                        }
                        ?>
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
