# Documentation

This document stores information about Marathon, how to set it up, how it works, and how to use it!

Marathon is still very much a work in progress. This document will be filled out throughout the development of Marathon as features are developed and added.

## Employee Management

### Adding Employees

Marathon makes it easy to add employees to the database. To add an employee to Marathon, follow these steps.

1. Sign into your admin account.
2. Click through to the 'Employees' page.
3. On the employee's page, click 'Add/Edit Employee'.
4. In the form that appears, fill out the employee's information using the descriptions below.
    - **ID Number**
        - A unique number that identifies this employee.
        - If left blank, a unique number will be randomly generated.
        - This value is also used to edit employees. See [Editing Employees](#editing-employees) for more information.
    - **First Name** (required)
        - The first name of the employee.
    - **Middle Name**
        - The middle name of the employee.
    - **Last Name**
        - The last name of the employee.
    - **Position ID**
        - The ID of this employee's position in the company.
        - This ID should correspond to a position created in the "Positions" menu in Marathon.
    - **Gender**
        - The gender of the employee.
        - This value is a string and doesn't restrict you to any specific values. For sake of organization, you should try to be consistent with how you define employee genders.
    - **Birthday**
        - The employee's date of birth.
    - **Phone**
        - The employee's phone number.
    - **Email**
        - The employee's email address.
    - **Instant Message Contact**
        - The contact information for an employee on a given instant messaging server.
        - This value is simply a string, allowing you to put the contact information for really any service you want. For exmaple, if your business uses Matrix to communicate with employees, you may put this employee's Matrix contact information here.
    - **Address**
        - This employee's home address.
    - **Social Security Number**
        - The social security number of the employee.
        - It is important to note that this value is stored in the database as an unencrypted value. For this reason, you may want to consider only storing the last 4 digits of each employee's social security number.
    - **Employee Password/PIN** (Required)
        - This is the password or PIN that this employee will use to sign into their account in order to clock in and perform other tasks.
    - **Tips**
        - This determines whether or not the employee is allowed to accept tips.
    - **Payment Information**:
        - This field is for the employee's payment information.
        - You can store any string here, including bank account information, cryptocurrency addresses, or other payment processor information.


### Deleting Employees

To delete an employee, follow these steps.

1. Click the 'Delete' button below an employee's information.
2. On the page that opens, click 'Confirm' to confirm that you're sure you'd like to delete this employee.


### Editing Employees

If you'd like to update an employee's information, you can do so by overwriting them with the edit function. To edit an employee, simply enter their ID number in the 'ID Number' field, and re-enter their information, adjusting it where necessary. This will allow you to change an employee's information without changing their ID number.


## Position Management

### Adding Positions

1. Sign into your admin account.
2. Click through to the 'Positions' page.
3. On the employee's page, click 'Add/Edit Position'.
4. In the form that appears, fill out the employee's information using the descriptions below.
    - **ID Number**
        - A unique number that identifies this position.
        - If left blank, a unique number will be randomly generated.
        - This value is also used to edit positions. See [Editing Positions](#editing-positions) for more information.
    - **Position Name**
        - This is the human-readable name of this position.
    - **Default Pay Amount**
        - This is the default amount that employees of this position will be paid per hour.
        - This will be over-ridden if an employee has a different pay amount set in their employee information.
    - **Can Clock In**
        - This determines whether or not employees of this position can clock in.
        - If an employee is paid full time and earns a fixed salary, you may want to disable this.
    - **Position Description**
        - A description and explanation of this position.
        - This value is fully optional and can be used to organize positions.


### Deleting Position

To delete a position, follow these steps.

1. Click the 'Delete' button below a position's information.
2. On the page that opens, click 'Confirm' to confirm that you're sure you'd like to delete this position.


### Editing Employees

If you'd like to update a position's information, you can do so by overwriting it with the edit function. To edit a position, simply enter its ID number in the 'ID Number' field, and re-enter its information, adjusting it where necessary. This will allow you to change a position's information without changing its ID number.

## Verifying Shift Verification Hashes

To verify a Shift Verification Hash, follow these instructions.
1. Log in to your admin account.
2. Click through to the 'Tools' page.
3. Click 'Open' under the 'Verify Shift' tool.
4. Paste in the Shift Verification Hash into the Hash field.
5. Click 'Submit'.
6. Enter your Shift Verification Key into the Key field.
    - If this field is left blank, the default key defined in the Marathon configuration will be used to decrypt the hash.
7. Press 'Submit'
8. The hash provided will be decrypted using the key provided. The output will be shown below the form. If you see random nonsensical characters, its possible one of the values were mistyped, or the hash is invalid. However, it's also possible that the hash was encrypted using a different key. This could have happened if you've changed your Clock In Verification key since this hash was created.
