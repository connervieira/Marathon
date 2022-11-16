# Change Log
This file explains what changes are made to Marathon based on version.


## v0.1

- Initial release (Basic functionality)


## v1.0

- Fixed an issue that caused the timecard database to fail to initialize.
- Added a 'paid shift' viewer that allows admins to revert shifts from paid to unpaid in the event of a mistake.
- Added an 'all shift' viewer that allows admins to invalide shifts from the timecard database.
    - Invalidating a shift effectively deletes it, and it is no longer included in statistics or payment data.
    - It should be noted that invalidating or deleting a shift from the database does not (and cannot) invalidate it's confirmation hash, meaning an employee can still prove they worked a shift, even after it has been deleted from the database.
- Added 'Back' buttons to some admin pages to make navigation more conveinent.
- Fixed an issue where shift pay was calculated inaccurately on the 'Timecard Receipts' page.
- Fixed an issue where hourly pay rates would be saved without a decimal point.
- Disabled autofill on certain field where it isn't appropriate.
- The 'view payment information' tool no longer hides the username input when a user is displayed.
- Added a button to return to the login page after create a new admin account.
- Added short tagline descriptions to each of the main links on the main administrator page.
- Added admin account management system.
    - Admin accounts can now be deleted from the web interface by other admins.
- Replaced several exclamation points on the login pages with periods for sake of professionalism.
- The employee tips permission is now stored as a boolean value instead of a string.
- The form information on the Positions page now appears white.
- All of any employee's timecard receipts are now deleted when their account is deleted.
    - This does not (and can not) invalidate shift confirmation hashes saved by the employee.
- Changed the method by which unpaid shift are counted on the Statistics page.
    - The statistics will no longer count unpaid shifts from employees that no longer exist in the employee database.
        - Practically, this should change nothing, since timecard receipts are now deleted when employees are deleted, but it should improve backwards compatibility and redundancy.
- Significantly changed the way databases are loaded.
    - The databases files are now loaded from an admin-defined directory.
        - This makes it easy to update Marathon without changing the databases.
    - Database files are now created my Marathon during setup, instead of coming bundled with the program.
        - This makes read/write permissions more reliable and consistent.
    - Added checks to the database importing process to make sure the databases are writable.
- The text on the log-out page is now centered.
- Database loading errors are now shown inside the webpage body on the login pages.
    - This improves formatting and style consistency.
- Negative hourly rates can no longer be entered.
- Added recognition for EUR and CAD currencies.
- The signup page can now override the 'Disable Admin Signups' configuration value if an existing admin is signed in.
    - This allows admins to create new admin accounts, without needing to enable admin signups.
    - The 'Back' button on the post-signup page now links to the index page, not the login page.
        - If the user is not signed in, they will be redirected to the login page regardless.
    - Errors on the sign-up page are now centered for sake of formatting and consistency.
