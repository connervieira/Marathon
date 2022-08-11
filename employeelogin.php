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
        <title>Marathon - Employee Login</title>

        <link rel="stylesheet" href="./assets/css/Projects-Clean.css">
        <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css">
    </head>

    <body style="color:#111111;">
        <div class="projects-clean" style="background:linear-gradient(0deg, <?php echo $background_gradient_bottom; ?>, <?php echo $background_gradient_top; ?>);color:#111111;">
            <?php
            $entered_id = $_POST["id"];
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

            if ($entered_id !== null and $entered_id !== "") {
                echo "<div style='color:white;padding:10%;text-align:center;'>";
                if (isset($employee_database[$entered_id])) {
                    if (password_verify($entered_password, $employee_database[$entered_id]["password"])) {
                        session_start();
                        $_SESSION['loggedin'] = 2;
                        $_SESSION['username'] = $entered_id;
                        echo "<p style='color:inherit;'>Successfully signed in!</p>";
                        echo "<p style='color:inherit;'><a href='./employeedashboard.php' style='text-decoration:underline;color:white;'>View Employee Dashboard</a></p>";
                    } else {
                        sleep(1); // Wait one second before showing the 'wrong password' message. This makes Marathon slightly more resistant to brute force attacks.
                        echo "<p style='color:red;'>Error: The password you entered is incorrect!</p>";
                        echo "<p style='color:inherit;'><a href='./employeelogin.php' style='text-decoration:underline;color:white;'>Back</a></p>";
                    }
                } else {
                    echo "<p style='color:red;'>Error: The employee ID number you entered does not exist in the employee database!</p>";
                    echo "<p style='color:inherit;'><a href='./employeelogin.php' style='text-decoration:underline;color:white;'>Back</a></p>";
                }
                echo "</div>";
                exit();
            }
            ?>
            <div class="container" style="padding-top:100px;">
                <main>
                    <a class="btn btn-primary" role="button" href="login.php" style="background-color:#444444;border-color:#eeeeee">Admin Login</a>
                    <div class="intro">
                        <p class="text-center" style="padding-bottom:54px;color:#dddddd;font-size:40px;">Employee Login</p>
                    </div>
                    <div style="background-color:#222222;border-radius:15px;margin-left:10%;margin-right:10%;padding:5%;color:white;text-align:center;">
                        <form method="POST">
                            <label for="id">ID Number:</label> <input name="id" type="number" placeholder="ID Number" required><br>
                            <label for="password">Password:</label> <input name="password" type="password" placeholder="Password/PIN" required><br>
                            <input type="submit">
                        </form>
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
