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

$employee_id_to_mark = $_GET["employee"];
$shift_id_to_mark = $_GET["shift"];
$confirmation = $_GET["confirmation"];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Marathon - All Shifts</title>

        <link rel="stylesheet" href="./assets/css/main.css">
    </head>

    <body>
        <a class="button" role="button" href="shifts.php">Back</a>
        <div class="centered header">
            <h1>Marathon</h1>
            <h2>All Shifts</h2>
            <p>This page shows all valid shifts, regardless of whether or not they have been paid out.</p>
        </div>
        <main>
            <?php
            if (isset($_GET["displayall"])) {
                echo "<div class='centered'>";
                echo "<p>Only displaying " . $employee_database[intval($_GET["displayall"])]["firstname"] . "'s shifts.</p>";
                echo "<a class='button' href='allshifts.php'>Reset</a>";
                echo "</div>";
            }
            if (isset($employee_id_to_mark) == true and isset($shift_id_to_mark) == true) { // Check to see if the user has clicked "Invalidate" on a particular shift
                echo "<div class='centered'>";
                if ($confirmation == true) { // Check to see if the user has clicked the "Confirm" button yet.
                    if (isset($timecard_database[$employee_id_to_mark][$shift_id_to_mark]) == true) { // Check to see if this shift exists
                        $timecard_database[$employee_id_to_mark][$shift_id_to_mark]["valid"] = false; // Mark this shift as invalid
                        save_database('timecarddatabase.json', $timecard_database); // Write array changes to disk.
                        echo "<p>This shift has been marked as invalid!</p>";
                        echo "<p><a class='button' href='allshifts.php'>Back</a></p>";
                    } else {
                        echo "<p style='color:red;'>Error: This shift doesn't appear to exist!</p>";
                    }
                } else {
                    echo "<p>Are you sure you would like to permanently invalidate this shift?</p>";
                    echo "<a class='button' href='allshifts.php?employee=" . $employee_id_to_mark . "&shift=" . $shift_id_to_mark . "&confirmation=true'>Confirm</a>";
                    echo "<a class='button' href='allshifts.php'>Cancel</a>";
                }
                echo "</div>";
                exit();
            }

            $anyone_has_valid_shifts = false;

            foreach ($employee_database as $key1 => $element1) {
                if (isset($_GET["displayall"]) and intval($key1) !== intval($_GET["displayall"])) { continue; }
                $employee_has_valid_shifts = false;
                foreach($timecard_database[$key1] as $element2) {
                    if ($element2["valid"] == true and isset($element2["timeout"])) {
                        $employee_has_valid_shifts = true;
                        $anyone_has_valid_shifts = true;
                    }
                }
                if ($employee_has_valid_shifts == true) {
                    echo "<div class='shift-collection'>";
                    echo "<hr class='separator-thick'>";
                    echo "<h3 id='" . $key1 . "'><a target='_blank' href='viewpaymentinformation.php?employee=" . $key1 . "'>" . $element1["firstname"] . " " . $element1["lastname"] . "'s</a> Valid Shifts</h3>";
                    $employee_shift_count = 0; // This will count the total number of valid shifts for this employee in the database.
                    $truncated_shifts = 0; // This variable will keep track of how many of this employees shifts were truncated by the "max shifts displayed" configuration value.
                    foreach(array_reverse($timecard_database[$key1], true) as $key2 => $element2) {
                        if ($element2["valid"] == true and isset($element2["timeout"])) {
                            $employee_shift_count+=1;
                            if ($employee_shift_count <= $configuration_database["maxshiftsdisplayed"] or intval($_GET["displayall"]) == intval($key1)) {
                                echo "<div class='shift-container'>";
                                echo "<p><b>Shift ID</b>: " . $key2 . "</p>";
                                echo "<p><b>Hourly Rate</b>: " . $element2["pay"] . " " . $configuration_database["currency"] . "</p>";
                                echo "<p><b>Start Time</b>: " . date("Y/m/d H:i:s", $element2["timein"]) . "</p>";
                                echo "<p><b>End Time</b>: " . date("Y/m/d H:i:s", $element2["timeout"]) . "</p>";

                                $hours_worked = round((($element2["timeout"] - $element2["timein"]) / 3600)*100000)/100000;
                                echo "<p><b>Time Worked</b>: " . $hours_worked . " hours</p>";

                                $payment_owed = $hours_worked * $element2["pay"];
                                echo "<p><b>Payment</b>: " . round_currency($payment_owed) . " " . $configuration_database["currency"] . "</p>";
                                if ($element2["paidout"] == true) { echo "<p><b>Paid</b>: Yes</p>";
                                } else { echo "<p><b>Paid</b>: No</p>"; }
                                echo '<br><a class="button" role="button" href="allshifts.php?employee=' . $key1 . '&shift=' . $key2 . '">Mark As Invalid</a><br><br>';
                                echo "</div>";
                            } else {
                                $truncated_shifts+=1;
                            }
                        }
                    }
                    echo "</div>";
                    echo "<div class='centered' style='clear:left;'>";
                    echo "<p>" . $element1["firstname"] . " " . $element1["lastname"] . " has worked " . $employee_shift_count . " shift"; if ($employee_shift_count > 1) { echo "s"; } echo ".</p>";
                    if ($truncated_shifts > 0) {
                        echo "<p><a href='?displayall=" . intval($key1) . "'>" . $truncated_shifts . " shift"; if ($truncated_shifts > 1) { echo "s were "; } else { echo " was "; } echo " truncated.</a></p>";
                    }
                    echo "</div>";
                }
            }
            if ($anyone_has_valid_shifts == false) {
                echo "<p class='centered'>There are currently no valid shifts!</p>";
            }
            echo "<br><br>";
            ?>
        </main>
    </body>
</html>
