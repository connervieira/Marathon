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
        <title>Marathon - Timecard Receipts</title>

        <link rel="stylesheet" href="./assets/css/Projects-Clean.css">
        <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css">
    </head>

    <body style="color:#111111;">
        <div class="projects-clean" style="background:linear-gradient(0deg, <?php echo $background_gradient_bottom; ?>, <?php echo $background_gradient_top; ?>);color:#111111;">
            <div class="container" style="padding-top:100px;">
                <a class="btn btn-primary" role="button" href="employeedashboard.php" style="background-color:#444444;border-color:#eeeeee">Back</a>
                <main>
                    <div class="intro">
                        <h2 class="text-center" style="color:#dddddd">Marathon</h2>
                        <p class="text-center" style="padding-bottom:54px;color:#dddddd;font-size:25px;">Timecard Receipts</p>
                    </div>
                    <?php
                    include('./import_databases.php');

                    foreach ($timecard_database[$username] as $key => $element) {
                        echo "<div style='background:#222222;padding:30px;border-radius:15px;'>";
                        echo "<p style='color:white;font-size:20px;'><b>Shift ID</b>: " . $key . "</p>";
                        echo "<p style='color:white;'>Start time: " . date("Y-m-d h:i:s", $element["timein"]) . "</p>";
                        echo "<p style='color:white;'>End time: " . date("Y-m-d h:i:s", $element["timeout"]) . "</p>";
                        echo "<p style='color:white;'>Hours worked: " . (round((((int)$element["timeout"]-(int)$element["timein"])/3600)*10000)/10000) . "</p>";
                        echo "<p style='color:white;'>Hourly pay: " . $element["pay"] . "</p>";
                        echo "<p style='color:white;'>Money earned: " . ((round((((int)$element["timeout"]-(int)$this_shift_data["timein"])/3600)*10000)/10000)*$element["pay"]) . "</p>";

                        // Display verification data
                        $raw_shift_data = "employee: " . $username . ", timein:" . $element["timein"] . ", timeout:" . $element["timeout"] . ", hourlypay:" . $element["pay"];
                        echo "<br><p style='color:white;'><b>Verification Data</b></p>";
                        echo "<p style='color:white;'>The information below can be used to prove to your employer that you worked this shift.</p>";
                        if ($configuration_database["clockinverificationkey"] == "" or $configuration_database["clockinverificationkey"] == null) {
                            echo "<p style='color:red;'>Error: Your employer hasn't correctly configured their 'Clock In Verification Key'. Therefore, the shift verification information was unable to be generated.</p>";
                        } else {
                            $encrypted_verification_data = openssl_encrypt($raw_shift_data, "AES-128-CTR", $configuration_database["clockinverificationkey"], 0, "1");
                            echo "<p>" . $encrypted_verification_data . "</p>";
                            $decrypted_verification_data = openssl_decrypt($encrypted_verification_data, "AES-128-CTR", $configuration_database["clockinverificationkey"], 0, "1");
                            echo "<p>" . $decrypted_verification_data . "</p>";
                        }
                        echo "</div><br><br>";
                    }
                    ?>
                </main>
            </div>
        </div>
    </body>
</html>
