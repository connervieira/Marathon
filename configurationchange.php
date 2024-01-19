<?php
session_start(); // Start a PHP session.
if ($_SESSION['authid'] == "marathon" and $_SESSION['loggedin'] == 1) { // Check to see if the user is logged in.
    $username = $_SESSION['username']; // Set the '$username' variable to the currently signed in user's username.
} else {
    header("Location: login.php"); // Redirect the user to the login page.
    exit();
}
include("./import_databases.php");

// Grab variables from POST request
$disableadminsignups = $_POST["disableadminsignups"];
$clockinverificationkey = $_POST["clockinverificationkey"];
$currency = $_POST["currency"];
$maxshiftsdisplayed = intval($_POST["maxshiftsdisplayed"]);

if (strlen($currency) > 4) {
    echo "<p style='color:red;'>Error: 'Business Currency Symbol' should only be 4 characters or shorter.</p>";
    exit();

}

if ($maxshiftsdisplayed < 1) {
    echo "<p style='color:red;'>Error: 'Max Shifts Displayed' should be at least 1.</p>";
    exit();
} else if ($maxshiftsdisplayed > 1000) {
    echo "<p style='color:red;'>Error: 'Max Shifts Displayed' should be less than or equal to 1000.</p>";
    exit();
}

if ($disableadminsignups == "on" or $disableadminsignups == null or $disableadminsignups == "" or $disableadminsignups == "off") { // Check if 'Tips' is set to a valid value
    if ($disableadminsignups == "on") { $configuration_database["disableadminsignups"] = true;
    } else { $configuration_database["disableadminsignups"] = false; }
} else {
    echo "<p style='color:red;'>Error: 'Allow Admin Sign Ups' should only either be set to on or off.</p>";
    exit();
}
$configuration_database["clockinverificationkey"] = $clockinverificationkey;
$configuration_database["currency"] = filter_var($currency, FILTER_SANITIZE_STRING);
$configuration_database["maxshiftsdisplayed"] = $maxshiftsdisplayed;

save_database('configurationdatabase.json', $configuration_database); // Write array changes to disk.

header("Location: configure.php");
exit();

?>
