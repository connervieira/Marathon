<?php
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
