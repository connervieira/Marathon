<!-- V0LT - Marathon -->
<?php
session_start(); // Start a PHP session.
if ($_SESSION['authid'] == "marathon" and $_SESSION['loggedin'] == 2) { // Check to see if the user is logged in.
    $username = (string)$_SESSION['username']; // Set the '$username' variable to the currently signed in user's username.
} else {
    header("Location: employeelogin.php"); // Redirect the user to the login page.
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Marathon - Employee Timecard</title>

        <link rel="stylesheet" href="./assets/css/main.css">
    </head>

    <body>
        <?php
        include('./import_databases.php');

        if (isset($timecard_database[$username]) == false) { // If the user doesn't exist in the timecard database, then add them as a blank placeholder.
            $timecard_database[$username] = array();
        }

        $clock_action = $_GET["clock"];

        if ($clock_action == "in" or $clock_action == "out" or $clock_action == "" or $clock_action == null) {
            if ($clock_action == "in") { // Clock the employee in
                if ($positions_database[$employee_database[$username]["positionid"]]["canclockin"] == "off") {
                    echo "<p style='color:red;'>Error: Your position isn't permitted to clock in! Please speak with your manager if you have any questions.</p>";
                    echo "<a class='button' href='timecard.php'>Back</a>";
                    exit();
                }
                if (isset($timecard_database[$username][key(array_slice($timecard_database[$username], -1, 1, true))]["timeout"]) == false and isset($timecard_database[$username][key(array_slice($timecard_database[$username], -1, 1, true))]["timein"]) == true) {
                    echo "<p style='color:red;'>Error: You appear to already be clocked in!</p>";
                    echo "<a class='button' href='timecard.php'>Back</a>";
                    exit();
                }
                $clock_record["valid"] = true;
                
                // Determine how much the employee should make per hour
                if ($employee_database[$username]["hourlypay"] > 0) { // If the employee's hourly pay is defined, then use that as their hourly pay.
                    $clock_record["pay"] = floatval($employee_database[$username]["hourlypay"]);
                    if ($clock_record["pay"] <= 0) {
                       echo "<p style='color:red;'>Please note: You are currently making $0 an hour. This is probably a configuration problem, and you should speak with your manager to get it fixed as soon as possible.</p>";
                    }
                } else if ((int)$positions_database[$employee_database[$username]["positionid"]]["defaultpayamount"] > 0) { // If the employee's hourly pay isn't defined, then use their position's default pay.
                    $clock_record["pay"] = floatval($positions_database[$employee_database[$username]["positionid"]]["defaultpayamount"]);
                    if ($clock_record["pay"] <= 0) {
                       echo "<p style='color:red;'>Please note: You are currently making $0 an hour. This is probably a configuration problem, and you should speak with your manager to get it fixed as soon as possible.</p>";
                    }
                } else { // Otherwise, default to $0 an hour and display a warning.
                   $clock_record["pay"] = 0;
                   echo "<p style='color:red;'>Please note: You are currently making $0 an hour. This is probably a configuration problem, and you should speak with your manager to get it fixed as soon as possible.</p>";
                }

                $clock_record["timein"] = time();
                $clock_record["paidout"] = false;
                if (isset($timecard_database[$username]) == false) {
                    $timecard_database[$username] = array();
                }
                array_push($timecard_database[$username], $clock_record);
                save_database('timecarddatabase.json', $timecard_database); // Write array changes to disk.
                echo "<p>You have successfully clocked in!</p>";
                echo "<p>You are earning $" .  $clock_record["pay"] . " per hour this shift</p>";
                echo "<a class='button' href='timecard.php'>Back</a>";
                exit();



            } elseif ($clock_action == "out") { // Clock the employee out
                if ((isset($timecard_database[$username][key(array_slice($timecard_database[$username], -1, 1, true))]["timeout"]) == true and isset($timecard_database[$username][key(array_slice($timecard_database[$username], -1, 1, true))]["timein"]) == true) or (isset($timecard_database[$username][key(array_slice($timecard_database[$username], -1, 1, true))]["timeout"]) == false and isset($timecard_database[$username][key(array_slice($timecard_database[$username], -1, 1, true))]["timein"]) == false)) {
                    echo "<p style='color:red;'>Error: You don't appear to be clocked in!</p>";
                    echo "<a class='button' href='timecard.php'>Back</a>";
                    exit();
                } else {
                    $timecard_database[$username][key(array_slice($timecard_database[$username], -1, 1, true))]["timeout"] = time();
                    save_database('timecarddatabase.json', $timecard_database); // Write array changes to disk.
                    echo "<p>You have successfully clocked out!</p>";
                    echo "<a class='button' href='timecard.php'>Back</a>";

                    $this_shift_data = $timecard_database[$username][key(array_slice($timecard_database[$username], -1, 1, true))];

                    echo "<br><br><br><p><b>Shift Statistics</b></p>";
                    echo "<p>Start Time: " . date("Y-m-d h:i:s", $this_shift_data["timein"]) . "</p>";
                    echo "<p>End Time: " . date("Y-m-d h:i:s", $this_shift_data["timeout"]) . "</p>";
                    echo "<p>Hours: " . (round((((int)$this_shift_data["timeout"]-(int)$this_shift_data["timein"])/3600)*10000)/10000) . "</p>";
                    echo "<p>Hourly Rate: " . $this_shift_data["pay"] . "</p>";
                    echo "<p>Earnings: " . ((round((((int)$this_shift_data["timeout"]-(int)$this_shift_data["timein"])/3600)*10000)/10000)*$this_shift_data["pay"]) . "</p>";

                    $raw_shift_data = "employee: " . $username . ", timein:" . $this_shift_data["timein"] . ", timeout:" . $this_shift_data["timeout"] . ", hourlypay:" . $this_shift_data["pay"];
                    echo "<br><p><b>Verification Data</b></p>";
                    echo "<p>The information below can be used to prove to your employer that you worked this shift.</p>";
                    if ($configuration_database["clockinverificationkey"] == "" or $configuration_database["clockinverificationkey"] == null) {
                        echo "<p style='color:red;'>Error: Your employer hasn't correctly configured their 'Clock In Verification Key'. Therefore, the shift verification information was unable to be generated.</p>";
                    } else {
                        $encrypted_verification_data = openssl_encrypt($raw_shift_data, "AES-128-CTR", $configuration_database["clockinverificationkey"], 0, "1");
                        echo "<p>" . $encrypted_verification_data . "</p>";
                        $decrypted_verification_data = openssl_decrypt($encrypted_verification_data, "AES-128-CTR", $configuration_database["clockinverificationkey"], 0, "1");
                        echo "<p>" . $decrypted_verification_data . "</p>";
                    }
                    exit();
                }
            }




        }
        ?>
        <a class="button" role="button" href="employeedashboard.php">Back</a>
        <main>
            <div class="centered header">
                <h1>Marathon</h1>
                <h2>Employee Timecard</h2>
            </div>
            <div class="centered">
                <?php
                if (isset($timecard_database[$username][key(array_slice($timecard_database[$username], -1, 1, true))]["timeout"]) == false and isset($timecard_database[$username][key(array_slice($timecard_database[$username], -1, 1, true))]["timein"]) == true) {
                    echo '<a class="button disabled" role="button" href="#">Already Clocked In</a>';
                } else {
                    echo '<a class="button" role="button" href="timecard.php?clock=in">Clock In</a>';
                }
                if ((isset($timecard_database[$username][key(array_slice($timecard_database[$username], -1, 1, true))]["timeout"]) == true and isset($timecard_database[$username][key(array_slice($timecard_database[$username], -1, 1, true))]["timein"]) == true) or (isset($timecard_database[$username][key(array_slice($timecard_database[$username], -1, 1, true))]["timeout"]) == false and isset($timecard_database[$username][key(array_slice($timecard_database[$username], -1, 1, true))]["timein"]) == false)) {
                    echo '<a class="button disabled" role="button" href="#">Not Clocked In</a>';
                } else {
                    echo '<a class="button" role="button" href="timecard.php?clock=out">Clock Out</a>';
                }
                ?>
            </div>
        </main>
    </body>
</html>
