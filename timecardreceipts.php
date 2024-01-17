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

            include('./import_databases.php');

            foreach (array_reverse($timecard_database[$username], true) as $key => $element) { // Iterate over all of this user's shifts in the timecard database.
                if ($element["valid"] == true or $showinvalid == true) { // Check to see if this particular shift is valid.
                    if ($showinvalid == true and $element["valid"] == false) {
                        echo "<div class='horizontal-tile' style='border:10px solid #cc2222;'>";
                    } else if ($element["paidout"] == false) {
                        echo "<div class='horizontal-tile' style='border:10px solid #22cc22;'>";
                    } else {
                        echo "<div class='horizontal-tile'>";
                    }
                    echo "<p><b>Shift ID</b>: " . $key . "</p>";
                    if ($showinvalid == true and $element["valid"] == false) {
                        echo "<p style='color:red;'>Invalid</p>";
                    }
                    echo "<p><b>Start Time</b>: " . date("Y-m-d h:i:s", $element["timein"]) . "</p>";
                    echo "<p><b>End Time</b>: " . date("Y-m-d h:i:s", $element["timeout"]) . "</p>";
                    echo "<p><b>Hours</b>: " . (round((((int)$element["timeout"]-(int)$element["timein"])/3600)*10000)/10000) . "</p>";
                    echo "<p><b>Payrate</b>: " . $element["pay"] . " " . strtoupper($configuration_database["currency"]) . " per hour</p>";
                    echo "<p><b>Earnings</b>: " . ((round((((int)$element["timeout"]-(int)$element["timein"])/3600)*10000)/10000)*$element["pay"]) . " " . strtoupper($configuration_database["currency"]) . "</p>";

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
