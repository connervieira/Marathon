<!-- V0LT - Marathon -->
<?php
session_start(); // Start a PHP session.
if ($_SESSION['authid'] == "marathon" and $_SESSION['loggedin'] == 1) { // Check to see if the user is logged in.
    $username = $_SESSION['username']; // Set the '$username' variable to the currently signed in user's username.
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
        <title>Marathon - Verify Shift</title>

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
                    <a class="btn btn-primary" role="button" href="index.php" style="background-color:#444444;border-color:#eeeeee">Back</a>
                    <div class="intro">
                        <p class="text-center" style="padding-bottom:54px;color:#dddddd;font-size:40px;">Verify Shift</p>
                    </div>
                    <div style="text-align:center;">
                        <form method="GET">
                            <label for="hash">Hash:</label><input placeholder="Hash" name="hash" required><br>
                            <label for="key">Key:</label><input placeholder="Key" name="key" type="password"><br>
                            <input type="submit">
                        </form>
                    </div>
                    <?php
                    if ($_GET["hash"] !== null and $_GET["hash"] !== "") {
                        if ($_GET["key"] == "") {
                            $decrypted_verification_data = openssl_decrypt($_GET["hash"], "AES-128-CTR", $configuration_database["clockinverificationkey"], 0, "1");
                        } else {
                            $decrypted_verification_data = openssl_decrypt($_GET["hash"], "AES-128-CTR", $_GET["key"], 0, "1");
                        }
                        echo "<p>" . $decrypted_verification_data . "</p>";
                    }
                    ?>

                </main>
            </div>
        </div>
    </body>
</html>
