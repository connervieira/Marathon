<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Marathon - Remove Employee</title>
    </head>
    <body>
        <?php
        session_start(); // Start a PHP session.
        if ($_SESSION['loggedin'] == 1) { // Check to see if the user is logged in.
            $username = $_SESSION['username']; // Set the '$username' variable to the currently signed in user's username.
        } else {
            header("Location: login.php"); // Redirect the user to the login page.
            exit();
        }

        include("./import_databases.php");

        $id_to_delete = $_GET["id"];
        $confirmation = $_GET["confirmation"];

        if ($confirmation !== "true") { // If the user hasn't yet pressed 'Confirm', the display the 'Confirm' button.
            echo "<p>Confirm deletion</p>";
            echo "<p><a href='employeeremove.php?id=" . $id_to_delete . "&confirmation=true'>Confirm</a></p>";
            echo "<p><a href='employees.php'>Cancel</a></p>";
        } else { // Otherwise, delete the employee.
            unset($employee_database[$id_to_delete]); // Remove the employee from the database
            file_put_contents('./databases/employeedatabase.txt', serialize($employee_database)); // Write array changes to disk
            echo "<p>Employee deleted</p>";
            echo "<p><a href='employees.php'>Back</a></p>";
        }
        ?>
    </body>
</html>
