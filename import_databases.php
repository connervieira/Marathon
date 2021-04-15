<?php

function load_database($database_to_load) {
    if (file_exists($database_to_load)) {  // Check to see if the database file exists.
        return unserialize(file_get_contents($database_to_load)); // Load the database.
    } else {
        echo "<p style='color:red;'>Error: Could not load database '" . $database_to_load . "'. The database file was not found.</p>";
    }
}

// Load all required databases
$timecard_database = load_database('./databases/timecarddatabase.txt');
$pay_database = load_database('./databases/paydatabase.txt');
$employee_database = load_database('./databases/employeedatabase.txt');
$positions_database = load_database('./databases/positionsdatabase.txt');

?>
