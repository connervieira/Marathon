<!-- V0LT - Marathon -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Marathon - Admin Login</title>

        <link rel="stylesheet" href="./assets/css/main.css">
    </head>
    <body>
        <div class="centered">
            <?php include './import_databases.php'; ?>
        </div>
        <?php
        $entered_username = $_POST["username"];
        $entered_password = $_POST["password"];
        
        session_start(); // Start a PHP session.
        if (isset($_SESSION['loggedin'])) { // Check to see if the user is logged in.
            if ($_SESSION["authid"] == "marathon") {
                echo "
                <div class='centered'>
                    <p style='color:red;'>Error: You are already signed in as " . $_SESSION['username'] . ".</p>
                </div>
                ";
                exit();
            } else {
                echo "
                <div class='centered'>
                    <p style='color:red;'>Error: It appears the login session is broken. It's possible you're signed into DropAuth on this server as user '" . $_SESSION['username'] . "'. Please trying signing out of other accounts on this server, and retrying.</p>
                </div>
                ";
                exit();
            }
        }

        if ($entered_username !== null and $entered_username !== "") {
            echo "<div class='centered'>";
            if (isset($authentication_database[$entered_username])) {
                if (password_verify($entered_password, $authentication_database[$entered_username]["password"])) {
                    session_start();
                    $_SESSION['loggedin'] = 1;
                    $_SESSION['authid'] = "marathon";
                    $_SESSION['username'] = $entered_username;
                    echo "<p>Successfully signed in.</p>";
                    echo "<a href='./index.php' class='button'>Continue</a></p>";
                } else {
                    sleep(1); // Wait one second before showing the 'wrong password' message. This makes Marathon slightly more resistant to brute force attacks.
                    echo "<p style='color:red;'>Error: The password you entered is incorrect.</p>";
                    echo "<a href='login.php' class='button'>Back</a></p>";
                }
            } else {
                echo "<p style='color:red;'>Error: The username you entered does not exist in the account database.</p>";
                echo "<a href='login.php' class='button'>Back</a></p>";
            }
            echo "</div>";
            exit();
        }
        ?>
        <main>
            <a class="button" role="button" href="employeelogin.php">Employee Login</a>
            <div class="centered header">
                <h1>Admin Login</h1>
                <h2>Admin Login</h2>
            </div>
            <form class="centered" method="POST">
                <label for="username">Username:</label> <input name="username" type="text" placeholder="Username"><br>
                <label for="password1">Password:</label> <input name="password" type="password" placeholder="Password"><br>
                <input type="submit" value="Submit" class="button">
            </form>
        </main>
    </body>
</html>
