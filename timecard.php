<!-- V0LT - Marathon -->
<?php
session_start(); // Start a PHP session.
if ($_SESSION['loggedin'] == 2) { // Check to see if the user is logged in.
    $username = (string)$_SESSION['username']; // Set the '$username' variable to the currently signed in user's username.
} else {
    header("Location: login.php"); // Redirect the user to the login page.
    exit();
}

$background_gradient_bottom = "#000000";
$background_gradient_top = "#444444";
?>
<!DOCTYPE html>
<html lang="en" style="background:<?php echo $background_gradient_bottom; ?>;">
    <head>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Marathon - Employee Timecard</title>

        <link rel="stylesheet" href="./assets/css/Projects-Clean.css">
        <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css">
    </head>

    <body style="color:#111111;">
        <div class="projects-clean" style="background:linear-gradient(0deg, <?php echo $background_gradient_bottom; ?>, <?php echo $background_gradient_top; ?>);color:#111111;">
            <?php
            include('./import_databases.php');

            $clock_action = $_GET["clock"];

            if ($clock_action == "in" or $clock_action == "out" or $clock_action == "" or $clock_action == null) {
                if ($clock_action == "in") { // Clock the employee in
                    if (isset($timecard_database[$username][key(array_slice($timecard_database[$username], -1, 1, true))]["timeout"]) == false and isset($timecard_database[$username][key(array_slice($timecard_database[$username], -1, 1, true))]["timein"]) == true) {
                        echo "<p style='color:red;'>Error: You appear to already be clocked in!</p>";
                        exit();
                    }
                    $clock_record["valid"] = true;
                    $clock_record["timein"] = time();
                    if (isset($timecard_database[$username]) == false) {
                        $timecard_database[$username] = array();
                    }
                    array_push($timecard_database[$username], $clock_record);
                    file_put_contents('./databases/timecarddatabase.txt', serialize($timecard_database)); // Write array changes to disk
                    echo "<p style='color:white;'>You have successfully clocked in!</p>";
                    exit();
                } elseif ($clock_action == "out") { // Clock the employee out
                    if (isset($timecard_database[$username][key(array_slice($timecard_database[$username], -1, 1, true))]["timeout"]) == false and isset($timecard_database[$username][key(array_slice($timecard_database[$username], -1, 1, true))]["timein"]) == true) {
                        $timecard_database[$username][key(array_slice($timecard_database[$username], -1, 1, true))]["timeout"] = time();
                        file_put_contents('./databases/timecarddatabase.txt', serialize($timecard_database)); // Write array changes to disk
                        echo "<p style='color:white;'>You have successfully clocked out!</p>";
                        exit();
                    } else {
                        echo "<p style='color:red;'>Error: You don't appear to be clocked in!</p>";
                        exit();
                    }
                }
            }
            ?>
            <div class="container" style="padding-top:100px;">
                <a class="btn btn-primary" role="button" href="employeedashboard.php" style="background-color:#444444;border-color:#eeeeee">Back</a>
                <main>
                    <div class="intro">
                        <h2 class="text-center" style="color:#dddddd">Marathon</h2>
                        <p class="text-center" style="padding-bottom:54px;color:#dddddd;font-size:25px;">Employee Timecard</p>
                    </div>
                    <div class="row projects" style="padding-left:5%;padding-right:5%;color:white;">
                        <div class="col-sm-6 col-lg-4 item" style="margin:0;border-radius:15px;">
                            <h3>Clock In</h3>
                            <?php
                            if (isset($timecard_database[$username][key(array_slice($timecard_database[$username], -1, 1, true))]["timeout"]) == false and isset($timecard_database[$username][key(array_slice($timecard_database[$username], -1, 1, true))]["timein"]) == true) {
                                echo '<a class="btn btn-primary" role="button" href="#" style="background-color:#222222;border-color:#eeeeee;color:#888888;">Open</a>';
                            } else {
                                echo '<a class="btn btn-primary" role="button" href="timecard.php?clock=in" style="background-color:#444444;border-color:#eeeeee">Open</a>';
                            }
                            ?>
                        </div>
                        <div class="col-sm-6 col-lg-4 item" style="margin:0;border-radius:15px;">
                            <h3>Clock Out</h3>
                            <?php
                            if (isset($timecard_database[$username][key(array_slice($timecard_database[$username], -1, 1, true))]["timeout"]) == false and isset($timecard_database[$username][key(array_slice($timecard_database[$username], -1, 1, true))]["timein"]) == true) {
                                echo '<a class="btn btn-primary" role="button" href="#" style="background-color:#222222;border-color:#eeeeee;color:#888888;">Open</a>';
                            } else {
                                echo '<a class="btn btn-primary" role="button" href="timecard.php?clock=out" style="background-color:#444444;border-color:#eeeeee">Open</a>';
                            }
                            ?>
                            <a class="btn btn-primary" role="button" href="timecard.php?clock=out" style="background-color:#444444;border-color:#eeeeee">Open</a>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
