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
        <title>Marathon - Paid Shifts</title>

        <link rel="stylesheet" href="./assets/css/main.css">
    </head>

    <body>
        <a class="button" role="button" href="shifts.php">Back</a>
        <div class="centered header">
            <h1>Marathon</h1>
            <h2>Paid Shifts</h2>
            <p>This page shows all valid shifts that have been already paid out.</p>
        </div>
        <main>
            <?php
            if (isset($_GET["displayall"])) {
                echo "<div class='centered'>";
                echo "<p>Only displaying " . $employee_database[intval($_GET["displayall"])]["firstname"] . "'s shifts.</p>";
                echo "<a class='button' href='paidshifts.php'>Reset</a>";
                echo "</div>";
            }
            if (isset($employee_id_to_mark) == true and isset($shift_id_to_mark) == true) { // Check to see if the user has clicked "Mark As Paid Out" on a particular shift
                echo "<div class='centered'>";
                if ($confirmation == true) { // Check to see if the user has clicked the "Confirm" button yet.
                    if (isset($timecard_database[$employee_id_to_mark][$shift_id_to_mark]) == true) { // Check to see if this shift exists.
                        if ($timecard_database[$employee_id_to_mark][$shift_id_to_mark]["valid"] == true) { // Check to see if this shift is valid.
                            $timecard_database[$employee_id_to_mark][$shift_id_to_mark]["paidout"] = false; // Mark this shift as not paid out.
                            file_put_contents($database_directory . '/timecarddatabase.txt', serialize($timecard_database)); // Write array changes to disk.
                            echo "<p>This shift has been marked as unpaid!</p>";
                            echo "<a class='button' href='paidshifts.php'>Back</a>";
                        } else {
                            echo "<p style='color:red;'>Error: This shift doesn't appear to be valid!</p>";
                        }
                    } else {
                        echo "<p style='color:red;'>Error: This shift doesn't appear to exist!</p>";
                    }
                } else {
                    echo "<p>Are you sure you would like to revert this shift to being unpaid? This should usually only be done if you accidentally marked a shift as paid before adding it to payroll.</p>";
                    echo "<a class='button' href='paidshifts.php?employee=" . $employee_id_to_mark . "&shift=" . $shift_id_to_mark . "&confirmation=true'>Confirm</a>";
                    echo "<a class='button' href='paidshifts.php'>Cancel</a>";
                }
                echo "</div>";
                exit();
            }

            $anyone_has_paid_shifts = false;

            foreach ($employee_database as $key1 => $element1) {
                if (isset($_GET["displayall"]) and intval($key1) !== intval($_GET["displayall"])) { continue; }
                $employee_has_paid_shifts = false;
                foreach($timecard_database[$key1] as $element2) {
                    if ($element2["paidout"] == true and isset($element2["timeout"]) and $element2["valid"] == true) {
                        $employee_has_paid_shifts = true;
                        $anyone_has_paid_shifts = true;
                    }
                }
                if ($employee_has_paid_shifts == true) {
                    echo "<div class='shift-collection'>";
                    echo "<hr class='separator-thick'>";
                    echo "<h3 id='" . $key1 . "'><a target='_blank' href='viewpaymentinformation.php?employee=" . $key1 . "'>" . $element1["firstname"] . " " . $element1["lastname"] . "'s</a> Paid Shifts</h3>";
                    $total_payment_owed = 0;
                    $employee_shift_count = 0;
                    $truncated_shifts = 0;
                    foreach($timecard_database[$key1] as $key2 => $element2) {
                        if ($element2["paidout"] == true and isset($element2["timeout"]) and $element2["valid"] == true) {
                            $employee_shift_count+=1;
                            $hours_worked = round((($element2["timeout"] - $element2["timein"]) / 3600)*100000)/100000;
                            $payment_owed = $hours_worked * $element2["pay"];
                            $total_payment_owed = $total_payment_owed + $payment_owed;
                            if ($employee_shift_count <= $configuration_database["maxshiftsdisplayed"] or $_GET["displayall"] == $key1) {
                                echo "<div class='shift-container'>";
                                echo "<p><b>Shift ID</b>: " . $key2 . "</p>";
                                echo "<p><b>Hourly Rate</b>: " . $element2["pay"] . " " . strtoupper($configuration_database["currency"]) . "</p>";
                                echo "<p><b>Start Time</b>: " . date("Y-m-d H:i:s", $element2["timein"]) . "</p>";
                                echo "<p><b>End Time</b>: " . date("Y-m-d H:i:s", $element2["timeout"]) . "</p>";

                                echo "<p><b>Time Worked</b>: " . $hours_worked . " hours</p>";

                                echo "<p><b>Payment</b>: " . round_currency($payment_owed) . " " . $configuration_database["currency"] . "</p>";
                                echo '<a class="button" role="button" href="paidshifts.php?employee=' . $key1 . '&shift=' . $key2 . '">Mark As Unpaid</a>';
                                echo "</div>";
                            } else {
                                $truncated_shifts+=1;
                            }
                        }
                    }
                    echo "</div>";
                    echo "<div class='centered' style='clear:left;'>";
                    echo "<p>" . $element1["firstname"] . " " . $element1["lastname"] . " has been paid for " . $employee_shift_count . " shift"; if ($employee_shift_count > 1) { echo "s"; } echo ".</p>";
                    if ($truncated_shifts > 0) {
                        echo "<p><a href='?displayall=" . intval($key1) . "'>" . $truncated_shifts . " shift"; if ($truncated_shifts > 1) { echo "s were "; } else { echo " was "; } echo " truncated.</a></p>";
                    }
                    echo "</div>";
                }
            }
            if ($anyone_has_paid_shifts == false) {
                echo "<p>There are currently no paid shifts!</p>";
            }
                ?>
        </main>
    </body>
</html>
