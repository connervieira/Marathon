<!-- V0LT - Marathon -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Marathon - Admin Sign Up</title>

        <link rel="stylesheet" href="./assets/css/main.css">
    </head>
    <body>
        <div class="centered">
            <?php include('./import_databases.php'); ?>
        </div>
        <div class="centered header">
            <h1>Marathon</h1>
            <h2>Admin Sign Up</h2>
        </div>
        <main>
            <form method="POST" class="centered" action="createaccount.php">
                <label for="username">Username:</label> <input name="username" type="text" placeholder="Username"><br>
                <label for="password1">Password:</label> <input minlength="8" name="password1" type="password" placeholder="Password"><br>
                <label for="password2">Password Confirmation:</label> <input minlength="8" name="password2" type="password" placeholder="Confirm Password"><br>
                <input type="submit">
            </form>
        </main>
    </body>
</html>
