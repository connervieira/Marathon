<!-- V0LT - Marathon -->
<?php
$background_gradient_bottom = "#000000";
$background_gradient_top = "#444444";
?>
<!DOCTYPE html>
<html lang="en" style="background:<?php echo $background_gradient_bottom; ?>;">
    <head>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Marathon - Manage Positions</title>

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
                        <p class="text-center" style="padding-bottom:54px;color:#dddddd;font-size:40px;">Manage Positions</p>
                    </div>
                    <div style="text-align:center;">
                        <p style="font-size:30px;">Add New Postition</p>
                        <?php 
                        if ($_GET["editing"] == "true") {
                            echo '
                            <form action="positionadd.php" method="POST">
                                <label for="id">ID Number:</label><input placeholder="ID Number" name="id"><br>
                                <label for="name">Position Name:</label><input placeholder="First Name" name="name" required><br>
                                <label for="defaultpayamount">Default Pay Amount:</label><input placeholder="Default Pay Amount" name="defaultpayamount" type="number" step="any"><br>
                                <label for="canclockin">Can Clock In:</label><input name="canclockin" type="checkbox" checked><br>
                                <label for="description">Position Description:</label><textarea style="width:100%;height:400px;" row="15" type="text" name="description" placeholder="Position description"></textarea>

                                <br>
                                <input type="submit">
                            </form>
                            ';
                        } else {
                            echo '<a class="btn btn-primary" role="button" href="positions.php?editing=true" style="background-color:#444444;border-color:#eeeeee">Add/Edit Positions</a>';
                        }
                        ?>

                        <hr style="border-width:5px;">

                        <p style="font-size:30px;">Current Positions</p>
                        <?php
                        foreach ($positions_database as $key => $element) {
                            echo "<p style='font-size:25px;'><b>Position Name</b>: " . $element["name"] . "</p>";
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
                            echo '<a class="btn btn-primary" role="button" href="positionremove.php?id=' . $key . '" style="background-color:#444444;border-color:#eeeeee">Delete Position</a>';
                            echo "<br><br>";
                        }
                        ?>
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
