<!-- V0LT - Marathon -->
<?php
session_start(); // Start a PHP session.
if ($_SESSION['loggedin'] == 1) { // Check to see if the user is logged in.
    $username = $_SESSION['username']; // Set the '$username' variable to the currently signed in user's username.
} else {
    header("Location: login.php"); // Redirect the user to the login page.
    exit();
}
include('./import_databases.php');

$employee_to_view = $_GET["employee"];



$background_gradient_bottom = "#000000";
$background_gradient_top = "#444444";
?>
<!DOCTYPE html>
<html lang="en" style="background:<?php echo $background_gradient_bottom; ?>;">
    <head>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Marathon - View Payment Information</title>

        <link rel="stylesheet" href="./assets/css/Projects-Clean.css">
        <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css">
    </head>

    <body style="color:#111111;">
        <div class="projects-clean" style="background:linear-gradient(0deg, <?php echo $background_gradient_bottom; ?>, <?php echo $background_gradient_top; ?>);color:#111111;">
            <div class="container" style="padding-top:100px;">
                <main>
                    <a class="btn btn-primary" role="button" href="tools.php" style="background-color:#444444;border-color:#eeeeee">Back</a>
                    <div class="intro">
                        <p class="text-center" style="padding-bottom:54px;color:#dddddd;font-size:40px;">View Payment Information</p>
                    </div>
                    <div style="text-align:center;color:white;">
                        <?php
                            if ($employee_to_view != null and $employee_to_view != "") { // Check if the user as selected an employee to view.
                                echo "
                                <form>
                                    <label for='employee'>Employee ID: </label><input name='employee' type='text' placeholder='Employee ID'>
                                </form>
                                ";
                                if (isset($employee_database[$employee_to_view]) == true) { // Check if the employee exists.
                                    if ($employee_database[$employee_to_view]["paymentinfo"] !== "" and $employee_database[$employee_to_view]["paymentinfo"] !== null) { // Check if the selected employee has payment information on file.
                                        echo "<p style='color:white;font-size:25px;'>" . $employee_database[$employee_to_view]["firstname"] . " " . $employee_database[$employee_to_view]["lastname"] . "'s Payment Information</p>";
                                        echo "<p style='color:white;white-space:pre-line;'>" . $employee_database[$employee_to_view]["paymentinfo"] . "</p>";
                                    } else {
                                        echo "<p style='color:red;'>Error: The selected employee doesn't have any payment information on file.</p>";
                                    }
                                } else {
                                    echo "<p style='color:red;'>Error: There is no employee with the specified employee ID.</p>";
                                }
                            } else {
                                echo "
                                <form>
                                    <label for='employee'>Employee ID: </label><input name='employee' type='text' placeholder='Employee ID'>
                                </form>
                                ";
                            }
                        ?>
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
