<!-- V0LT - Marathon -->
<?php
session_start(); // Start a PHP session.
if ($_SESSION['loggedin'] == 1) { // Check to see if the user is logged in.
    $username = $_SESSION['username']; // Set the '$username' variable to the currently signed in user's username.
} else {
    header("Location: login.php"); // Redirect the user to the login page.
    exit();
}
$background_gradient_bottom = "#000000";
$background_gradient_top = "#444444";

$user_to_delete = $_GET["user"];
$confirmation = $_GET["confirm"];


$user_to_delete = preg_replace("/[^a-zA-Z0-9\ \-\.]/", '', $user_to_delete); // Sanitize the user string.

?>
<!DOCTYPE html>
<html lang="en" style="background:<?php echo $background_gradient_bottom; ?>;">
    <head>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Marathon - Delete Account</title>

        <link rel="stylesheet" href="./assets/css/Projects-Clean.css">
        <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css">
    </head>

    <body style="color:#111111;">
        <div class="projects-clean" style="background:linear-gradient(0deg, <?php echo $background_gradient_bottom; ?>, <?php echo $background_gradient_top; ?>);color:#111111;">
            <div class="container" style="padding-top:100px;">
                <div style="text-align:center;">
                    <?php include('./import_databases.php'); ?>
                </div>
                <main>
                    <a class="btn btn-primary" role="button" href="manageaccounts.php" style="background-color:#444444;border-color:#eeeeee">Back</a>
                    <div style="text-align:center;">
                        <?php
                        if (time() - $confirmation < 0) { // If the time between now and the confirmation timestamp is negative, then someone has likely manipulated the confirmation timestamp.
                            echo "<p class='text-center' style='color:#dddddd;font-size:20px;color:white;'>The confirmation timestamp was manipulated.</p>";
                            echo "<p class='text-center' style='color:#dddddd;font-size:15px;color:white;'>The confirmation timestamp is in the future, which means it's possible someone is trying to trick you into deleting an account. This should never happen under normal circustances. All accounts remain unmodified. If you opened this link from an external source, use caution with any further links you receive.</p>";
                        } else if (time() - $confirmation < 30) { // Check to see if the confirmation timestamp is less than 30 seconds from the current timestamp.
                            if (isset($authentication_database[$user_to_delete])) { // Check to see if the requested user to delete actually exists in the account database.
                                if ($username == $user_to_delete) { // Check to see if the user to delete is the same as the user currently logged in.
                                    // Log the user out.
                                    session_start();
                                    session_unset();
                                    session_destroy();
                                }
                                unset($authentication_database[$user_to_delete]); // Remove the user from the authentication database.
                                file_put_contents('./databases/authenticationdatabase.txt', serialize($authentication_database)); // Write array changes to disk.
                                echo "<p class='text-center' style='color:#dddddd;font-size:20px;color:white;'>Account deleted</p>";
                            } else {
                                echo "<p class='text-center' style='color:#dddddd;font-size:20px;color:white;'>The specified account doesn't exist in the authentication database.</p>";
                            }
                        } else {
                            echo "<p class='text-center' style='color:#dddddd;font-size:20px;color:white;'>Are you sure you would like to delete <b>" . $user_to_delete . "</b>?</p>";
                            if ($username == $user_to_delete) {
                                echo "<p class='text-center' style='color:#dddddd;font-size:15px;color:yellow;'>The account you're deleting is the account you're currently signed in as. If you delete this account, you will be logged out.</p>";
                                if ($configuration_database["disableadminsignups"] == true and sizeof($authentication_database) <= 1) { // Check to see if this is the last user in the database, and if admin signups are disabled.
                                    echo "<p class='text-center' style='color:#dddddd;font-size:15px;color:red;'>Additionally, there are no other admin accounts in the database, and admin signups are disabled. If you delete this account, you'll be locked out of the administrative portion of Marathon unless you manually edit the database.</p>";
                                }
                            }
                            echo "<a class='btn btn-primary' role='button' href='deleteaccount.php?user=" . $user_to_delete . "&confirm=" . time() . "' style='background-color:#444444;border-color:#eeeeee'>Confirm</a>";
                        }
                        ?>
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
