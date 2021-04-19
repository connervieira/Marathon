<?php
session_start(); // Start a PHP session.
if ($_SESSION['loggedin'] == 1) { // Check to see if the user is logged in.
    $username = $_SESSION['username']; // Set the '$username' variable to the currently signed in user's username.
} else {
    header("Location: login.php"); // Redirect the user to the login page.
    exit();
}
include("./import_databases.php");

// Grab variables from POST request
$disableadminsignups = $_POST["disableadminsignups"];


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

file_put_contents('./databases/configurationdatabase.txt', serialize($configuration_database)); // Write array changes to disk

header("Location: configure.php");
exit();

?>
