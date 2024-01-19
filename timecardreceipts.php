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
        <title>Marathon - Timecard Receipts</title>

        <link rel="stylesheet" href="./assets/css/main.css">
    </head>

    <body>
        <a class="button" role="button" href="employeedashboard.php">Back</a>
        <div class="centered header">
            <h1>Marathon</h1>
            <h2>Timecard Receipts</h2>
            <?php
            $showinvalid = $_GET["showinvalid"];
            if ($showinvalid == "true") { $showinvalid = true;
            } else { $showinvalid = false; }
            if ($showinvalid == true) { echo '<a class="button" role="button" href="timecardreceipts.php?showinvalid=false">Hide Invalid Shifts</a></div>';
            } else { echo '<a class="button" role="button" href="timecardreceipts.php?showinvalid=true">Show Invalid Shifts</a></div>'; }
            ?>
        </div>
        <main>
            <?php
            include('./utils.php');
            include('./import_databases.php');

            foreach (array_reverse($timecard_database[$username], true) as $key => $element) { // Iterate over all of this user's shifts in the timecard database.
                if ($element["valid"] == true or $showinvalid == true) { // Check to see if this particular shift is valid.
                    if (isset($element["timein"]) == true and isset($element["timeout"]) == false and $element["valid"] == true) { // Check to see if this shift is still open.
                        echo "<div class='horizontal-tile' style='border:10px solid #cccc22;'>";
                        echo "<p style='color:yellow;'>Active</p>";
                        $element["timeout"] = time();
                    } else if ($showinvalid == true and $element["valid"] == false) { // Check to see if this shift is invalid.
                        echo "<div class='horizontal-tile' style='border:10px solid #cc2222;'>";
                        echo "<p style='color:red;'>Invalid</p>";
                    } else if ($element["paidout"] == false) { // Check to see if this shift hasn't yet been paid out.
                        echo "<div class='horizontal-tile' style='border:10px solid #22cc22;'>";
                        echo "<p style='color:lime;'>Unpaid</p>";
                    } else {
                        echo "<div class='horizontal-tile'>";
                    }
                    $hours_worked = round(intval($element["timeout"])-intval($element["timein"]))/3600;
                    $hours_worked = round($hours_worked*10000)/10000;
                    if (intval($element["timeout"]) < -intval($element["timein"])) { // Check to see if the number of hours worked is negative.
                        echo "<p>The clock out time is <b>before</b> the clock out time. This means something has gone very wrong!</p>";
                    }
                    echo "<p><b>Shift ID</b>: " . $key . "</p>";
                    echo "<p><b>Start Time</b>: " . date("Y-m-d H:i:s", $element["timein"]) . "</p>";
                    echo "<p><b>End Time</b>: " . date("Y-m-d H:i:s", $element["timeout"]) . "</p>";
                    echo "<p><b>Hours</b>: " . $hours_worked . "</p>";
                    echo "<p><b>Payrate</b>: " . $element["pay"] . " " . strtoupper($configuration_database["currency"]) . " per hour</p>";
                    echo "<p><b>Earnings</b>: " . round_currency($hours_worked*$element["pay"]) . " " . strtoupper($configuration_database["currency"]) . "</p>";

                    // Display verification data
                    $raw_shift_data = "employee: " . $username . ", timein:" . $element["timein"] . ", timeout:" . $element["timeout"] . ", hourlypay:" . $element["pay"]; // Generate the raw shift data to be encrypted with the shift verification key.
                    echo "<br><p><b>Verification Data</b></p>";
                    echo "<p>The information below can be used to prove to your employer that you worked this shift.</p>";
                    if ($configuration_database["clockinverificationkey"] == "" or $configuration_database["clockinverificationkey"] == null) { // Check to see if the shift verification key was left blank.
                        echo "<p style='color:red;'>Error: Your employer hasn't correctly configured their 'Clock In Verification Key'. Therefore, the shift verification information was unable to be generated.</p>";
                    } else {
                        $encrypted_verification_data = openssl_encrypt($raw_shift_data, "AES-128-CTR", $configuration_database["clockinverificationkey"], 0, "1"); // Encrypt the raw shift data using the employer's verification key.
                        echo "<p style='line-break:anywhere;color:gray;'>" . $encrypted_verification_data . "</p>"; // Display the encrypted hash.
                        $decrypted_verification_data = openssl_decrypt($encrypted_verification_data, "AES-128-CTR", $configuration_database["clockinverificationkey"], 0, "1"); // Decrypt the raw data just encrypted, and re-display the raw data in plain text again. If all goes to plan, this should be identical to the raw data before encryption. Otherwise, something has gone wrong.
                        echo "<p style='color:gray;'>" . $decrypted_verification_data . "</p>"; // Display the raw shift data decrypted from the hash.
                    }
                    echo "</div><br><br>";
                }
            }
            ?>
        </main>
    </body>
</html>
