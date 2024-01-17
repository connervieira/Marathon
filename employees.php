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
            <h3>Add Employee</h3>
            <?php 
            if ($_GET["editing"] == "true") {
                echo '
                <form action="employeeadd.php" method="POST">
                    <label for="id">ID Number:</label><input placeholder="ID Number" name="id" id="id" type="number" value="' . $_GET["id"] . '"><br>
                    <label for="firstname">First Name:</label><input placeholder="First Name" name="firstname" id="firstname" value="' . $employee_database[$_GET["id"]]["firstname"] . '" required><br>
                    <label for="middlename">Middle Name:</label><input placeholder="Middle Name" name="middlename" id="middlename" value="' . $employee_database[$_GET["id"]]["middlename"] . '" ><br>
                    <label for="lastname">Last Name:</label><input placeholder="Last Name" name="lastname" id="lastname" value="' . $employee_database[$_GET["id"]]["lastname"] . '" ><br>
                    <label for="positionid">Position ID:</label><input placeholder="Position ID" name="positionid" id="positionid" type="number" value="' . $employee_database[$_GET["id"]]["positionid"] . '" required><br>
                    ';
                
                // Change the hourly pay "step" based on the currency defined in the configuration.
                $currency = strtolower($configuration_database["currency"]);
                if ($currency == "usd" or $currency == "eur" or $currency == "cad") { $currency_step = 0.01;
                } else if ($currency == "bch" or $currency == "xmr") { $currency_step = 0.00001;
                } else { $currency_step = 0.000000001; };
                echo '<label for="hourlypay">Hourly Pay:</label><input placeholder="Hourly Pay" name="hourlypay" id="hourlypay" step="' . $currency_step . '" min="0" type="number" value="' . $employee_database[$_GET["id"]]["hourlypay"] . '" ><br>';
                
                
                echo '
                    <label for="sex">Sex:</label><select id="sex" name="sex">
                        <option value="unspecified" '; if ($employee_database[$_GET["id"]]["sex"] == "unspecified") { echo 'selected'; } echo '>Unspecified</option>
                        <option value="male" '; if ($employee_database[$_GET["id"]]["sex"] == "male") { echo 'selected'; } echo '>Male</option>
                        <option value="female" '; if ($employee_database[$_GET["id"]]["sex"] == "female") { echo 'selected'; } echo '>Female</option>
                    </select><br>
                    <label for="birthday">Birthday:</label><input name="birthday" id="birthday" type="date" value="' . $employee_database[$_GET["id"]]["birthday"] . '" ><br>
                    <label for="phone">Phone:</label><input placeholder="Phone Number" name="phone" id="phone" type="tel" value="' . $employee_database[$_GET["id"]]["phone"] . '" ><br>
                    <label for="email">Email:</label><input placeholder="Email" name="email" id="email" type="email" value="' . $employee_database[$_GET["id"]]["email"] . '" ><br>
                    <label for="instantmessage">Instant Message Contact:</label><input placeholder="Instant Message Contact" name="instantmessage" id="instantmessage" value="' . $employee_database[$_GET["id"]]["instantmessage"] . '" ><br>
                    <label for="address">Address:</label><input placeholder="Address" name="address" id="address" type="address" value="' . $employee_database[$_GET["id"]]["address"] . '" ><br>
                    <label for="ssn">Social Security Number:</label><input placeholder="Social Security Number" name="ssn" id="ssn" type="number" minlength="9" maxlength="9" value="' . $employee_database[$_GET["id"]]["ssn"] . '" ><br>';
                
                echo '<label for="password">Employee Password/PIN:</label><input placeholder="'; if (isset($_GET["id"])) { echo "Leave Unchanged"; } else { echo 'Password/PIN'; } echo '" name="password" id="password" type="password"><br>';

                echo '<label for="tips">Tips:</label><input name="tips" id="tips" type="checkbox" '; if ($employee_database[$_GET["id"]]["tips"]) { echo "checked"; } echo '><br>';

                echo '<br>
                    <label for="paymentinfo">Payment Information:</label><textarea style="width:100%;height:400px;" row="15" type="text" name="paymentinfo" id="paymentinfo" placeholder="Bank account information, cryptocurrency address, etc.">' . $employee_database[$_GET["id"]]["paymentinfo"] . '</textarea>
                    <input type="submit" class="button">
                </form>
                ';
            } else {
                echo '<a class="button" role="button" href="employees.php?editing=true">Add Employee</a>';
            }
            ?>

            <hr class="separator-thin">

            <h3>View Employees</h3>
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
                if ($element["sex"] !== null and $element["sex"] !== "") {
                    echo "<p><b>Sex</b>: " . $element["sex"] . "</p>";
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
                echo '<a class="button" role="button" href="employeeremove.php?id=' . $key . '">Delete</a>';
                echo '<a class="button" role="button" href="employees.php?editing=true&id=' . $key . '">Edit</a>';
                echo "<br><br>";
            }
            ?>
        </main>
    </body>
</html>
