<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Marathon - Remove Position</title>
    </head>
    <body>
        <?php
        include("./import_databases.php");

        $id_to_delete = $_GET["id"];
        $confirmation = $_GET["confirmation"];

        if ($confirmation !== "true") { // If the user hasn't yet pressed 'Confirm', the display the 'Confirm' button.
            echo "<p>Confirm deletion</p>";
            echo "<p><a href='positionremove.php?id=" . $id_to_delete . "&confirmation=true'>Confirm</a></p>";
            echo "<p><a href='positions.php'>Cancel</a></p>";
        } else { // Otherwise, delete the position.
            unset($positions_database[$id_to_delete]); // Remove the position from the database
            file_put_contents('./databases/positiondatabase.txt', serialize($position_database)); // Write array changes to disk
            echo "<p>Position deleted</p>";
            echo "<p><a href='positions.php'>Back</a></p>";
        }
        ?>
    </body>
</html>
