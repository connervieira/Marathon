<!-- V0LT - Marathon -->
<?php
session_start(); // Start a PHP session.
if ($_SESSION['authid'] == "marathon" and $_SESSION['loggedin'] == 1) { // Check to see if the user is logged in.
    $username = $_SESSION['username']; // Set the '$username' variable to the currently signed in user's username.
} else {
    header("Location: login.php"); // Redirect the user to the login page.
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Marathon - Statistics</title>

        <link rel="stylesheet" href="./assets/css/main.css">
    </head>

    <body>
        <div class="centered">
            <?php
            include('./import_databases.php');
            include('./utils.php');
            ?>
        </div>
        <a class="button" role="button" href="index.php">Back</a>
        <div class="centered header">
            <h1>Marathon</h1>
            <h2>Statistics</h2>
        </div>
        <main>
            <?php
            $open_shifts = 0;
            foreach($timecard_database as $element1) {
                foreach ($element1 as $element2) {
                    if (isset($element2["timein"]) == true and isset($element2["timeout"]) == false and $element2["valid"] == true) {
                        $open_shifts++;
                    }
                }
            }
            echo "<p id='currentlyopenshiftcount'><b>Currently Open Shifts</b>: " . (string)$open_shifts . "</p>";


            $unpaid_shifts = 0;
            foreach ($employee_database as $key1 => $element1) { // Iterate through each employee in the database.
                foreach($timecard_database[$key1] as $element2) { // Iterate through each of this employee's timecard receipts.
                    if ($element2["paidout"] != true and isset($element2["timeout"]) and $element2["valid"] == true) { // Check to see if this timecard receipt is valid, and if it has been paid out.
                        $unpaid_shifts++;
                    }
                }
            }
            echo "<p id='unpaidshiftcount'><b>Unpaid Shifts</b>: " . (string)$unpaid_shifts . "</p>";


            echo "<br>";
            echo "<p id='numberofemployees'><b>Number Of Employees</b>: " . count($employee_database) . "</p>";
            echo "<p id='numberofpositions'><b>Number Of Positions</b>: " . count($positions_database) . "</p>";

            $total_shifts = 0;
            foreach($timecard_database as $element1) {
                foreach ($element1 as $element2) {
                    if ($element2["valid"] == true) {
                        $total_shifts = $total_shifts + 1;
                    }
                }
            }
            echo "<p id='totalshiftsworked'><b>Total Shifts Worked</b>: " . (string)$total_shifts . "</p>";

            $total_unpaid = 0.0;
            $total_paid = 0.0;
            $total_payouts = 0.0;

            foreach($timecard_database as $element1) {
                foreach ($element1 as $element2) {
                    if (isset($element2["timeout"]) == true and $element2["valid"] == true) {
                        $total_payouts += floatval($element2["pay"]) * (intval($element2["timeout"]) - intval($element2["timein"]))/3600;
                        if ($element2["paidout"] == true) {
                            $total_paid += floatval($element2["pay"]) * (intval($element2["timeout"]) - intval($element2["timein"]))/3600;
                        } else {
                            $total_unpaid += floatval($element2["pay"]) * (intval($element2["timeout"]) - intval($element2["timein"]))/3600;
                        }
                    }
                }
            }

            echo "<br>";
            echo "<p id='totalemployeepayoutamount'><b>Total Unpaid</b>: " . round_currency($total_unpaid) . " " . strtoupper($configuration_database["currency"]) . "</p>";
            echo "<p id='totalemployeepayoutamount'><b>Total Paid</b>: " . round_currency($total_paid) . " " . strtoupper($configuration_database["currency"]) . "</p>";
            echo "<p id='totalemployeepayoutamount'><b>Total Payouts</b>: " . round_currency($total_payouts) . " " . strtoupper($configuration_database["currency"]) . "</p>";
            ?>
        </main>
    </body>
</html>
