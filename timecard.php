<!-- V0LT - Marathon -->
<?php
session_start(); // Start a PHP session.
if ($_SESSION['loggedin'] == 2) { // Check to see if the user is logged in.
    $username = (string)$_SESSION['username']; // Set the '$username' variable to the currently signed in user's username.
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
        <title>Marathon - Employee Timecard</title>

        <link rel="stylesheet" href="./assets/css/Projects-Clean.css">
        <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css">
    </head>

    <body style="color:#111111;">
        <div class="projects-clean" style="background:linear-gradient(0deg, <?php echo $background_gradient_bottom; ?>, <?php echo $background_gradient_top; ?>);color:#111111;">
            <?php
            include('./import_databases.php');

            $clock_action = $_GET["clock"];

            if ($clock_action == "in" or $clock_action == "out" or $clock_action == "" or $clock_action == null) {
                if ($clock_action == "in") { // Clock the employee in
                    if (isset($timecard_database[$username][key(array_slice($timecard_database[$username], -1, 1, true))]["timeout"]) == false and isset($timecard_database[$username][key(array_slice($timecard_database[$username], -1, 1, true))]["timein"]) == true) {
                        echo "<p style='color:red;'>Error: You appear to already be clocked in!</p>";
                        echo "<a href='timecard.php' style='color:white;text-decoration:underline;'>Back</a>";
                        exit();
                    }
                    $clock_record["valid"] = true;
                    
                    // Determine how much the employee should make per hour
                    if ($employee_database[$username]["hourlypay"] > 0) { // If the employee's hourly pay is defined, then use that as their hourly pay.
                        $clock_record["pay"] = $employee_database[$username]["hourlypay"];
                    } else if ((int)$positions_database[$employee_database[$username]["positionid"]]["defaultpayamount"] > 0) { // If the employee's hourly pay isn't defined, then use their position's default pay.
                        $clock_record["pay"] = $positions_database[$employee_database[$username]["positionid"]]["defaultpayamount"];
                    } else { // Otherwise, default to $0 an hour and display a warning.
                       $clock_record["pay"] = 0;
                       echo "<p style='color:white;'>Please note: You are currently making $0 an hour. This is probably a configuration problem, and you should speak with your manager to get it fixed as soon as possible.</p>";
                    }

                    $clock_record["timein"] = time();
                    if (isset($timecard_database[$username]) == false) {
                        $timecard_database[$username] = array();
                    }
                    array_push($timecard_database[$username], $clock_record);
                    file_put_contents('./databases/timecarddatabase.txt', serialize($timecard_database)); // Write array changes to disk
                    echo "<p style='color:white;'>You have successfully clocked in!</p>";
                    echo "<p style='color:white;'>You are earning $" .  $clock_record["pay"] . " per hour this shift</p>";
                    echo "<a href='timecard.php' style='color:white;text-decoration:underline;'>Back</a>";
                    exit();



                } elseif ($clock_action == "out") { // Clock the employee out
                    if ((isset($timecard_database[$username][key(array_slice($timecard_database[$username], -1, 1, true))]["timeout"]) == true and isset($timecard_database[$username][key(array_slice($timecard_database[$username], -1, 1, true))]["timein"]) == true) or (isset($timecard_database[$username][key(array_slice($timecard_database[$username], -1, 1, true))]["timeout"]) == false and isset($timecard_database[$username][key(array_slice($timecard_database[$username], -1, 1, true))]["timein"]) == false)) {
                        echo "<p style='color:red;'>Error: You don't appear to be clocked in!</p>";
                        echo "<a href='timecard.php' style='color:white;text-decoration:underline;'>Back</a>";
                        exit();
                    } else {
                        $timecard_database[$username][key(array_slice($timecard_database[$username], -1, 1, true))]["timeout"] = time();
                        file_put_contents('./databases/timecarddatabase.txt', serialize($timecard_database)); // Write array changes to disk
                        echo "<p style='color:white;'>You have successfully clocked out!</p>";
                        echo "<a href='timecard.php' style='color:white;text-decoration:underline;'>Back</a>";

                        $this_shift_data = $timecard_database[$username][key(array_slice($timecard_database[$username], -1, 1, true))];

                        echo "<br><br><br><p style='color:white;'><b>Shift Statistics</b></p>";
                        echo "<p style='color:white;'>Start time: " . date("Y-m-d h:i:s", $this_shift_data["timein"]) . "</p>";
                        echo "<p style='color:white;'>End time: " . date("Y-m-d h:i:s", $this_shift_data["timeout"]) . "</p>";
                        echo "<p style='color:white;'>Hours worked: " . (round((((int)$this_shift_data["timeout"]-(int)$this_shift_data["timein"])/3600)*10000)/10000) . "</p>";
                        echo "<p style='color:white;'>Hourly pay: " . $this_shift_data["pay"] . "</p>";
                        echo "<p style='color:white;'>Money earned:" . ((round((((int)$this_shift_data["timeout"]-(int)$this_shift_data["timein"])/3600)*10000)/10000)*$this_shift_data["pay"]) . "</p>";

                        $raw_shift_data = "timein:" . $this_shift_data["timein"] . ", timeout:" . $this_shift_data["timeout"] . ", hourlypay:" . $this_shift_data["pay"];
                        echo "<p style='color:white;'><b>Verification Data</b></p>";
                        echo "<p style='color:white;'>The information below can be used to prove to your employer that you worked this shift.</p>";
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
            <div class="container" style="padding-top:100px;">
                <a class="btn btn-primary" role="button" href="employeedashboard.php" style="background-color:#444444;border-color:#eeeeee">Back</a>
                <main>
                    <div class="intro">
                        <h2 class="text-center" style="color:#dddddd">Marathon</h2>
                        <p class="text-center" style="padding-bottom:54px;color:#dddddd;font-size:25px;">Employee Timecard</p>
                    </div>
                    <div class="row projects" style="padding-left:5%;padding-right:5%;color:white;">
                        <div class="col-sm-6 col-lg-4 item" style="margin:0;border-radius:15px;">
                            <h3>Clock In</h3>
                            <?php
                            if (isset($timecard_database[$username][key(array_slice($timecard_database[$username], -1, 1, true))]["timeout"]) == false and isset($timecard_database[$username][key(array_slice($timecard_database[$username], -1, 1, true))]["timein"]) == true) {
                                echo '<a class="btn btn-primary" role="button" href="#" style="background-color:#222222;border-color:#eeeeee;color:#888888;">Already Clocked In</a>';
                            } else {
                                echo '<a class="btn btn-primary" role="button" href="timecard.php?clock=in" style="background-color:#444444;border-color:#eeeeee">Open</a>';
                            }
                            ?>
                        </div>
                        <div class="col-sm-6 col-lg-4 item" style="margin:0;border-radius:15px;">
                            <h3>Clock Out</h3>
                            <?php
                            if ((isset($timecard_database[$username][key(array_slice($timecard_database[$username], -1, 1, true))]["timeout"]) == true and isset($timecard_database[$username][key(array_slice($timecard_database[$username], -1, 1, true))]["timein"]) == true) or (isset($timecard_database[$username][key(array_slice($timecard_database[$username], -1, 1, true))]["timeout"]) == false and isset($timecard_database[$username][key(array_slice($timecard_database[$username], -1, 1, true))]["timein"]) == false)) {
                                echo '<a class="btn btn-primary" role="button" href="#" style="background-color:#222222;border-color:#eeeeee;color:#888888;">Not Clocked In</a>';
                            } else {
                                echo '<a class="btn btn-primary" role="button" href="timecard.php?clock=out" style="background-color:#444444;border-color:#eeeeee">Open</a>';
                            }
                            ?>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
