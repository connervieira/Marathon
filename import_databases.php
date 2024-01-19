<?php

$database_directory = "/var/www/protected/marathondatabases/"; // This specifies where Marathon will create and store it's databases.



// Define function to check if a database exists and load it if it does.
function load_database($database_to_load) {
    global $database_directory;
    if (file_exists($database_directory)) { // Check to make sure the database directory exists.
        if (is_writable($database_directory)) { // Check to make sure the database directory is writable.
            if (!file_exists($database_directory . "/" . $database_to_load)) {  // Check to see if the database file doesn't exists.
                file_put_contents($database_directory . "/" . $database_to_load, "{}"); // Save a blank placeholder to the database file.
            }
            if (file_exists($database_directory . "/" . $database_to_load)) {  // Check to see if the database file exists. It should have been created in a previous step if not.
                return json_decode(file_get_contents($database_directory . "/" . $database_to_load), true); // Load the database.
                if (is_writable($database_directory . "/" . $database_to_load)) { // Check to make sure the database itself is writable.
                    echo "<p style='color:red;'>Error: The database '" . $database_to_load . "' is not writable.</p>"; // Alert that the database is not writable.
                }
            } else {
                echo "<p style='color:red;'>Error: Could not load database '" . $database_to_load . "'. The database file was not found.</p>"; // Alert that the database couldn't be opened.
            }
        } else {
            echo "<p style='color:red;'>Error: Could not load database '" . $database_to_load . "'. The database directory (" . $database_to_load . ") is not writable.</p>"; // Alert that the database couldn't be opened.
        }
    } else {
        echo "<p style='color:red;'>Error: Could not load database '" . $database_to_load . "'. The database directory (" . $database_to_load . ") does not exist.</p>"; // Alert that the database couldn't be opened.
    }
}

function save_database($database_file, $data) {
    global $database_directory;
    file_put_contents($database_directory . '/' . $database_file, json_encode($data, (JSON_UNESCAPED_SLASHES))); // Write array changes to disk.
}

// Load all required databases
$timecard_database = load_database('timecarddatabase.json');
$employee_database = load_database('employeedatabase.json');
$positions_database = load_database('positiondatabase.json');
$authentication_database = load_database('authenticationdatabase.json');
$configuration_database = load_database('configurationdatabase.json');
?>
