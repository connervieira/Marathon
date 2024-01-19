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
            $employee_to_clockout = $_GET["clockout"];
            if (isset($employee_to_clockout)) { // Check to see if the variable to clock out a specific employee exists.
                ksort($timecard_database[$employee_to_clockout]); // Sort the employee's shifts by shift ID (such that more recent shifts are at the end).
                $most_recent_shift_id = array_reverse(array_keys($timecard_database[$employee_to_clockout]))[0]; // Get the ID of the last shift (the most recent shift).
                echo "<div class='centered'>";

                if (isset($timecard_database[$employee_to_clockout][$most_recent_shift_id]["timein"]) == true and isset($timecard_database[$employee_to_clockout][$most_recent_shift_id]["timeout"]) == false and $timecard_database[$employee_to_clockout][$most_recent_shift_id]["valid"] == true) { // Check to make sure this shift is actually still active.
                    if (strval($_GET["confirm"]) == "true") { // Check to see if the administrator has clicked the confirmation button.
                        $timecard_database[$employee_to_clockout][$most_recent_shift_id]["timeout"] = time(); // Set the end time of this shift to now.
                        save_database('timecarddatabase.json', $timecard_database); // Write array changes to disk.
                        echo "<p>" . $employee_database[$employee_to_clockout]["firstname"] . " " . $employee_database[$employee_to_clockout]["lastname"] . " has been clocked out. You may now want to invalidate this shift on the <a href='allshifts.php'>All Shifts</a> page to prevent it from being counted in statistics and payments.</p>";
                    } else { // If the confirmation button hasn't been clicked yet, then display the button and a prompt.
                        echo "<p>Are you sure you would like to manually clock out " . $employee_database[$employee_to_clockout]["firstname"] . " " . $employee_database[$employee_to_clockout]["lastname"] . "?</p>";
                        echo "<a class='button' href='?clockout=" . $employee_to_clockout . "&confirm=true'>Confirm</a>";
                    }
                } else {
                    echo "<p style='color:red;'>Error: This employee doesn't appear to be currently clocked in.</p>";
                }
                echo "<a class='button' href='openshifts.php'>Cancel</a>";
                echo "</div>";
                exit();
            }


            $open_shifts = array(); // This is an array that all currently open shifts will be added to.
            foreach($timecard_database as $employee_id => $employee) { // Iterate through each employee in the timecard database.
                ksort($employee);
                $most_recent_shift = array_reverse(array_keys($employee))[0];
                if (isset($employee[$most_recent_shift]["timein"]) == true and isset($employee[$most_recent_shift]["timeout"]) == false and $employee[$most_recent_shift]["valid"] == true) {
                    $open_shifts[$employee_id] = $employee[$most_recent_shift];
                }
            }

            if (sizeof($open_shifts) > 0) { // Check to see if there is at least one open shift.
                foreach ($open_shifts as $employee_id => $information) {
                    $shift_length = round(((time() - $information["timein"])/60/60)*1000)/1000;
                    echo "<p><b>" . $employee_database[$employee_id]["firstname"] . " " . $employee_database[$employee_id]["lastname"] . "</b> - " . $shift_length . " hours <a class='button' href='?clockout=" . $employee_id . "'>Clock Out</a></p>";
                }
            } else {
                echo "<p><i>There are currently no open shifts.</i></p>";
            }
            ?>
        </main>
    </body>
</html>
