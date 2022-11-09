<!-- V0LT - Marathon -->
<?php
session_start(); // Start a PHP session.
if ($_SESSION['loggedin'] == 1) { // Check to see if the user is logged in.
    $username = $_SESSION['username']; // Set the '$username' variable to the currently signed in user's username.
} else {
    header("Location: login.php"); // Redirect the user to the login page.
    exit();
}
$background_gradient_bottom = "#000000";
$background_gradient_top = "#444444";
?>
<!DOCTYPE html>
<html lang="en" style="background:<?php echo $background_gradient_bottom; ?>;">
    <head>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Marathon - Statistics</title>

        <link rel="stylesheet" href="./assets/css/Projects-Clean.css">
        <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css">
    </head>

    <body style="color:#111111;">
        <div class="projects-clean" style="background:linear-gradient(0deg, <?php echo $background_gradient_bottom; ?>, <?php echo $background_gradient_top; ?>);color:#111111;">
            <div class="container" style="padding-top:100px;">
                <div style="text-align:center;">
                    <?php
                    include('./import_databases.php');
                    ?>
                </div>
                <main>
                    <a class="btn btn-primary" role="button" href="index.php" style="background-color:#444444;border-color:#eeeeee">Back</a>
                    <div class="intro">
                        <p class="text-center" style="padding-bottom:54px;color:#dddddd;font-size:40px;">Statistics</p>
                    </div>
                    <div style="text-align:center;">
                        <?php
                        echo "<p style='color:white;' id='numberofemployees'>Number Of Employees: " . count($employee_database) . "</p>";
                        echo "<p style='color:white;' id='numberofpositions'>Number Of Positions: " . count($positions_database) . "</p>";

                        $total_shifts = 0;
                        foreach($timecard_database as $element1) {
                            foreach ($element1 as $element2) {
                                if ($element2["valid"] == true) {
                                    $total_shifts = $total_shifts + 1;
                                }
                            }
                        }
                        echo "<p style='color:white;' id='totalshiftsworked'>Total Shifts Worked: " . (string)$total_shifts . "</p>";

                        $total_payouts = 0.0;
                        foreach($timecard_database as $element1) {
                            foreach ($element1 as $element2) {
                                if (isset($element2["timeout"]) == true and $element2["valid"] == true) {
                                    $total_payouts = $total_payouts + ((float)$element2["pay"] * (((int)$element2["timeout"] - (int)$element2["timein"])/3600));
                                }
                            }
                        }
                        echo "<p style='color:white;' id='totalemployeepayoutamount'>Total Payouts: $" . (string)(round($total_payouts * 100000) / 100000) . "</p>";

                        $open_shifts = 0;
                        foreach($timecard_database as $element1) {
                            foreach ($element1 as $element2) {
                                if (isset($element2["timein"]) == true and isset($element2["timeout"]) == false and $element2["valid"] == true) {
                                    $open_shifts++;
                                }
                            }
                        }
                        echo "<p style='color:white;' id='currentlyopenshiftcount'>Currently Open Shifts: " . (string)$open_shifts . "</p>";


                        $unpaid_shifts = 0;
                        foreach ($employee_database as $key1 => $element1) { // Iterate through each employee in the database.
                            foreach($timecard_database[$key1] as $element2) { // Iterate through each of this employee's timecard receipts.
                                if ($element2["paidout"] != true and isset($element2["timeout"]) and $element2["valid"] == true) { // Check to see if this timecard receipt is valid, and if it has been paid out.
                                    $unpaid_shifts++;
                                }
                            }
                        }
                        echo "<p style='color:white;' id='unpaidshiftcount'>Unpaid Shifts: " . (string)$unpaid_shifts . "</p>";
                        ?>
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
