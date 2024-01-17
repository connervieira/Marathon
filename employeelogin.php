<!-- V0LT - Marathon -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Marathon - Employee Login</title>

        <link rel="stylesheet" href="./assets/css/main.css">
    </head>
    <body>
        <div class="centered">
            <?php include('./import_databases.php'); ?>
        </div>
        <?php
        $entered_id = $_POST["id"];
        $entered_password = $_POST["password"];
        
        session_start(); // Start a PHP session.
        if ($_SESSION['authid'] == "marathon") { // Check to see if the user is already logged in.
            echo "
            <div class='centered'>
                <p style='color:red;'>Error: You are already signed in as " . $_SESSION['username'] . ".</p>
            </div>
            ";
            exit();
        }

        if ($entered_id !== null and $entered_id !== "") {
            echo "<div class='centered'>";
            if (isset($employee_database[$entered_id])) { // Check to make sure the username entered actually exists in the employee database.
                if (password_verify($entered_password, $employee_database[$entered_id]["password"])) { // Verify the password entered matches the password in the database.
                    session_start();
                    $_SESSION['loggedin'] = 2; // A logged in ID of 2 indicates that this user is an employee.
                    $_SESSION['authid'] = "marathon";
                    $_SESSION['username'] = $entered_id;
                    echo "<p style='color:inherit;'>Successfully signed in.</p>";
                    echo "<a href='./employeedashboard.php' class='button'>Continue</a></p>";
                } else {
                    sleep(1); // Wait one second before showing the 'wrong password' message. This makes Marathon slightly more resistant to brute force attacks.
                    echo "<p style='color:red;'>Error: The password you entered is incorrect.</p>";
                    echo "<a href='./employeelogin.php' class='button'>Back</a></p>";
                }
            } else {
                echo "<p style='color:red;'>Error: The employee ID number you entered does not exist in the employee database.</p>";
                echo "<a href='./employeelogin.php' class='button'>Back</a></p>";
            }
            echo "</div>";
            exit();
        }
        ?>
        <main>
            <a class="button" role="button" href="login.php">Admin Login</a>
            <div class="centered header">
                <h1>Marathon</h1>
                <h2>Employee Login</h2>
            </div>
            <form class="centered" method="POST">
                <label for="id">ID Number:</label> <input name="id" type="number" placeholder="ID Number" required><br>
                <label for="password">Password:</label> <input name="password" type="password" placeholder="Password/PIN" required><br>
                <input type="submit" value="Submit" class="button">
            </form>
        </main>
    </body>
</html>
