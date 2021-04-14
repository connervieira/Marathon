<?php

function load_database($database_to_load) {
    if (file_exists($database_to_load)) {  // Check to see if the database file exists.
        if (unserialize(file_get_contents($database_to_load))) { // Check to see if the database file contains valid searialized data.
            $timecard_database = unserialize(file_get_contents($database_to_load)); // Load the database.
        } else {
            echo "<p style='color:red;'>Error: Could not load database '" . $database_to_load . "'. The database appears to be invalid.</p>";
        }
    } else {
        echo "<p style='color:red;'>Error: Could not load database '" . $database_to_load . "'. The database file was not found.</p>";
    }
}

// Load all required databases
load_database('./timecarddatabase.txt');
load_database('./paydatabase.txt');
load_database('./employeesdatabase.txt');
load_database('./positionsdatabase.txt');

?>
