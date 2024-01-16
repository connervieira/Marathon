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

        <link rel="stylesheet" href="./assets/css/Projects-Clean.css">
        <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="./assets/css/main.css">
    </head>

    <body>
        <a class="button" role="button" href="tools.php">Back</a>
        <div class="centered header">
            <h1>Marathon</h1>
            <h2>All Shifts</h2>
        </div>
        <main class="centered">
            <?php
            if (isset($employee_id_to_mark) == true and isset($shift_id_to_mark) == true) { // Check to see if the user has clicked "Invalidate" on a particular shift
                if ($confirmation == true) { // Check to see if the user has clicked the "Confirm" button yet.
                    if (isset($timecard_database[$employee_id_to_mark][$shift_id_to_mark]) == true) { // Check to see if this shift exists
                        $timecard_database[$employee_id_to_mark][$shift_id_to_mark]["valid"] = false; // Mark this shift as invalid
                        file_put_contents($database_directory . '/timecarddatabase.txt', serialize($timecard_database)); // Write array changes to disk
                        echo "<p>This shift has been marked as invalid!</p>";
                        echo "<p><a href='allshifts.php'>Back</a></p>";
                    } else {
                        echo "<p style='color:red;'>Error: This shift doesn't appear to exist!</p>";
                    }
                } else {
                    echo "<p><a href='allshifts.php?employee=" . $employee_id_to_mark . "&shift=" . $shift_id_to_mark . "&confirmation=true'>Confirm</a></p>";
                    echo "<p><a href='allshifts.php'>Cancel</a></p>";
                }
                exit();
            }

            $anyone_has_valid_shifts = false;

            foreach ($employee_database as $key1 => $element1) {
                $employee_has_valid_shifts = false;
                foreach($timecard_database[$key1] as $element2) {
                    if ($element2["valid"] == true and isset($element2["timeout"])) {
                        $employee_has_valid_shifts = true;
                        $anyone_has_valid_shifts = true;
                    }
                }
                if ($employee_has_valid_shifts == true) {
                    echo "<hr class='separator-thick'>";
                    echo "<h3><a target='_blank' href='viewpaymentinformation.php?employee=" . $key1 . "'>" . $element1["firstname"] . " " . $element1["lastname"] . "'s</a> Valid Shifts</h3>";
                    $total_payment_owed = 0;
                    foreach($timecard_database[$key1] as $key2 => $element2) {
                        if ($element2["valid"] == true and isset($element2["timeout"]) and $element2["valid"] == true) {
                            echo "<hr class='separator-thin'>";
                            echo "<p><b>Shift ID</b>: " . $key2 . "</p>";
                            echo "<p><b>Start Time</b>: " . date("Y/m/d H:i:s", $element2["timein"]) . "</p>";
                            echo "<p><b>End Time</b>: " . date("Y/m/d H:i:s", $element2["timeout"]) . "</p>";

                            $hours_worked = round((($element2["timeout"] - $element2["timein"]) / 3600)*100000)/100000;
                            echo "<p><b>Time Worked</b>: " . $hours_worked . " hours</p>";

                            $payment_owed = $hours_worked * $element2["pay"];
                            $total_payment_owed = $total_payment_owed + $payment_owed;
                            echo "<p><b>Payment</b>: $" . $payment_owed . "</p>";
                            if ($element2["paidout"] == true) { echo "<p><b>Paid</b>: Yes</p>";
                            } else { echo "<p><b>Paid</b>: No</p>"; }
                            echo '<br><a class="button" role="button" href="allshifts.php?employee=' . $key1 . '&shift=' . $key2 . '">Mark As Invalid</a><br><br>';
                        }
                    }
                }
            }
            if ($anyone_has_valid_shifts == false) {
                echo "<p>There are currently no valid shifts!</p>";
            }
            echo "<br><br>";
            ?>
        </main>
    </body>
</html>
