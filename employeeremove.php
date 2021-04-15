<?php
include("./import_databases.php");

$id_to_delete = $_GET["id"];
$confirmation = $_GET["confirmation"];

if ($confirmation !== "true") {
    echo "<p>Confirm deletion</p>";
    echo "<p><a href='employeeremove.php?id=" . $id_to_delete . "&confirmation=true'>Confirm</a></p>";
    echo "<p><a href='employees.php'>Cancel</a></p>";
    exit();
} else {
    $employee_database[$id_to_delete] = "deleted";
    file_put_contents('./databases/employeedatabase.txt', serialize($employee_database)); // Write array changes to disk
    echo "<p>Employee deleted</p>";
}

?>
