<!-- V0LT - Marathon-->
<?php
$background_gradient_bottom = "#000000";
$background_gradient_top = "#444444";
?>
<!DOCTYPE html>
<html lang="en" style="background:<?php echo $background_gradient_bottom; ?>;">
    <head>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Marathon - Manage Employees</title>

        <link rel="stylesheet" href="./assets/css/Projects-Clean.css">
        <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css">
    </head>

    <body style="color:#111111;">
        <div class="projects-clean" style="background:linear-gradient(0deg, <?php echo $background_gradient_bottom; ?>, <?php echo $background_gradient_top; ?>);color:#111111;">
            <div class="container" style="padding-top:100px;">
                <div style="text-align:center;">
                    <?php
                    include('./import_databases.php');
                    ?>
                </div>
                <main>
                    <div class="intro">
                        <p class="text-center" style="padding-bottom:54px;color:#dddddd;font-size:40px;">Manage Employees</p>
                    </div>
                    <div style="text-align:center;">
                        <p style="font-size:30px;">Add New Employee</p>
                        <?php 
                        if ($_GET["editing"] == "true") {
                            echo '
                            <form action="employeeadd.php" method="POST">
                                <label for="id">ID Number:</label><input placeholder="ID Number" name="id"><br>
                                <label for="firstname">First Name:</label><input placeholder="First Name" name="firstname" required><br>
                                <label for="middlename">Middle Name:</label><input placeholder="Middle Name" name="middlename"><br>
                                <label for="lastname">Last Name:</label><input placeholder="Last Name" name="lastname"><br>
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
                                <input type="submit">
                            </form>
                            ';
                        } else {
                            echo '<a class="btn btn-primary" role="button" href="employees.php?editing=true" style="background-color:#444444;border-color:#eeeeee">Add/Edit Employee</a>';
                        }
                        ?>

                        <hr style="border-width:5px;">

                        <p style="font-size:30px;">Current Employees</p>
                        <?php
                        foreach ($employee_database as $key => $element) {
                            echo "<p style='font-size:25px;'><b>Name</b>: " . $element["firstname"] . " " . $element["middlename"] . " " . $element["lastname"] . "</p>";
                            echo "<p><b>ID Number</b>: " . $key . "</p>";
                            if ($element["birthday"] !== null and $element["birthday"] !== "") {
                                echo "<p><b>Birthday</b>: " . $element["birthday"] . "</p>";
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
                            echo '<a class="btn btn-primary" role="button" href="employeeremove.php?id=' . $key . '" style="background-color:#444444;border-color:#eeeeee">Delete Employee</a>';
                            echo "<br><br>";
                        }
                        ?>
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
