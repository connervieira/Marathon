<!-- V0LT - Marathon -->
<?php
session_start(); // Start a PHP session.
if ($_SESSION['authid'] == "marathon" and $_SESSION['loggedin'] == 1) { // Check to see if the user is logged in.
    $username = $_SESSION['username']; // Set the '$username' variable to the currently signed in user's username.
} else {
    header("Location: login.php"); // Redirect the user to the login page.
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Marathon - Manage Positions</title>

        <link rel="stylesheet" href="./assets/css/main.css">
    </head>

    <body>
        <div style="text-align:center;">
            <?php include('./import_databases.php'); ?>
        </div>
        <main>
            <a class="button" role="button" href="index.php">Back</a>
            <div class="header centered">
                <h1>Marathon</h1>
                <h2>Manage Positions</h2>
            </div>
            <div class="centered">
                <h3>Add Postition</h3>
                <?php 
                if ($_GET["editing"] == "true") {
                    echo '<form action="positionadd.php" method="POST" >';
                    echo '<label for="id">ID Number:</label><input placeholder="ID Number" name="id" id="id" type="number" value="' . $_GET["id"] . '"><br>';
                    echo '<label for="name">Position Name:</label><input placeholder="Position Name" name="name" id="name" value="' . $positions_database[$_GET["id"]]["name"] . '"required><br>';

                    // Change the hourly pay "step" based on the currency defined in the configuration.
                    $currency = strtolower($configuration_database["currency"]);
                    if ($currency == "usd" or $currency == "eur" or $currency == "cad") { $currency_step = 0.01;
                    } else if ($currency == "bch" or $currency == "xmr") { $currency_step = 0.00001;
                    } else { $currency_step = 0.000000001; };
                    echo '<label for="defaultpayamount">Default Pay Amount:</label><input placeholder="Default Pay Amount" name="defaultpayamount" id="defaultpayamount" type="number" step="' . $currency_step . '" min="0" value="' . $positions_database[$_GET["id"]]["defaultpayamount"] . '"><br>';

                    echo '<label for="canclockin">Can Clock In:</label><input name="canclockin" id="canclockin" type="checkbox" '; if ($positions_database[$_GET["id"]]["canclockin"]) { echo "checked"; } echo '><br>';
                    echo '<label for="description">Position Description:</label><textarea style="width:100%;height:400px;" row="15" type="text" name="description" placeholder="Position description">' . $positions_database[$_GET["id"]]["description"] . '</textarea><br>';
                    echo '<input class="button" type="submit">';
                    echo '</form>';
                } else {
                    echo '<a class="button" role="button" href="positions.php?editing=true">Add Position</a>';
                }
                ?>

                <hr class="separator-thin">

                <h3>View Positions</h3>
                <?php
                foreach ($positions_database as $key => $element) {
                    echo "<h4><b>Position Name</b>: " . $element["name"] . "</h4>";
                    echo "<p><b>ID Number</b>: " . $key . "</p>";
                    if ($element["defaultpayamount"] !== null and $element["defaultpayamount"] !== "") {
                        echo "<p><b>Default Pay Amount</b>: " . $element["defaultpayamount"] . "</p>";
                    }
                    if ($element["canclockin"] == "on") {
                        echo "<p><b>Can Clock In</b>: Allowed</p>";
                    } else {
                        echo "<p><b>Can Clock In</b>: Disallowed</p>";
                    }
                    if ($element["description"] !== null and $element["description"] !== "") {
                        echo "<p><b>Description</b>: " . $element["description"] . "</p>";
                    }
                    echo '<a class="button" role="button" href="positionremove.php?id=' . $key . '">Delete</a>';
                    echo '<a class="button" role="button" href="positions.php?editing=true&id=' . $key . '">Edit</a>';
                    echo "<br><br>";
                }
                ?>
            </div>
        </main>
    </body>
</html>

