<!-- V0LT - Marathon -->
<?php
session_start(); // Start a PHP session.
if ($_SESSION['loggedin'] == 1) { // Check to see if the user is logged in.
    $username = $_SESSION['username']; // Set the '$username' variable to the currently signed in user's username.
} else {
    header("Location: login.php"); // Redirect the user to the login page.
    exit();
}
include('./import_databases.php');

$employee_id_to_mark = $_GET["employee"];
$shift_id_to_mark = $_GET["shift"];
$confirmation = $_GET["confirmation"];



$background_gradient_bottom = "#000000";
$background_gradient_top = "#444444";
?>
<!DOCTYPE html>
<html lang="en" style="background:<?php echo $background_gradient_bottom; ?>;">
    <head>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Marathon - Paid Shifts</title>

        <link rel="stylesheet" href="./assets/css/Projects-Clean.css">
        <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css">
    </head>

    <body style="color:#111111;">
        <div class="projects-clean" style="background:linear-gradient(0deg, <?php echo $background_gradient_bottom; ?>, <?php echo $background_gradient_top; ?>);color:#111111;">
            <div class="container" style="padding-top:100px;">
                <main>
                    <a class="btn btn-primary" role="button" href="tools.php" style="background-color:#444444;border-color:#eeeeee">Back</a>
                    <div class="intro">
                        <p class="text-center" style="padding-bottom:54px;color:#dddddd;font-size:40px;">Paid Shifts</p>
                    </div>
                    <div style="text-align:center;color:white;">
                    <?php
                        if (isset($employee_id_to_mark) == true and isset($shift_id_to_mark) == true) { // Check to see if the user has clicked "Mark As Paid Out" on a particular shift
                            if ($confirmation == true) { // Check to see if the user has clicked the "Confirm" button yet.
                                if (isset($timecard_database[$employee_id_to_mark][$shift_id_to_mark]) == true) { // Check to see if this shift exists.
                                    if ($timecard_database[$employee_id_to_mark][$shift_id_to_mark]["valid"] == true) { // Check to see if this shift is valid.
                                        $timecard_database[$employee_id_to_mark][$shift_id_to_mark]["paidout"] = false; // Mark this shift as not paid out.
                                        file_put_contents($database_directory . '/timecarddatabase.txt', serialize($timecard_database)); // Write array changes to disk.
                                        echo "<p>This shift has been marked as unpaid!</p>";
                                        echo "<p><a href='paidshifts.php'>Back</a></p>";
                                    } else {
                                        echo "<p style='color:red;'>Error: This shift doesn't appear to be valid!</p>";
                                    }
                                } else {
                                    echo "<p style='color:red;'>Error: This shift doesn't appear to exist!</p>";
                                }
                            } else {
                                echo "<p><a href='paidshifts.php?employee=" . $employee_id_to_mark . "&shift=" . $shift_id_to_mark . "&confirmation=true'>Confirm</a></p>";
                                echo "<p><a href='paidshifts.php'>Cancel</a></p>";
                            }
                            exit();
                        }

                        $anyone_has_paid_shifts = false;

                        foreach ($employee_database as $key1 => $element1) {
                            $employee_has_paid_shifts = false;
                            foreach($timecard_database[$key1] as $element2) {
                                if ($element2["paidout"] == true and isset($element2["timeout"]) and $element2["valid"] == true) {
                                    $employee_has_paid_shifts = true;
                                    $anyone_has_paid_shifts = true;
                                }
                            }
                            if ($employee_has_paid_shifts == true) {
                                echo "<p style='color:white;font-size:25px;'><a style='text-decoration:underline;color:white;' target='_blank' href='viewpaymentinformation.php?employee=" . $key1 . "'>" . $element1["firstname"] . " " . $element1["lastname"] . "'s</a> Paid Shifts</p>";
                                $total_payment_owed = 0;
                                foreach($timecard_database[$key1] as $key2 => $element2) {
                                    if ($element2["paidout"] == true and isset($element2["timeout"]) and $element2["valid"] == true) {
                                        echo "<p style='color:white;'><b>Shift ID</b>: " . $key2 . "</p>";
                                        echo "<p style='color:white;'><b>Start Time</b>: " . date("Y/m/d H:i:s", $element2["timein"]) . "</p>";
                                        echo "<p style='color:white;'><b>End Time</b>: " . date("Y/m/d H:i:s", $element2["timeout"]) . "</p>";

                                        $hours_worked = round((($element2["timeout"] - $element2["timein"]) / 3600)*100000)/100000;
                                        echo "<p style='color:white;'><b>Time Worked</b>: " . $hours_worked . " hours</p>";

                                        $payment_owed = $hours_worked * $element2["pay"];
                                        $total_payment_owed = $total_payment_owed + $payment_owed;
                                        echo "<p style='color:white;'><b>Payment</b>: $" . $payment_owed . "</p>";
                                        echo '<a class="btn btn-primary" role="button" href="paidshifts.php?employee=' . $key1 . '&shift=' . $key2 . '" style="background-color:#444444;border-color:#eeeeee">Mark As Unpaid</a>';
                                        echo "<br><br><br>";
                                        echo "<hr>";
                                    }
                                }
                                echo "<hr style='height:5px;border:none;color:#333;background-color:#333;'>";
                            }
                        }
                        if ($anyone_has_paid_shifts == false) {
                            echo "<p style='color:white;'>There are currently no paid shifts!</p>";
                        }
                        echo "<br><br>";
                        ?>
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
