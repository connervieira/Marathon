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
$id = $_POST["id"];
$name = $_POST["name"];
$defaultpayamount= $_POST["defaultpayamount"];
$canclockin = $_POST["canclockin"];
$description = $_POST["description"];

$position_information = array(); // Create empty array to store this position's information.


// Make sure required fields have been filled out.
if ($name == "" or $name == null) {
    echo "<p style='color:red;'>Error: 'Name' is a required field, but it was left empty!</p>";
    exit();
}

if ($id == "" or $id == null) { // If the ID field was left blank, we'll need to generate one.
    while (true) { // Run forever, until a unique ID is generated.
        $id = rand(100000, 999999); // Generate a random ID.

        // Check to see if the randomly selected ID already exists in the database.
        $id_already_exists = false;
        foreach ($position_database as $key => $element) { 
            if ($id == $key) {
                $key_already_exists = true;
            }
        }
        if ($key_already_exists == false) { // If no matching ID was found, break the loop.
            break;
        }
    }
}

// Check to make sure the submitted Position ID number is actually a number.
if (is_numeric($id) == false) {
    echo "<p style='color:red;'>Error: 'Position ID' should be a number, but it appears to be a string!</p>";
    exit();
}


// Sanitize all inputs then add them to the array for this position's information.
$position_information["name"] = filter_var($name, FILTER_SANITIZE_STRING);
$position_information["defaultpayamount"] = filter_var($defaultpayamount, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$position_information["description"] = filter_var($description, FILTER_SANITIZE_STRING);
if ($canclockin == "on" or $canclockin == null or $canclockin == "" or $canclockin == "off") {
    if ($canclockin == "on") {
        $position_information["canclockin"] = "on";
    } else {
        $position_information["canclockin"] = "off";
    }
} else {
    echo "<p style='color:red;'>Error: 'Can Clock In' should only either be set to on or off.</p>";
    exit();
}

$position_database[$id] = $position_information; // Add the position's database to the database under its ID
file_put_contents('./databases/positiondatabase.txt', serialize($position_database)); // Write array changes to disk

header("Location: positions.php");
exit();

?>
