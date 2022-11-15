<?php

$database_directory = "/var/www/protected/marathondatabases/"; // This specifies where Marathon will create and store it's databases.



// Define function to check if a database exists and load it if it does.
function load_database($directory, $database_to_load) {
    if (file_exists($directory)) { // Check to make sure the database directory exists.
        if (is_writable($directory)) { // Check to make sure the database directory is writable.
            if (!file_exists($directory . "/" . $database_to_load)) {  // Check to see if the database file doesn't exists.
                file_put_contents($directory . "/" . $database_to_load, "a:0:{}"); // Save a blank placeholder to the database file.
            }
            if (file_exists($directory . "/" . $database_to_load)) {  // Check to see if the database file exists. It should have been created in a previous step if not.
                return unserialize(file_get_contents($directory . "/" . $database_to_load)); // Load the database.
                if (is_writable($directory . "/" . $database_to_load)) { // Check to make sure the database itself is writable.
                    echo "<p style='color:red;'>Error: The database '" . $database_to_load . "' is not writable.</p>"; // Alert that the database is not writable.
                }
            } else {
                echo "<p style='color:red;'>Error: Could not load database '" . $database_to_load . "'. The database file was not found.</p>"; // Alert that the database couldn't be opened.
            }
        } else {
            echo "<p style='color:red;'>Error: Could not load database '" . $database_to_load . "'. The database directory is not writable.</p>"; // Alert that the database couldn't be opened.
        }
    } else {
        echo "<p style='color:red;'>Error: Could not load database '" . $database_to_load . "'. The database directory does not exist.</p>"; // Alert that the database couldn't be opened.
    }
}

// Load all required databases
$timecard_database = load_database($database_directory, 'timecarddatabase.txt');
$pay_database = load_database($database_directory, 'paydatabase.txt');
$employee_database = load_database($database_directory, 'employeedatabase.txt');
$positions_database = load_database($database_directory, 'positiondatabase.txt');
$authentication_database = load_database($database_directory, 'authenticationdatabase.txt');
$configuration_database = load_database($database_directory, 'configurationdatabase.txt');

?>
