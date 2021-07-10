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
$firstname = $_POST["firstname"];
$middlename = $_POST["middlename"];
$lastname = $_POST["lastname"];
$positionid = $_POST["positionid"];
$hourlypay = $_POST["hourlypay"];
$gender = $_POST["gender"];
$birthday = $_POST["birthday"];
$phone = $_POST["phone"];
$email = $_POST["email"];
$instantmessage = $_POST["instantmessage"];
$address = $_POST["address"];
$ssn = $_POST["ssn"];
$password = $_POST["password"];
$tips = $_POST["tips"];
$paymentinfo = $_POST["paymentinfo"];

$employee_information = array(); // Create empty array to store this employee's information.


// Make sure required fields have been filled out.
if ($firstname == "" or $firstname == null) {
    echo "<p style='color:red;'>Error: 'First Name' is a required field, but it was left empty!</p>";
    exit();
}
if ($password == "" or $password == null) {
    echo "<p style='color:red;'>Error: 'Employee Password/PIN' is a required field, but it was left empty!</p>";
    exit();
}
if ($positionid == "" or $positionid == null) {
    echo "<p style='color:red;'>Error: 'Position ID' is a required field, but it was left empty!</p>";
    exit();
}


if ($id == "" or $id == null) { // If the ID field was left blank, we'll need to generate one.
    while (true) { // Run forever, until a unique ID is generated.
        $id = rand(100000, 999999); // Generate a random ID.

        // Check to see if the randomly selected ID already exists in the database.
        $id_already_exists = false;
        foreach ($employee_database as $key => $element) { 
            if ($id == $key) {
                $key_already_exists = true;
            }
        }
        if ($key_already_exists == false) { // If no matching ID was found, break the loop.
            break;
        }
    }
}


// Check to make sure the submitted Employee ID number is actually a number.
if (is_numeric($id) == false) {
    echo "<p style='color:red;'>Error: 'Employee ID' should be a number, but it appears to be a string!</p>";
    exit();
}

// Sanitize all inputs then add them to the array for this employee's information.
$employee_information["firstname"] = filter_var($firstname, FILTER_SANITIZE_STRING);
$employee_information["middlename"] = filter_var($middlename, FILTER_SANITIZE_STRING);
$employee_information["lastname"] = filter_var($lastname, FILTER_SANITIZE_STRING);
$employee_information["positionid"] = filter_var($positionid, FILTER_SANITIZE_NUMBER_INT);
$employee_information["hourlypay"] = filter_var($hourlypay, FILTER_SANITIZE_NUMBER_FLOAT);
$employee_information["gender"] = filter_var($gender, FILTER_SANITIZE_STRING);
$employee_information["birthday"] = filter_var($birthday, FILTER_SANITIZE_NUMBER_INT);
$employee_information["phone"] = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
$employee_information["email"] = filter_var($email, FILTER_SANITIZE_EMAIL);
$employee_information["instantmessage"] = filter_var($instantmessage, FILTER_SANITIZE_STRING);
$employee_information["address"] = filter_var($address, FILTER_SANITIZE_STRING);
$employee_information["ssn"] = filter_var($ssn, FILTER_SANITIZE_NUMBER_INT);
$employee_information["password"] = password_hash($password, PASSWORD_DEFAULT);
$employee_information["paymentinfo"] = filter_var($paymentinfo, FILTER_SANITIZE_STRING);
if ($tips == "on" or $tips == null or $tips == "" or $tips == "off") { // Check if 'Tips' is set to a valid value
    if ($tips == "on") {
        $employee_information["tips"] = "on";
    } else {
        $employee_information["tips"] = "off";
    }
} else {
    echo "<p style='color:red;'>Error: 'Tips' should only either be set to on or off.</p>";
    exit();
}

$employee_database[$id] = $employee_information; // Add the employee's database to the database under their ID
file_put_contents('./databases/employeedatabase.txt', serialize($employee_database)); // Write array changes to disk

header("Location: employees.php");
exit();

?>
