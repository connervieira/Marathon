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
include('./utils.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Marathon - Open Shifts</title>

        <link rel="stylesheet" href="./assets/css/main.css">
    </head>

    <body>
        <a class="button" role="button" href="shifts.php">Back</a>
        <div class="centered header">
            <h1>Marathon</h1>
            <h2>Open Shifts</h2>
            <p>This page displays all employees who are currently clocked in. These shifts are considered incomplete, and will not be displayed anywhere else until they have been clocked out.</p>
        </div>
        <main>
            <?php
            $open_shifts = array(); // This is an array that all currently open shifts will be added to.

            foreach($timecard_database as $employee_id => $employee) { // Iterate through each employee in the timecard database.
                ksort($employee);
                $most_recent_shift = array_reverse(array_keys($employee))[0];
                if (isset($employee[$most_recent_shift]["timein"]) == true and isset($employee[$most_recent_shift]["timeout"]) == false and $employee[$most_recent_shift]["valid"] == true) {
                    $open_shifts[$employee_id] = $employee[$most_recent_shift];
                }
            }

            foreach ($open_shifts as $employee_id => $information) {
                $shift_length = round(((time() - $information["timein"])/60/60)*1000)/1000;
                echo "<p><b>" . $employee_database[$employee_id]["firstname"] . " " . $employee_database[$employee_id]["lastname"] . "</b> - " . $shift_length . " hours</p>";
            }
            ?>
        </main>
    </body>
</html>
