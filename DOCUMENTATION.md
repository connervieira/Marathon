# Documentation

This document stores information about Marathon, how to set it up, how it works, and how to use it!

Marathon is still very much a work in progress. This document will be filled out throughout the development of Marathon as features are developed and added.


### Adding Employees

Marathon makes it easy to add employees to the database. To add an employee to Marathon, follow these steps.

1. Sign into your admin account.
2. Click through to the 'Employees' page.
3. On the employee's page, click 'Add/Edit Employee'.
4. In the form that appears, fill out the employee's information using the descriptions below.
    - **ID Number**
        - A unique number that identifies this employee.
        - If left blank, a unique number will be randomly generated.
    - **First Name** (required)
        - The first name of the employee.
    - **Middle Name**
        - The middle name of the employee.
    - **Last Name**
        - The last name of the employee.
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
        - This value is simple a string, allowing you to put the contact information for really any service you want. For exmaple, if your business uses Matrix to communicate with employees, you may put this employee's Matrix contact information here.
    - **Address**
        - This employee's home address.
    - **Social Security Number**
        - The social security number of the employee.
        - It is important to note that this value is stored in the database as an unencrypted value.
    - **Employee Password/PIN** (Required)
        - This is the password or PIN that this employee will use to sign into their account in order to clock in and perform other tasks.
    - **Tips**
        - This determines whether or not the employee is allowed to accept tips.
    - **Payment Information**:
        - This field is for the employee's payment information.
        - You can store any string here, including bank account information, cryptocurrency addresses, or other payment processor information.
