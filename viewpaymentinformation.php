<!-- V0LT - Marathon -->
<?php
session_start(); // Start a PHP session.
if ($_SESSION['authid'] == "marathon" and $_SESSION['loggedin'] == 1) { // Check to see if the user is logged in.
    $username = $_SESSION['username']; // Set the '$username' variable to the currently signed in user's username.
} else {
    header("Location: login.php"); // Redirect the user to the login page.
    exit();
}
include('./import_databases.php');

$employee_to_view = $_GET["employee"];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Marathon - View Payment Information</title>

        <link rel="stylesheet" href="./assets/css/main.css">
    </head>

    <body>
        <a class="button" role="button" href="tools.php">Back</a>
        <div class="centered header">
            <h1>Marathon</h1>
            <h2>View Payment Information</h2>
        </div>
        <main>
            <?php
            if ($employee_to_view != null and $employee_to_view != "") { // Check if the user as selected an employee to view.
                echo "
                <form>
                    <label for='employee'>Employee ID: </label><input name='employee' type='text' placeholder='Employee ID'>
                </form>
                ";
                if (isset($employee_database[$employee_to_view]) == true) { // Check if the employee exists.
                    if ($employee_database[$employee_to_view]["paymentinfo"] !== "" and $employee_database[$employee_to_view]["paymentinfo"] !== null) { // Check if the selected employee has payment information on file.
                        echo "<h3>" . $employee_database[$employee_to_view]["firstname"] . " " . $employee_database[$employee_to_view]["lastname"] . "'s Payment Information</h3>";
                        echo "<p style='white-space:pre-line;'>" . $employee_database[$employee_to_view]["paymentinfo"] . "</p>";
                    } else {
                        echo "<p style='color:red;'>Error: The selected employee doesn't have any payment information on file.</p>";
                    }
                } else {
                    echo "<p style='color:red;'>Error: There is no employee with the specified employee ID.</p>";
                }
            } else {
                echo "
                <form>
                    <label for='employee'>Employee ID: </label><input name='employee' type='text' placeholder='Employee ID'>
                </form>
                ";
            }
            ?>
        </main>
    </body>
</html>
