# Security

This document contains important security practices and and information regarding Marathon.


## Disclaimer

While I strive to keep Marathon stable, reliable, and secure, I'm a single-person developer, and I'm bound to miss things. I highly encourage all users to audit Marathon themselves before using it in a production enviroment, and to take all appropriate precautionary security steps, as described below.


## Precautions

Below are several precautions you should take while installing Marathon to ensure the best possible security.

- Keep the Marathon database directory in a location that isn't accessible over a webserver.
    - The database directory (as defined in `import_database.php`) contains databases that shouldn't be public information. Ensure only authorized users can access this information.
- Only allow trusted users to access your Marathon instance.
    - Marathon is designed to be used interally for a business to track it's employee's shifts. If it can be avoided, don't make Marathon pubically accessible over the internet.
    - Provided your business's network is only accessible to authorized users, you can simply expose your Marathon instance to your local network.
    - If you do need to expose Marathon publically to the internet, make sure all admin accounts have secure passwords, and that new admin sign-ups are disabled.
        - If you need to add another admin account, do not turn off the 'Disable Admin Signups' configuration setting. Instead, follow these steps.
            1. Log in with an existing admin account.
            2. Navigate to the admin signup page at `/marathon/signup.php`.
            3. Enter a username and password for the new admin account.
