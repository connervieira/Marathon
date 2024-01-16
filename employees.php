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
        <title>Marathon - Manage Employees</title>

        <link rel="stylesheet" href="./assets/css/Projects-Clean.css">
        <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="./assets/css/main.css">
    </head>

    <body>
        <div class="centered">
            <?php
            include('./import_databases.php');
            ?>
        </div>
        <a class="button" role="button" href="index.php">Back</a>
        <div class="intro">
            <h1>Marathon</h1>
            <h2>Manage Employees</h2>
        </div>
        <main class="centered">
            <h3>Add/Edit Employee</h3>
            <?php 
            if ($_GET["editing"] == "true") {
                echo '
                <form style="color:white;" action="employeeadd.php" method="POST">
                    <label for="id">ID Number:</label><input placeholder="ID Number" name="id" type="number"><br>
                    <label for="firstname">First Name:</label><input placeholder="First Name" name="firstname" required><br>
                    <label for="middlename">Middle Name:</label><input placeholder="Middle Name" name="middlename"><br>
                    <label for="lastname">Last Name:</label><input placeholder="Last Name" name="lastname"><br>
                    <label for="positionid">Position ID:</label><input placeholder="Position ID" name="positionid" type="number" required><br>
                    ';
                
                // Change the hourly pay "step" based on the currency defined in the configuration.
                $currency = strtolower($configuration_database["currency"]);
                if ($currency == "usd" or $currency == "eur" or $currency == "cad") { $currency_step = 0.01;
                } else if ($currency == "bch" or $currency == "xmr") { $currency_step = 0.00001;
                } else { $currency_step = 0.000000001; };
                echo '<label for="hourlypay">Hourly Pay:</label><input placeholder="Hourly Pay" name="hourlypay" step="' . $currency_step . '" min="0" type="number"><br>';
                
                
                echo '
                    <label for="gender">Gender:</label><input placeholder="Gender" name="gender"><br>
                    <label for="birthday">Birthday:</label><input placeholder="Last Name" name="birthday" type="date"><br>
                    <label for="phone">Phone:</label><input placeholder="Phone Number" name="phone" type="tel"><br>
                    <label for="email">Email:</label><input placeholder="Email" name="email" type="email"><br>
                    <label for="instantmessage">Instant Message Contact:</label><input placeholder="Instant Message Contact" name="instantmessage"><br>
                    <label for="address">Address:</label><input placeholder="Address" name="address" type="address"><br>
                    <label for="ssn">Social Security Number:</label><input placeholder="Social Security Number" name="ssn" type="number" minlength="9" maxlength="9"><br>
                    <label for="password">Employee Password/PIN:</label><input placeholder="Password/PIN" name="password" type="password" required><br>
                    <label for="tips">Tips:</label><input name="tips" type="checkbox"><br>

                    <br>
                    <label for="paymentinfo">Payment Information:</label><textarea style="width:100%;height:400px;" row="15" type="text" name="paymentinfo" placeholder="Bank account information, cryptocurrency address, etc."></textarea>
                    <input type="submit" class="button">
                </form>
                ';
            } else {
                echo '<a class="button" role="button" href="employees.php?editing=true">Add/Edit Employee</a>';
            }
            ?>

            <hr class="separator">

            <h3>Current Employees</h3>
            <?php
            foreach ($employee_database as $key => $element) {
                echo "<h3><b>Name</b>: " . $element["firstname"] . " " . $element["middlename"] . " " . $element["lastname"] . "</h3>";
                echo "<p><b>ID Number</b>: " . $key . "</p>";
                if (isset($positions_database[$element["positionid"]])) {
                    echo "<p><b>Position</b>: " . $positions_database[$element["positionid"]]["name"] . " (ID: " . $element["positionid"] . ")</p>";
                } else {
                    echo "<p><b>Position</b>: " . $element["positionid"] . "</p>";
                }
                if ($element["birthday"] !== null and $element["birthday"] !== "") {
                    echo "<p><b>Birthday</b>: " . $element["birthday"] . "</p>";
                }
                if ($element["hourlypay"] !== null and $element["hourlypay"] !== "" and $element["hourlypay"] !== 0) {
                    echo "<p><b>Hourly Pay</b>: " . $element["hourlypay"] . "</p>";
                }
                if ($element["gender"] !== null and $element["gender"] !== "") {
                    echo "<p><b>Gender</b>: " . $element["gender"] . "</p>";
                }
                if ($element["phone"] !== null and $element["phone"] !== "") {
                    echo "<p><b>Phone</b>: " . $element["phone"] . "</p>";
                }
                if ($element["email"] !== null and $element["email"] !== "") {
                    echo "<p><b>Email</b>: " . $element["email"] . "</p>";
                }
                if ($element["instantmessage"] !== null and $element["instantmessage"] !== "") {
                    echo "<p><b>Instant Message</b>: " . $element["instantmessage"] . "</p>";
                }
                if ($element["address"] !== null and $element["address"] !== "") {
                    echo "<p><b>Address</b>: " . $element["address"] . "</p>";
                }
                if ($element["ssn"] !== null and $element["ssn"] !== "") {
                    echo "<p><b>Social Security Number</b>: " . $element["ssn"] . "</p>";
                }
                if ($element["tips"] == "on") {
                    echo "<p><b>Tips</b>: Allowed</p>";
                } else {
                    echo "<p><b>Tips</b>: Disallowed</p>";
                }
                if ($element["paymentinfo"] !== null and $element["paymentinfo"] !== "") {
                    echo "<p><b>Payment Info</b>: " . $element["paymentinfo"] . "</p>";
                }
                echo '<a class="button" role="button" href="employeeremove.php?id=' . $key . '">Delete Employee</a>';
                echo "<br><br>";
            }
            ?>
        </main>
    </body>
</html>
