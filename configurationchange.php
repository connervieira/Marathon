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

if (strlen($currency) > 4) {
    echo "<p style='color:red;'>Error: 'Business Currency Symbol' should only be 4 characters or shorter.</p>";
    exit();

}


if ($disableadminsignups == "on" or $disableadminsignups == null or $disableadminsignups == "" or $disableadminsignups == "off") { // Check if 'Tips' is set to a valid value
    if ($disableadminsignups == "on") {
        $configuration_database["disableadminsignups"] = true;
    } else {
        $configuration_database["disableadminsignups"] = false;
    }
} else {
    echo "<p style='color:red;'>Error: 'Allow Admin Sign Ups' should only either be set to on or off.</p>";
    exit();
}
$configuration_database["clockinverificationkey"] = $clockinverificationkey;
$configuration_database["currency"] = filter_var($currency, FILTER_SANITIZE_STRING);

file_put_contents($database_directory . '/configurationdatabase.txt', serialize($configuration_database)); // Write array changes to disk

header("Location: configure.php");
exit();

?>
