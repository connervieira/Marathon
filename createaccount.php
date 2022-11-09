<!-- V0LT - Marathon -->
<?php
$background_gradient_bottom = "#000000";
$background_gradient_top = "#444444";
?>
<!DOCTYPE html>
<html lang="en" style="background:<?php echo $background_gradient_bottom; ?>;">
    <head>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Marathon - Create Account</title>

        <link rel="stylesheet" href="./assets/css/Projects-Clean.css">
        <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css">
    </head>

    <body style="color:#111111;">
        <div class="projects-clean" style="background:linear-gradient(0deg, <?php echo $background_gradient_bottom; ?>, <?php echo $background_gradient_top; ?>);color:#111111;">
            <div class="container" style="padding-top:100px;">
                <div style="text-align:center;">
                    <?php
                    include('./import_databases.php');
                    ?>
                </div>
                <main>
                    <a class="btn btn-primary" role="button" href="login.php" style="background-color:#444444;border-color:#eeeeee">Back</a>
                    <?php
                    $username = $_POST["username"];
                    $password1 = $_POST["password1"];
                    $password2 = $_POST["password2"];
                    
                    if ($configuration_database["disableadminsignups"] == true) {
                        echo "<p style='color:red;'>Error: Admin Sign Ups are currently disabled. Please contact the manager of your Marathon instance for more information.</p>";
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
                    file_put_contents('./databases/authenticationdatabase.txt', serialize($authentication_database)); // Write array changes to disk.

                    echo "<p style='text-align:center;color:white;'>Successfully created account!</p>";
                    ?>
                </main>
            </div>
        </div>
    </body>
</html>
