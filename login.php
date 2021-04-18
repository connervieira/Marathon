<!-- V0LT - Marathon -->
<?php

$background_gradient_bottom = "#000000";
$background_gradient_top = "#444444";


include('./import_databases.php');
?>
<!DOCTYPE html>
<html lang="en" style="background:<?php echo $background_gradient_bottom; ?>;">
    <head>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Marathon - Admin Login</title>

        <link rel="stylesheet" href="./assets/css/Projects-Clean.css">
        <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css">
    </head>

    <body style="color:#111111;">
        <div class="projects-clean" style="background:linear-gradient(0deg, <?php echo $background_gradient_bottom; ?>, <?php echo $background_gradient_top; ?>);color:#111111;">
            <?php
            $entered_username = $_POST["username"];
            $entered_password = $_POST["password"];
            
            session_start(); // Start a PHP session.
            if (isset($_SESSION['loggedin'])) { // Check to see if the user is logged in.
                echo "
                <div style='color:white;padding:10%;text-align:center;'>
                    <p style='color:red;'>Error: You are already signed in as " . $_SESSION['username'] . "!</p>
                </div>
                ";
                exit();
            }

            if ($entered_username !== null and $entered_username !== "") {
                echo "<div style='color:white;padding:10%;text-align:center;'>";
                if (isset($authentication_database[$entered_username])) {
                    if (password_verify($entered_password, $authentication_database[$entered_username]["password"])) {
                        session_start();
                        $_SESSION['loggedin'] = 1;
                        $_SESSION['username'] = $entered_username;
                        echo "<p style='color:inherit;'>Successfully signed in!</p>";
                        echo "<p style='color:inherit;'><a href='./index.php' style='text-decoration:underline;color:white;'>View Main Page</a></p>";
                    } else {
                        sleep(1); // Wait one second before showing the 'wrong password' message. This makes Marathon slightly more resistant to brute force attacks.
                        echo "<p style='color:red;'>Error: The password you entered is incorrect!</p>";
                    }
                } else {
                    echo "<p style='color:red;'>Error: The username you entered does not exist in the account database!</p>";
                }
                echo "</div>";
                exit();
            }
            ?>
            <div class="container" style="padding-top:100px;">
                <main>
                    <div class="intro">
                        <p class="text-center" style="padding-bottom:54px;color:#dddddd;font-size:40px;">Admin Login</p>
                    </div>
                    <div style="background-color:#222222;border-radius:15px;margin-left:10%;margin-right:10%;padding:5%;color:white;text-align:center;">
                        <form method="POST">
                            <label for="username">Username:</label> <input name="username" type="text" placeholder="Username"><br>
                            <label for="password1">Password:</label> <input name="password" type="password" placeholder="Password"><br>
                            <input type="submit">
                        </form>
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
